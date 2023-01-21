<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use OpenApi\Attributes as SWG;

class TagValueDTO
{
    #[SWG\Property(example: '12', description: 'Value assigned to the tag (nullable)')]
    public string $value;

    #[SWG\Property()]
    public TagDTO $tag;
}
