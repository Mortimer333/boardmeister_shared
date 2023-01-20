<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Game;

use OpenApi\Attributes as SWG;

class ExpansionEntityDTO extends ExpansionDTO
{
    #[SWG\Property()]
    public int $id;
}
