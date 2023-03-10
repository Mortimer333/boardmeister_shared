<?php

declare(strict_types=1);

namespace Shared\Service\Game;

use Doctrine\ORM\QueryBuilder;
use Shared\Entity\Internal\Game;
use Shared\Entity\Internal\Game\Expansion;

class ExpansionService
{
    public function serialize(Expansion $expansion): array
    {
        $tagsSerialized = [];
        foreach ($expansion->getTagValues() as $tag) {
            $tagsSerialized[] = $this->tagValueService->serialize($tag);
        }

        $imagesSerialized = [];
        foreach ($expansion->getImages() as $image) {
            $imagesSerialized[] = $this->imageService->serialize($image);
        }

        return [
            'id' => $expansion->getId(),
            'name' => $expansion->getName(),
            'alias' => $expansion->getAlias(),
            'code' => $expansion->getCode(),
            'tagValues' => $tagsSerialized,
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

    public function getByCode(string $code): Expansion
    {
        $expansion = $this->em->getRepository(Expansion::class)->findOneBy(['code' => $code]);
        if (!$expansion) {
            throw new \Exception('Expansion with provided code doesn\'t exist', 400);
        }

        return $expansion;
    }

    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<Expansion>
     */
    public function list(array $pagination, string $gameCode): array
    {
        $game = $this->em->getRepository(Game::class)->findOneBy(['code' => $gameCode]);

        return $this->em->getRepository(Expansion::class)->list(
            $pagination,
            function (QueryBuilder $queryBuilder) use ($game) {
                $queryBuilder->where('p.game = :game')
                    ->setParameter('game', $game)
                ;
            }
        );
    }
}
