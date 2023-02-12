<?php

namespace Shared\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;
use Shared\Repository\Poll\ChoiceRepository;

#[ORM\Entity(repositoryClass: ChoiceRepository::class)]
#[ORM\Table(name: 'poll_choice')]
class Choice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ip = null;

    #[ORM\ManyToOne(inversedBy: 'choices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Option $Option = null;

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
        return $this->Option;
    }

    public function setOption(?Option $Option): self
    {
        $this->Option = $Option;

        return $this;
    }
}
