<?php

namespace Shared\Entity\Internal;

use Doctrine\ORM\Mapping as ORM;
use Shared\Entity\Internal\Game\Expansion;
use Shared\Repository\Internal\TagValueRepository;

#[ORM\Entity(repositoryClass: TagValueRepository::class)]
class TagValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tag $tag = null;

    #[ORM\ManyToOne(inversedBy: 'tagValues')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'tagValues')]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'tagValues')]
    private ?Expansion $expansion = null;

    #[ORM\ManyToOne(inversedBy: 'tagValues')]
    private ?DiaryEntry $diary = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getExpansion(): ?Expansion
    {
        return $this->expansion;
    }

    public function setExpansion(?Expansion $expansion): self
    {
        $this->expansion = $expansion;

        return $this;
    }

    public function getDiary(): ?DiaryEntry
    {
        return $this->diary;
    }

    public function setDiary(?DiaryEntry $diary): self
    {
        $this->diary = $diary;

        return $this;
    }
}
