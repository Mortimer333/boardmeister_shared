<?php

declare(strict_types=1);

namespace Shared\Contract;

use Doctrine\Common\Collections\Collection;
use Shared\Entity\Internal\TagValue;

interface TagValuesUtilizingEntityInterface
{
    public function getTagValues(): Collection;

    public function addTagValue(TagValue $tag): self;

    public function removeTagValue(TagValue $tag): self;
}
