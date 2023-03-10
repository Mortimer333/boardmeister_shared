<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\Internal\Game;

class GameService
{
    /**
     * @return array<Game>
     */
    public function list(): array
    {
        return $this->em->getRepository(Game::class)->findAll();
    }

    public function get(int $gameId): Game
    {
        $game = $this->em->getRepository(Game::class)->find($gameId);
        if (!$game) {
            throw new \Exception('Game with provided ID doesn\'t exist', 400);
        }

        return $game;
    }

    public function getByCode(string $code): Game
    {
        $game = $this->em->getRepository(Game::class)->findOneBy(['code' => $code]);
        if (!$game) {
            throw new \Exception('Game with provided code name doesn\'t exist', 400);
        }

        return $game;
    }

    /**
     * @return array<string, int|string|array<int, array<string, int|string|null>>|null>
     */
    public function serialize(Game $game, bool $appendExpansions = false): array
    {
        $tagsSerialized = [];
        foreach ($game->getTagValues() as $tag) {
            $tagsSerialized[] = $this->tagValueService->serialize($tag);
        }

        $imagesSerialized = [];
        foreach ($game->getImages() as $image) {
            $imagesSerialized[] = $this->imageService->serialize($image);
        }

        $gameSerialized = [
            'id' => $game->getId(),
            'code' => $game->getCode(),
            'name' => $game->getName(),
            'alias' => $game->getAlias(),
            'tagValues' => $tagsSerialized,
            'images' => $imagesSerialized,
        ];

        if ($appendExpansions) {
            $expansions = [];
            foreach ($game->getExpansions() as $expansion) {
                $expansions[] = $this->expansionService->serialize($expansion);
            }

            $gameSerialized['expansions'] = $expansions;
        }

        return $gameSerialized;
    }
}
