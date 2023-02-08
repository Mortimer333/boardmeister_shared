<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\Poll\OptionDTO;

class PollDTO
{
    #[SWG\Property(example: 'Select next tool', description: 'Name of the poll')]
    public string $title;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when poll will end')]
    public int $end;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: OptionDTO::class)
    ))]
    public array $options;
}
