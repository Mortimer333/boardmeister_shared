<?php

namespace Shared\Model\Response\Game\Expansion;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\Game\ExpansionEntityDTO;
use Shared\Model\Response\SuccessDTO;

class ExpansionGetResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Expansion retrieved successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<string> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'expansion', ref: new Model(type: ExpansionEntityDTO::class)),
    ])]
    public array $data;
}
