<?php

declare(strict_types=1);

namespace App\Shared\Model\Definition;

use OpenApi\Attributes as SWG;

class TagEntityDTO extends TagDTO
{
    #[SWG\Property()]
    public int $id;
}
