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

    public function updateEmail(User $user, ?string $email): void
    {
        $user->setNewEmail($email);
        $this->em->persist($user);
        $this->em->flush();
    }
}
