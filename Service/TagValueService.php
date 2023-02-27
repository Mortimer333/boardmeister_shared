<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\Internal\TagValue;

class TagValueService
{
    public function get(int $tagId): TagValue
    {
        $tag = $this->em->getRepository(TagValue::class)->find($tagId);
        if (!$tag) {
            throw new \Exception('Cannot find selected tag', 400);
        }

        return $tag;
    }

    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<TagValue>
     */
    public function list(array $pagination): array
    {
        return $this->em->getRepository(TagValue::class)->list($pagination);
    }

    /**
     * @return array<string, int|string|null>
     */
    public function serialize(TagValue $tag): array
    {
        return [
            'id' => $tag->getId(),
            'value' => $tag->getValue(),
            'tag' => $this->tagService->serialize($tag->getTag()),
        ];
    }
}
