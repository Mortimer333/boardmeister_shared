<?php

namespace Shared\Model\Response\Game;

use Shared\Model\Definition\Game\GameEntityDTO;
use Shared\Model\Response\SuccessDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class GameListResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Games retrieved successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<mixed> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'games', type: 'array', items: new SWG\Items(
            ref: new Model(type: GameEntityDTO::class),
        )),
    ])]
    public array $data;
}
