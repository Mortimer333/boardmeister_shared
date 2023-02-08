<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class OptionDTO
{
    #[SWG\Property(example: 'Option #1', description: 'Name of the option')]
    public string $name;
}
