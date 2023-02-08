<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class OptionEntityDTO extends OptionDTO
{
    #[SWG\Property()]
    public int $id;

    #[SWG\Property(example: 324, description: 'Amount of votes on this option')]
    public int $choices;
}
