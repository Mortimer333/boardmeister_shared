<?php

declare(strict_types=1);

namespace App\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ImageDTO
{
    #[SWG\Property(example: '/media/images/image.png', description: 'Relative path to the image')]
    public string $source;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: TagDTO::class)
    ))]
    public array $tags;
}
