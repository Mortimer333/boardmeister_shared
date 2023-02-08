<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ChoiceEntityDTO extends ChoiceDTO
{
    #[SWG\Property()]
    public int $id;
}
