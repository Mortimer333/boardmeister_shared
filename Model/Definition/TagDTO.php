<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use OpenApi\Attributes as SWG;

class TagDTO
{
    #[SWG\Property(example: 'addon', description: 'Name of the tag')]
    public string $name;
}
