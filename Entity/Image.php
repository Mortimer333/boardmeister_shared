<?php

namespace Shared\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Shared\Contract\TagsUtilizingEntityInterface;
use Shared\Contract\TagValuesUtilizingEntityInterface;
use Shared\Repository\ImageRepository;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image implements TagValuesUtilizingEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $source;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: TagValue::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tagValues;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->tagValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return Collection<int, TagValue>
     */
    public function getTagValues(): Collection
    {
        return $this->tagValues;
    }

    public function addTagValue(TagValue $tagValue): self
    {
        if (!$this->tagValues->contains($tagValue)) {
            $this->tagValues->add($tagValue);
            $tagValue->setImage($this);
        }

        return $this;
    }

    public function removeTagValue(TagValue $tagValue): self
    {
        if ($this->tagValues->removeElement($tagValue)) {
            // set the owning side to null (unless already changed)
            if ($tagValue->getImage() === $this) {
                $tagValue->setImage(null);
            }
        }

        return $this;
    }
}
