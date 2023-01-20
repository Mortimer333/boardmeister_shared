<?php

declare(strict_types=1);

namespace App\Model\Definition\Game;

use App\Model\Definition\ImageDTO;
use App\Model\Definition\ImageEntityDTO;
use App\Model\Definition\TagDTO;
use App\Model\Definition\TagEntityDTO;
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
