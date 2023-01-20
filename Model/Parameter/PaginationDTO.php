<?php

declare(strict_types=1);

namespace Shared\Model\Parameter;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as SWG;
use Shared\Model\Parameter\Pagination\SortItemDTO;

class PaginationDTO
{
    #[SWG\Property(example: 10, description: 'The amount of rows to retrieve')]
    public int $limit;

    #[SWG\Property(example: 0, description: 'The amount of rows to retrieve')]
    public int $offset;

    #[SWG\Property(type: 'array', items: new SWG\Items(
        ref: new Model(type: SortItemDTO::class)
    ))]
    public array $sort;
}
