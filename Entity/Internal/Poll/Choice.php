<?php

namespace Shared\Entity\Internal\Poll;

use Doctrine\ORM\Mapping as ORM;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
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
}
