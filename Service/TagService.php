<?php

declare(strict_types=1);

namespace Shared\Service;

use App\Entity\Tag;

class TagService
{
    public function get(int $tagId): Tag
    {
        $tag = $this->em->getRepository(Tag::class)->find($tagId);
        if (!$tag) {
            throw new \Exception('Cannot find selected tag', 400);
        }

        return $tag;
    }

    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<Tag>
     */
    public function list(array $pagination): array
    {
        return $this->em->getRepository(Tag::class)->list($pagination);
    }

    /**
     * @return array<string, int|string|null>
     */
    public function serialize(Tag $tag): array
    {
        return [
            "id" => $tag->getId(),
            "name" => $tag->getName(),
        ];
    }
}
