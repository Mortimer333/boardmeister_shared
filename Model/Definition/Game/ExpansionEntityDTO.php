<?php

declare(strict_types=1);

namespace App\Shared\Model\Definition\Game;

use App\Shared\Model\Definition\ImageEntityDTO;
use App\Shared\Model\Definition\TagEntityDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ExpansionEntityDTO extends ExpansionDTO
{
    #[SWG\Property()]
    public int $id;
}
