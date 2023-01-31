<?php

namespace Shared\Model\Response\Game\Expansion;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\Game\ExpansionEntityDTO;
use Shared\Model\Response\SuccessDTO;

class ExpansionListResponseDTO extends SuccessDTO
{
    #[SWG\Property(
        example: 'Expansions list retrieved successfully',
        description: 'Description of the successful request'
    )]
    public string $message;

    /**
     * @var array<mixed> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'expansions', type: 'array', items: new SWG\Items(
            ref: new Model(type: ExpansionEntityDTO::class),
        )),
    ])]
    public array $data;
}
