<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use OpenApi\Attributes as SWG;

class ChoiceNoIpEntityDTO extends ChoiceNoIpDTO
{
    #[SWG\Property()]
    public int $id;
}
