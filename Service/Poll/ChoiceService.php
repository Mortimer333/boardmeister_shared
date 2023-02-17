<?php

declare(strict_types=1);

namespace Shared\Service\Poll;

use Shared\Entity\Poll;
use Shared\Entity\Poll\Choice;
use Shared\Entity\Poll\Option;

class ChoiceService
{
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

        return $choice;
    }

    /**
     * @return array<string, int|string>
     */
    public function serialize(Choice $choice): array
    {
        return [
            'id' => $choice->getId(),
            'optionId' => $choice->getOption()->getId(),
        ];
    }

    public function create(int $optionId): Choice
    {
        $choiceEntity = new Choice();

        /** @var Option $option */
        $option = $this->em->getRepository(Option::class)->find($optionId);
        if (!$option) {
            throw new \Exception('Chosen option doesn\'t exist', 400);
        }

        $option->addChoice($choiceEntity);
        $this->findAndRemovePreviousChoice($choiceEntity);
        $this->em->persist($choiceEntity);
        $this->em->flush();

        return $choiceEntity;
    }
}
