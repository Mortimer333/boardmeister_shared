<?php

namespace Shared\Model\Response\Game;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\Game\GameEntityWithoutExpansionsDTO;
use Shared\Model\Response\SuccessDTO;

class GameListResponseDTO extends SuccessDTO
{
    #[SWG\Property(example: 'Games retrieved successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<mixed> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'games', type: 'array', items: new SWG\Items(
            ref: new Model(type: GameEntityWithoutExpansionsDTO::class),
        )),
    ])]
    public array $data;
}
