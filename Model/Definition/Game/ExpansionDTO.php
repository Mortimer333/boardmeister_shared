<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Game;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\ImageEntityDTO;
use Shared\Model\Definition\TagValueEntityDTO;

class ExpansionDTO
{
    #[SWG\Property(example: 'Desert of Hellscar', description: 'Full name of the expansion')]
    public string $name;

    #[SWG\Property(example: 'DoH', description: 'Alias of the expansion')]
    public ?string $alias;

    #[SWG\Property(example: 'doh', description: 'Unique code of the expansion')]
    public string $code;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: TagValueEntityDTO::class)
    ))]
    public array $tagValues;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: ImageEntityDTO::class)
    ))]
    public array $images;
}
