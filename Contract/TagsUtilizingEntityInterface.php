<?php

declare(strict_types=1);

namespace Shared\Contract;

use Shared\Entity\Tag;
use Doctrine\Common\Collections\Collection;

interface TagsUtilizingEntityInterface
{
    public function getTags(): Collection;
    public function addTag(Tag $tag): self;
    public function removeTag(Tag $tag): self;
}
