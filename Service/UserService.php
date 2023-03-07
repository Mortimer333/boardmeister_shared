<?php

declare(strict_types=1);

namespace Shared\Service;

use Doctrine\ORM\EntityManagerInterface;
use Shared\Entity\Api\User;
use Shared\Entity\Api\UserData;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserService
{
    protected EntityManagerInterface $em;
    protected UserPasswordHasherInterface $passwordHasher;
    protected Security $security;

    public function get(int $id): User
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw new \Exception('Cannot find selected user', 400);
        }

        return $user;
    }

    public function getLoggedInUser(): User
    {
        $user = $this->security->getUser();
        if (!$user) {
            throw new \Exception('User is not logged in', 400);
        }

        return $user;
    }

    /**
     * @return array{id: int|null, email: string, data: array<string, mixed>, created: string}
     */
    public function serialize(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'data' => $this->serializeData($user->getData()),
            'created' => date('Y-m-d H:i:s', $user->getCreated()),
        ];
    }

    /**
     * @return array{id: int|null, name: string|null}
     */
    public function serializeData(UserData $data): array
    {
        return [
            'id' => $data->getId(),
            'name' => $data->getName(),
        ];
    }

    public function validateUserRemoval(User $user, #[SensitiveParameter] string $password): void
    {
        if (!$this->verifyUserPassword($password, $user)) {
            throw new \Exception("Sent password doesn't match, user was not removed", 403);
        }
    }

    public function verifyUserPassword(
        #[SensitiveParameter] string $password,
        PasswordAuthenticatedUserInterface $user
    ): bool {
        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function create(#[SensitiveParameter] array $registration): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $registration['password']
        );

        $userData = new UserData();
        $userData->setName($registration['username']);

        $user->setEmail($registration['email'])
            ->setPassword($hashedPassword)
            ->setData($userData)
        ;

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function remove(int $id, bool $deleteAll = false): void
    {
        $user = $this->get($id);
        $data = $user->getData();
        if ($deleteAll) {
            $this->em->remove($data);
        } else {
            $data->setUser(null)
                ->setOldName($data->getName())      // saving old name to display it together with deletion date
                ->setName(null)                     // setting name to null to make it available for other users to use
                ->setDeleted(time())
            ;
            $this->em->persist($data);
        }
        $this->em->remove($user);
        $this->em->flush();
    }

    public function activate(int $id, #[SensitiveParameter] string $token): void
    {
        $user = $this->get($id);
        if ($user->isActivated()) {
            throw new \Exception('User is already activated', 400);
        }

        if (!empty($user->getActivationToken()) && $user->getActivationToken() !== $token) {
            throw new \Exception("Account wasn't activated", 400);
        }

        $user->setWhenActivated(time());
        $user->setActivationToken(null);
        $user->setActivated(true);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function deactivate(int $id): void
    {
        $user = $this->get($id);
        if (!$user->isActivated()) {
            throw new \Exception('User is already deactivated', 400);
        }

        $user->setActivationToken(null);
        $user->setActivated(false);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(User $user, array $data): void
    {
        $userData = $user->getData();
        if (!$userData) {
            throw new \Exception('User data got detached, contact administrator', 500);
        }

        /** @var string $username */
        $username = $data['username'] ?? throw new \Exception('Missing username', 500);
        $userData->setName($username);

        $this->em->persist($userData);
        $this->em->flush();
    }

    public function updateNewEmail(User $user, ?string $email): void
    {
        $user->setNewEmail($email);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function updateNewPassword(User $user, #[SensitiveParameter] ?string $password): void
    {
        if (is_null($password)) {
            $user->setNewPassword(null);
        } else {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setNewPassword($hashedPassword);
        }
        $this->em->persist($user);
        $this->em->flush();
    }

    public function verifyNewEmail(int $userId, #[SensitiveParameter] string $token): void
    {
        $user = $this->get($userId);
        if (empty($user->getEmailVerificationToken())) {
            throw new \Exception('No change request was created', 400);
        }

        if ($user->getEmailVerificationTokenExp() < time()) {
            throw new \Exception('Token has expired', 400);
        }

        if ($user->getEmailVerificationToken() !== $token) {
            throw new \Exception("Token didn't match", 403);
        }

        if (null === $user->getNewEmail()) {
            throw new \Exception('There is no new email to set', 500);
        }

        $user->setEmail($user->getNewEmail());
        $user->setNewEmail(null);
        $user->setEmailVerificationToken(null);
        $user->setEmailVerificationTokenExp(null);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function verifyNewPassword(int $userId, #[SensitiveParameter] string $token): void
    {
        $user = $this->get($userId);
        if (empty($user->getPasswordVerificationToken())) {
            throw new \Exception('No change request was created', 400);
        }

        if ($user->getPasswordVerificationTokenExp() < time()) {
            throw new \Exception('Token has expired', 400);
        }

        if ($user->getPasswordVerificationToken() !== $token) {
            throw new \Exception("Token didn't match", 403);
        }

        // Just double-checking if we are not setting empty password by mistake
        if (empty($user->getNewPassword())) {
            throw new \Exception('New password is empty', 500);
        }

        $user->setPassword($user->getNewPassword());
        $user->setNewPassword(null);
        $user->setPasswordVerificationToken(null);
        $user->setPasswordVerificationTokenExp(null);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function verifyResetPasswordToken(#[SensitiveParameter] string $token): User
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['passwordResetVerificationToken' => $token]);
        if (!$user) {
            throw new \Exception('Invalid token', 403);
        }

        if ($user->getPasswordResetVerificationTokenExp() < time()) {
            throw new \Exception('Token has expired', 400);
        }

        return $user;
    }

    public function resetPassword(User $user, #[SensitiveParameter] string $password): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setPasswordResetVerificationTokenExp(null);
        $user->setPasswordResetVerificationToken(null);
        $this->em->persist($user);
        $this->em->flush();
    }
}
