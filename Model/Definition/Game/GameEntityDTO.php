<?php

declare(strict_types=1);

namespace App\Shared\Model\Definition\Game;

use App\Shared\Model\Definition\ImageEntityDTO;
use App\Shared\Model\Definition\TagEntityDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class GameEntityDTO extends GameDTO
{
    #[SWG\Property()]
    public int $id;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: ExpansionEntityDTO::class)
    ))]
    public array $expansions;
}
