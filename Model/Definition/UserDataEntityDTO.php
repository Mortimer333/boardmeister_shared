<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use OpenApi\Attributes as SWG;

class UserDataEntityDTO
{
    #[SWG\Property]
    public int $id;

    #[SWG\Property]
    public string $name;
}
