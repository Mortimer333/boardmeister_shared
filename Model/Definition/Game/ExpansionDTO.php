<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Game;

use Shared\Model\Definition\ImageEntityDTO;
use Shared\Model\Definition\TagEntityDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ExpansionDTO
{
    #[SWG\Property(example: 'Desert of Hellscar', description: 'Full name of the expansion')]
    public string $name;

    #[SWG\Property(example: 'DoH', description: 'Alias of the expansion')]
    public ?string $alias;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: TagEntityDTO::class)
    ))]
    public array $tags;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: ImageEntityDTO::class)
    ))]
    public array $images;
}
