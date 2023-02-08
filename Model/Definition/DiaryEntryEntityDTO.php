<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class DiaryEntryEntityDTO extends DiaryEntryDTO
{
    #[SWG\Property()]
    public int $id;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when entry was created')]
    public int $created;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when entry was last updated')]
    public int $updated;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: PollEntityDTO::class)
    ))]
    public array $polls;
}
