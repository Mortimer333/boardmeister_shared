<?php

declare(strict_types=1);

namespace Shared\Contract;

use Doctrine\Common\Collections\Collection;
use Shared\Entity\Internal\Tag;

interface TagsUtilizingEntityInterface
{
    public function getTags(): Collection;

    public function addTag(Tag $tag): self;

    public function removeTag(Tag $tag): self;
}
