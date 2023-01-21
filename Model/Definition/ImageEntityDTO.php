<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ImageEntityDTO extends ImageDTO
{
    #[SWG\Property()]
    public int $id;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: TagValueEntityDTO::class)
    ))]
    public array $tagValues;
}
