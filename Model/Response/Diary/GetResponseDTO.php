<?php

declare(strict_types=1);

namespace Shared\Model\Response\Diary;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\DiaryEntryParsedEntityDTO;
use Shared\Model\Response\SuccessDTO;

class GetResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Entry retrieved successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<string> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'entry', ref: new Model(type: DiaryEntryParsedEntityDTO::class)),
    ])]
    public array $data;
}
