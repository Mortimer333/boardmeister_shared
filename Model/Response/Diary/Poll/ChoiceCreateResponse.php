<?php

declare(strict_types=1);

namespace Shared\Model\Response\Diary\Poll;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Definition\Poll\ChoiceEntityDTO;

class ChoiceCreateResponse
{
    #[SWG\Property(example: 'Option selected successfully', description: 'Description of the successful request')]
    public string $message;

    /**
     * @var array<string> $data
     */
    #[SWG\Property(type: 'object', properties: [
        new SWG\Property(property: 'choice', ref: new Model(type: ChoiceEntityDTO::class)),
    ])]
    public array $data;
}
