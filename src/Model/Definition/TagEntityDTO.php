<?php

declare(strict_types=1);

namespace App\Model\Definition;

use OpenApi\Attributes as SWG;

class TagEntityDTO extends TagDTO
{
    #[SWG\Property()]
    public int $id;
}
