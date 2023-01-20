<?php

declare(strict_types=1);

namespace Shared\Contract;

use Shared\Entity\Image;
use Doctrine\Common\Collections\Collection;

interface ImagesUtilizingEntityInterface
{
    public function getImages(): Collection;
    public function addImage(Image $image): self;
    public function removeImage(Image $image): self;
}
