<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use App\Traits\DatetimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvatarRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Avatar
{
    use DatetimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    #[ORM\OneToOne(inversedBy: 'avatar', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function prePersist() :void
    {
        $this->avatar = "https://api.dicebear.com/6.x/bottts/svg?seed={$this->getUser()->getEmail()}";
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->avatar = "https://api.dicebear.com/6.x/bottts/svg?seed={$this->getUser()->getEmail()}";
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
