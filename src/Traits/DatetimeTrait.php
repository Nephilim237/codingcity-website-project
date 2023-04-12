<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
trait DatetimeTrait
{

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    private \DateTimeImmutable $updatedAt;

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdateAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}