<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class DiaryEntryDTO
{
    #[SWG\Property(example: 'Dev diary entry #1', description: 'Name of the entry in the diary')]
    public string $title;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when entry was created')]
    public int $created;

    #[SWG\Property(example: 12345678, description: 'Timestamp of when entry was last updated')]
    public int $updated;

    #[SWG\Property(example: 'Entry #1', description: 'Small overview of the update')]
    public string $overview;

    #[SWG\Property(example: '{"time" : 1550476186479, "blocks" : [], "version" : "2.8.1"}', description: 'JSON value for wysiwyg')]
    public string $content;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: PollDTO::class)
    ))]
    public array $polls;
}
