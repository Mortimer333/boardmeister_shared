<?php

namespace Shared\Entity\Game;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Shared\Contract\ImagesUtilizingEntityInterface;
use Shared\Contract\TagsUtilizingEntityInterface;
use Shared\Contract\TagValuesUtilizingEntityInterface;
use Shared\Entity\Game;
use Shared\Entity\Image;
use Shared\Entity\Tag;
use Shared\Entity\TagValue;
use Shared\Repository\Game\ExpansionRepository;

#[ORM\Entity(repositoryClass: ExpansionRepository::class)]
class Expansion implements ImagesUtilizingEntityInterface, TagValuesUtilizingEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alias = null;

    #[ORM\ManyToOne(inversedBy: 'expansions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null; // @phpstan-ignore-line

    #[ORM\ManyToMany(targetEntity: Image::class)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'expansion', targetEntity: TagValue::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tagValues;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tagValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $this->images->removeElement($image);

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
            $tagValue->setExpansion($this);
        }

        return $this;
    }

    public function removeTagValue(TagValue $tagValue): self
    {
        if ($this->tagValues->removeElement($tagValue)) {
            // set the owning side to null (unless already changed)
            if ($tagValue->getExpansion() === $this) {
                $tagValue->setExpansion(null);
            }
        }

        return $this;
    }
}
