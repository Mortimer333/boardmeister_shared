<?php

declare(strict_types=1);

namespace App\Model\Definition\Game;

use App\Model\Definition\ImageEntityDTO;
use App\Model\Definition\TagEntityDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ExpansionEntityDTO extends ExpansionDTO
{
    #[SWG\Property()]
    public int $id;
}
