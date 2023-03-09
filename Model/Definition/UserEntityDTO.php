<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use OpenApi\Attributes as SWG;

class UserEntityDTO
{
    #[SWG\Property]
    public int $id;

    #[SWG\Property]
    public UserDataEntityDTO $data;

    #[SWG\Property]
    public string $email;

    #[SWG\Property(example: '2020-01-01 00:00:00')]
    public string $created;
}
