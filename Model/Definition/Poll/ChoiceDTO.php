<?php

declare(strict_types=1);

namespace Shared\Model\Definition\Poll;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;

class ChoiceDTO
{
    #[SWG\Property(example: '10.0.0.1', description: 'IP of the client')]
    public string $ip;
}
