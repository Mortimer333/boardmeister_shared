<?php

declare(strict_types=1);

namespace Shared\Service\Game;

use Shared\Entity\Game\Expansion;

class ExpansionService
{
    public function serialize(Expansion $expansion): array
    {
        $tagsSerialized = [];
        foreach ($expansion->getTags() as $tag) {
            $tagsSerialized[] = $this->tagService->serialize($tag);
        }

        $imagesSerialized = [];
        foreach ($expansion->getImages() as $image) {
            $imagesSerialized[] = $this->imageService->serialize($image);
        }

        return [
            'id' => $expansion->getId(),
            'name' => $expansion->getName(),
            'alias' => $expansion->getAlias(),
            'tags' => $tagsSerialized,
            'images' => $imagesSerialized,
        ];
    }

    public function get(int $expansionId): Expansion
    {
        $expansion = $this->em->getRepository(Expansion::class)->find($expansionId);
        if (!$expansion) {
            throw new \Exception('Expansion with provided ID doesn\'t exist', 400);
        }

        return $expansion;
    }

    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<Expansion>
     */
    public function list(array $pagination): array
    {
        return $this->em->getRepository(Expansion::class)->list($pagination);
    }
}
