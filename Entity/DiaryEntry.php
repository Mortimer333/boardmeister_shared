<?php

namespace Shared\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shared\Contract\TagValuesUtilizingEntityInterface;
use Shared\Repository\DiaryEntryRepository;

#[ORM\Entity(repositoryClass: DiaryEntryRepository::class)]
class DiaryEntry implements TagValuesUtilizingEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $updated;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $overview = null;

    #[ORM\OneToMany(mappedBy: 'diary', targetEntity: Poll::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $polls;

    #[ORM\OneToMany(mappedBy: 'diary', targetEntity: TagValue::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tagValues;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentParsed = null;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->polls = new ArrayCollection();
        $this->tagValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * @return Collection<int, Expansion>
     */
    public function getPolls(): Collection
    {
        return $this->polls;
    }

    public function addPoll(Poll $poll): self
    {
        if (!$this->polls->contains($poll)) {
            $this->polls->add($poll);
            $poll->setDiary($this);
        }

        return $this;
    }

    public function removePoll(Poll $poll): self
    {
        if ($this->polls->removeElement($poll)) {
            // set the owning side to null (unless already changed)
            if ($poll->getDiary() === $this) {
                $poll->getDiary(null);
            }
        }

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
            $tagValue->setDiary($this);
        }

        return $this;
    }

    public function removeTagValue(TagValue $tagValue): self
    {
        if ($this->tagValues->removeElement($tagValue)) {
            // set the owning side to null (unless already changed)
            if ($tagValue->getDiary() === $this) {
                $tagValue->setDiary(null);
            }
        }

        return $this;
    }

    public function getContentParsed(): ?string
    {
        return $this->contentParsed;
    }

    public function setContentParsed(?string $contentParsed): self
    {
        $this->contentParsed = $contentParsed;

        return $this;
    }
}
