<?php

declare(strict_types=1);

namespace Shared\Service\Poll;

use Shared\Entity\Poll\Choice;

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
    public function serialize(Choice $choice, bool $addIp = true): array
    {
        $choiceAr = [
            "id" => $choice->getId(),
        ];

        if ($addIp) {
            $choiceAr["ip"] = $choice->getIp();
        }

        return $choiceAr;
    }
}
