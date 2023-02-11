<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\Poll\OptionEntityDTO;

class PollEntityDTO extends PollDTO
{
    #[SWG\Property()]
    public int $id;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: OptionEntityDTO::class)
    ))]
    public array $options;
}
