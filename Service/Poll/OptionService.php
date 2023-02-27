<?php

declare(strict_types=1);

namespace Shared\Service\Poll;

use Shared\Entity\Internal\Poll\Option;

class OptionService
{
    /**
     * @return array<Option>
     */
    public function list(): array
    {
        return $this->em->getRepository(Option::class)->findAll();
    }

    public function get(int $optionId): Option
    {
        $option = $this->em->getRepository(Option::class)->find($optionId);
        if (!$option) {
            throw new \Exception('Option with provided ID doesn\'t exist', 400);
        }

        return $option;
    }

    /**
     * @return array<string, string|array<array<string, mixed>>>
     */
    public function serialize(Option $option): array
    {
        $optionArr = [
            'id' => $option->getId(),
            'name' => $option->getName(),
            'choices' => count($option->getChoices()),
        ];

        return $optionArr;
    }
}
