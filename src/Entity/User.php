<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cette adresse mail')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nom
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Votre nom doit comporter au moins 2 caractères',
        maxMessage: 'Votre nom ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        message: 'Le nom ne doit contenir que des lettres.'
    )]
    private ?string $last_name = null;

    // Prénom
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Votre prénom doit comporter au moins 2 caractères',
        maxMessage: 'Votre prénom ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        message: 'Le prénom ne doit contenir que des lettres.'
    )]
    private ?string $first_name = null;

    // Adresse mail
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'email est obligatoire.')]
    #[Assert\Email(
        message: 'L\'adresse mail "{{ value }}" n\'est pas valide',
    )]
    private ?string $email = null;

    //Mot de passe 
    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        message: 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'
    )]
    private ?string $password = null;

    // Suppression en cascade des tokens de réinitialisation de mot de passe liés à l'utilisateur
    //Pour éviter d'avoir des tokens "orphelins" en base de données
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ResetPasswordRequest::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $resetPasswordRequests;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_login_at = null;

    #[ORM\Column(length: 50)]
    private ?string $account_status = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_picture = null;

    /**
     * @var Collection<int, Bike>
     */
    #[ORM\OneToMany(targetEntity: Bike::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $bikes;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->bikes = new ArrayCollection();
        $this->resetPasswordRequests = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->account_status = 'active';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getResetPasswordRequests(): Collection
{
    return $this->resetPasswordRequests;
}

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->last_login_at;
    }

    public function setLastLoginAt(\DateTimeImmutable $last_login_at): static
    {
        $this->last_login_at = $last_login_at;

        return $this;
    }

    public function getAccountStatus(): ?string
    {
        return $this->account_status;
    }

    public function setAccountStatus(string $account_status): static
    {
        $this->account_status = $account_status;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(string $profile_picture): static
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    /**
     * @return Collection<int, Bike>
     */
    public function getBikes(): Collection
    {
        return $this->bikes;
    }

    public function addBike(Bike $bike): static
    {
        if (!$this->bikes->contains($bike)) {
            $this->bikes->add($bike);
            $bike->setUser($this);
        }

        return $this;
    }

    public function removeBike(Bike $bike): static
    {
        if ($this->bikes->removeElement($bike)) {
            // set the owning side to null (unless already changed)
            if ($bike->getUser() === $this) {
                $bike->setUser(null);
            }
        }

        return $this;
    }


    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
