<?php

declare(strict_types=1);

namespace Shared\Model\Definition;

use OpenApi\Attributes as SWG;

class DiaryEntryLiteEntityDTO extends DiaryEntryLiteDTO
{
    #[SWG\Property()]
    public int $id;
}
