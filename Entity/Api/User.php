<?php

namespace Shared\Entity\Api;

use Doctrine\ORM\Mapping as ORM;
use Shared\Repository\Api\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Private user information.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    /** @var array<mixed> $roles */
    #[ORM\Column]
    private array $roles = [];

    /** @var string The hashed password $password */
    #[ORM\Column]
    private string $password;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserData $data = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activationToken = null;

    #[ORM\Column(options: ['default' => 0])]
    private ?bool $activated = null;

    #[ORM\Column]
    private ?int $created = null;

    #[ORM\Column(nullable: true)]
    private ?int $whenActivated = null;

    public function __construct() {
        $this->setCreated(time());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<mixed> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getData(): ?UserData
    {
        return $this->data;
    }

    public function setData(UserData $data): self
    {
        // set the owning side of the relation if necessary
        if ($data->getUser() !== $this) {
            $data->setUser($this);
        }

        $this->data = $data;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    public function isActivated(): ?bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    public function getCreated(): ?int
    {
        return $this->created;
    }

    public function setCreated(int $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getWhenActivated(): ?int
    {
        return $this->whenActivated;
    }

    public function setWhenActivated(?int $whenActivated): self
    {
        $this->whenActivated = $whenActivated;

        return $this;
    }
}
