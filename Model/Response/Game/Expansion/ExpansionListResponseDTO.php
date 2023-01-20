<?php

namespace App\Shared\Model\Response\Game\Expansion;

use App\Shared\Model\Definition\Game\ExpansionEntityDTO;
use App\Shared\Model\Definition\Game\GameEntityDTO;
use App\Shared\Model\Response\SuccessDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ExpansionListResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Expansions list retrieved successfully', description: 'Description of the successful request')]
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
