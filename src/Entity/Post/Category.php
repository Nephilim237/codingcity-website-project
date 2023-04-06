<?php

namespace App\Entity\Post;

use App\Entity\Post\Post;
use App\Repository\Post\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', message: 'Ce slug esiste déjà.')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $category = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: self::class)]
    private Collection $parent;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'categories')]
    private Collection $post;

    public function __construct(private readonly SluggerInterface $slugger)
    {
        $this->parent = new ArrayCollection();
        $this->post = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->name;
    }

    #[ORM\PrePersist]
    public function computeSlug(): void
    {
        $this->slug = (string)$this->slugger->slug($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(?self $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setCategory($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getCategory() === $this) {
                $parent->setCategory(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

//    public function setSlug(string $slug): self
//    {
//        $this->slug = $slug;
//
//        return $this;
//    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

//    public function setCreatedAt(\DateTimeImmutable $createdAt): self
//    {
//        $this->createdAt = $createdAt;
//
//        return $this;
//    }

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->post->removeElement($post);

        return $this;
    }
}
