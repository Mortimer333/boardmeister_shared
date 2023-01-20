<?php

namespace Shared\Model\Response\Game;

use Shared\Model\Definition\Game\GameEntityDTO;
use Shared\Model\Response\SuccessDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class GameGetResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Game retrieved successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<string> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'game', ref: new Model(type: GameEntityDTO::class)),
    ])]
    public array $data;
}
