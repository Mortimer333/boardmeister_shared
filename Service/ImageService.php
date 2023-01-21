<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\Image;

class ImageService
{
    public function get(int $imageId): Image
    {
        $image = $this->em->getRepository(Image::class)->find($imageId);
        if (!$image) {
            throw new \Exception('Cannot find selected image', 400);
        }

        return $image;
    }

    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<Image>
     */
    public function list(array $pagination): array
    {
        return $this->em->getRepository(Image::class)->list($pagination);
    }

    /**
     * @return array<string, int|string|array<int, array<string, int|string|null>>|null>
     */
    public function serialize(Image $image): array
    {
        $tagsSerialized = [];
        foreach ($image->getTagValues() as $tag) {
            $tagsSerialized[] = $this->tagValueService->serialize($tag);
        }

        return [
            'id' => $image->getId(),
            'source' => $image->getSource(),
            'tagValues' => $tagsSerialized,
        ];
    }
}
