<?php

namespace Shared\Entity\Internal\Poll;

use Doctrine\ORM\Mapping as ORM;
use Shared\Entity\Api\User;

#[ORM\Entity(repositoryClass: \Shared\Repository\Internal\Poll\ChoiceRepository::class)]
#[ORM\Table(name: 'poll_choice')]
class Choice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'choices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Option $option = null;

    #[ORM\Column(nullable: true)]
    private ?int $userId = null;

    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOption(): ?Option
    {
        return $this->option;
    }

    public function setOption(?Option $option): self
    {
        $this->option = $option;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

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
}
