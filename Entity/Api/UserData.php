<?php

namespace Shared\Entity\Api;

use Doctrine\ORM\Mapping as ORM;
use Shared\Repository\Api\UserDataRepository;

/**
 * Public user information.
 */
#[ORM\Entity(repositoryClass: UserDataRepository::class)]
class UserData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'data', cascade: ['persist'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $deleted = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $oldName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDeleted(): ?int
    {
        return $this->deleted;
    }

    public function setDeleted(?int $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getOldName(): ?string
    {
        return $this->oldName;
    }

    public function setOldName(?string $oldName): self
    {
        $this->oldName = $oldName;

        return $this;
    }
}
