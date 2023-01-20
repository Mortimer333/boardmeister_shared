<?php

namespace Shared\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Shared\Contract\ImagesUtilizingEntityInterface;
use Shared\Contract\TagsUtilizingEntityInterface;
use Shared\Entity\Game\Expansion;
use Shared\Repository\GameRepository;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game implements ImagesUtilizingEntityInterface, TagsUtilizingEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alias = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Expansion::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $expansions;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: Image::class)]
    private Collection $images;

    public function __construct()
    {
        $this->expansions = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    /**
     * @return Collection<int, Expansion>
     */
    public function getExpansions(): Collection
    {
        return $this->expansions;
    }

    public function addExpansion(Expansion $expansion): self
    {
        if (!$this->expansions->contains($expansion)) {
            $this->expansions->add($expansion);
            $expansion->setGame($this);
        }

        return $this;
    }

    public function removeExpansion(Expansion $expansion): self
    {
        if ($this->expansions->removeElement($expansion)) {
            // set the owning side to null (unless already changed)
            if ($expansion->getGame() === $this) {
                $expansion->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

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
}
