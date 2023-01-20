<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Game;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class GameEntityWithoutExpansionsDTO extends GameDTO
{
    #[SWG\Property()]
    public int $id;
}
