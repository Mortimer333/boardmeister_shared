<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use OpenApi\Attributes as SWG;

class ChoiceNoIpDTO
{
    #[SWG\Property()]
    public int $optionId;
}
