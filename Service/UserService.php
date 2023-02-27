<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\Api\User;
use Shared\Entity\Api\UserData;

class UserService
{
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
}
