<?php

declare(strict_types=1);

namespace Shared\Service;

use App\Entity\Game;
use App\Entity\Image;
use App\Service\TagService;
use App\Service\ImageService;
use App\Service\Game\ExpansionService;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected ExpansionService $expansionService,
        protected TagService $tagService,
        protected ImageService $imageService,
    ) {
    }

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
        foreach ($game->getTags() as $tag) {
            $tagsSerialized[] = $this->tagService->serialize($tag);
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
            'tags' => $tagsSerialized,
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
