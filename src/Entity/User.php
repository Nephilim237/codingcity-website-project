<?php

namespace App\Entity;

use App\Entity\Post\Post;
use App\Repository\UserRepository;
use App\Traits\DatetimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DatetimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Avatar $avatar = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserBio $userBio = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserInfo $userInfo = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $posts;

    #[ORM\Column(nullable: true)]
    private ?bool $owner = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'userLike')]
    private Collection $postLikes;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
        $this->postLikes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return "{$this->userInfo->getLastname()} {$this->userInfo->getFirstname()}";
    }

    public function computeSlug(SluggerInterface $slugger): void
    {
        $this->slug = (string) $slugger->slug((string) $this)->lower();
    }

    public function getFullname(): string
    {
        return "{$this->userInfo->getLastname()} {$this->userInfo->getFirstname()}";

    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(Avatar $avatar): self
    {
        // set the owning side of the relation if necessary
        if ($avatar->getUser() !== $this) {
            $avatar->setUser($this);
        }

        $this->avatar = $avatar;

        return $this;
    }

    public function getUserBio(): ?UserBio
    {
        return $this->userBio;
    }

    public function setUserBio(UserBio $userBio): self
    {
        // set the owning side of the relation if necessary
        if ($userBio->getUser() !== $this) {
            $userBio->setUser($this);
        }

        $this->userBio = $userBio;

        return $this;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(UserInfo $userInfo): self
    {
        // set the owning side of the relation if necessary
        if ($userInfo->getUser() !== $this) {
            $userInfo->setUser($this);
        }

        $this->userInfo = $userInfo;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    public function isOwner(): ?bool
    {
        return $this->owner;
    }

    public function setOwner(?bool $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPostLikes(): Collection
    {
        return $this->postLikes;
    }

    public function addPostLike(Post $postLike): self
    {
        if (!$this->postLikes->contains($postLike)) {
            $this->postLikes->add($postLike);
            $postLike->addUserLike($this);
        }

        return $this;
    }

    public function removePostLike(Post $postLike): self
    {
        if ($this->postLikes->removeElement($postLike)) {
            $postLike->removeUserLike($this);
        }

        return $this;
    }
}
