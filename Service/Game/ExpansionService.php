<?php

declare(strict_types=1);

namespace Shared\Service\Game;

use App\Entity\Game\Expansion;
use Shared\Service\ImageService;
use Shared\Service\TagService;
use Doctrine\ORM\EntityManagerInterface;

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
     * @return array<Expansion>
     */
    public function list(): array
    {
        return $this->em->getRepository(Expansion::class)->findAll();
    }
}
