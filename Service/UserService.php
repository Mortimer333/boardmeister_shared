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
            'sendNewsletter' => $data->shouldSendNewsletter(),
        ];
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
}
