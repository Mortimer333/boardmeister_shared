<?php

declare(strict_types=1);

namespace Shared\Service\User;

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Shared\Entity\Api\User;
use Shared\Entity\Api\UserData;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManageService
{
    protected UserService $userService;
    protected EntityManagerInterface $em;
    protected UserPasswordHasherInterface $passwordHasher;

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
        $user = $this->userService->get($id);
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

    /**
     * @param array<string, mixed> $data
     */
    public function update(User $user, array $data): void
    {
        $userData = $user->getData();
        if (!$userData) {
            throw new \Exception('User data got detached, contact administrator', 500);
        }

        $fields = [
            'username' => 'setName',
            'sendNewsletter' => 'setSendNewsletter',
        ];

        foreach ($fields as $key => $setter) {
            if (!isset($data[$key])) {
                continue;
            }

            $userData->$setter($data[$key]);
        }

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
