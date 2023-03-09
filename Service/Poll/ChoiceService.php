<?php

declare(strict_types=1);

namespace Shared\Service\Poll;

use App\Service\UserService;
use Shared\Entity\Internal\Poll\Choice;
use Shared\Entity\Internal\Poll\Option;

class ChoiceService
{
    protected UserService $userService;

    /**
     * @return array<Choice>
     */
    public function list(): array
    {
        return $this->em->getRepository(Choice::class)->findAll();
    }

    public function get(int $choiceId): Choice
    {
        $choice = $this->em->getRepository(Choice::class)->find($choiceId);
        if (!$choice) {
            throw new \Exception('Choice with provided ID doesn\'t exist', 400);
        }

        $userId = $choice->getUserId();
        if ($userId) {
            try {
                $choice->setUser($this->userService->get($userId));
            } catch (\Exception) {
                // do nothing
            }
        }

        return $choice;
    }

    /**
     * @return array<string, int|string|array<string, mixed>|null>
     */
    public function serialize(Choice $choice): array
    {
        $serialized = [
            'id' => $choice->getId(),
            'optionId' => $choice->getOption()->getId(),
            'user' => null,
        ];

        if ($choice->getUser()) {
            $serialized['user'] = $this->userService->serialize($choice->getUser());
        }

        return $serialized;
    }

    public function create(int $optionId, int $userId): Choice
    {
        $choiceEntity = new Choice();
        $choiceEntity->setUserId($userId);

        /** @var Option $option */
        $option = $this->em->getRepository(Option::class)->find($optionId);
        if (!$option) {
            throw new \Exception('Chosen option doesn\'t exist', 400);
        }

        $option->addChoice($choiceEntity);
        $this->em->persist($option);
        $this->em->flush();

        return $this->get($choiceEntity->getId());
    }

    public function update(int $optionId, int $choiceId): Choice
    {
        /** @var Choice $choice */
        $choice = $this->get($choiceId);

        /** @var Option $option */
        $option = $this->em->getRepository(Option::class)->find($optionId);
        if (!$option) {
            throw new \Exception('Chosen option doesn\'t exist', 400);
        }

        $oldOption = $choice->getOption();
        $oldOption->removeChoice($choice);
        $this->em->persist($oldOption);

        $option->addChoice($choice);
        $this->em->persist($option);
        $this->em->flush();

        return $choice;
    }
}
