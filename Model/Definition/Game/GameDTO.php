<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Game;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\ImageEntityDTO;
use Shared\Model\Definition\TagEntityDTO;

class GameDTO
{
    #[SWG\Property(example: 'cod', description: 'External key for game')]
    public string $code;

    #[SWG\Property(example: 'Chronicles of Drunagor', description: 'Full name of the game')]
    public string $name;

    #[SWG\Property(example: 'CoD:AoD', description: 'Alias of the game')]
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
