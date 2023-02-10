<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\TagValueEntityDTO;

class DiaryEntryLiteDTO
{
    #[SWG\Property(example: 'Dev diary entry #1', description: 'Name of the entry in the diary')]
    public string $title;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when entry was created')]
    public int $created;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when entry was last updated')]
    public int $updated;

    #[SWG\Property(example: 'Entry #1', description: 'Small overview of the update')]
    public string $overview;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: TagValueEntityDTO::class)
    ))]
    public array $tagValues;
}
