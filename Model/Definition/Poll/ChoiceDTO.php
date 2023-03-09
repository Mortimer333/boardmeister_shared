<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use OpenApi\Attributes as SWG;
use Shared\Model\Definition\UserEntityDTO;

class ChoiceDTO
{
    #[SWG\Property]
    public ?UserEntityDTO $user;

    #[SWG\Property]
    public int $optionId;
}
