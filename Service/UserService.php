<?php

declare(strict_types=1);

namespace Shared\Service;

use Doctrine\ORM\EntityManagerInterface;
use Shared\Entity\Api\User;
use Shared\Entity\Api\UserData;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    protected EntityManagerInterface $em;
    protected UserPasswordHasherInterface $passwordHasher;

    public function get(int $id): User
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw new \Exception('Cannot find selected user', 400);
        }

        return $user;
    }

    public function create(array $registration): User
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

    public function remove(int $id): void
    {
        $user = $this->get($id);
        $this->em->remove($user);
        $this->em->flush();
    }

    public function activate(int $id, string $token): void
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
}
