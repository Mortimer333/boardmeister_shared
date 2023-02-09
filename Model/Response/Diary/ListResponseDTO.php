<?php

namespace Shared\Model\Response\Diary;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\DiaryEntryLiteEntityDTO;
use Shared\Model\Definition\Game\GameEntityWithoutExpansionsDTO;
use Shared\Model\Response\SuccessDTO;

class ListResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Entries retrieved successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<mixed> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'entries', type: 'array', items: new SWG\Items(
            ref: new Model(type: DiaryEntryLiteEntityDTO::class),
        )),
    ])]
    public array $data;
}
