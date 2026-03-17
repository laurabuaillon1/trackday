<?php

namespace App\Entity;

use App\Repository\BikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Votre pseudo doit comporter au moins 2 caractères',
        maxMessage: 'Votre pseudo ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9_\-\.\ ]+$/u',
        message: 'Le pseudo ne doit contenir que des lettres, chiffres, espaces, tirets, points et underscores.'
    )]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'La marque doit comporter au moins 2 caractères',
        maxMessage: 'La marque ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        message: 'La marque ne doit contenir que des lettres.'
    )]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le modèle doit comporter au moins 2 caractères',
        maxMessage: 'Le modèle ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9 ]+$/',
        message: 'Le modèle ne doit contenir des lettres et/ou des chiffres'
    )]
    private ?string $model = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'L\'année doit comporter au moins 2 caractères',
        maxMessage: 'L\'année ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^\d{4}$/',
        message: 'L’année doit contenir exactement 4 chiffres.'
    )]
    private ?int $year = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'La cylindrée doit comporter au moins 2 caractères',
        maxMessage: 'La cylindrée ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: 'La cylindrée doit contenir uniquement des chiffres.'
    )]
    private ?string $displacement = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'La couleur doit comporter au moins 2 caractères',
        maxMessage: 'La couleur ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        message: 'La couleur ne doit contenir que des lettres.'
    )]
    private ?string $color = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 15,
        minMessage: 'La plaque d\'immatriculation doit comporter au moins 2 caractères',
        maxMessage: 'La plaque d\'immatriculation ne peut pas dépasser 255 caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[A-Za-z0-9]{2}-?\d{3}-?[A-Za-z]{2}$/',
        message: 'La plaque d\'immatriculation doit être au format AA-123-AA.'
    )]
    private ?string $license_plate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $purchase_date = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(
        message: 'Les kilomètres doivent être un nombre entier positif ou nul.'
    )]
    private ?int $mileage = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(
        message: 'Le nombre d’heures doit être un entier positif ou nul.'
    )]
    private ?int $hours = null;

    #[ORM\Column(length: 10)]
    private ?string $usage_unit = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $last_service_date = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(
        message: 'Le kilométrage du prochain entretien doit être un nombre positif ou nul.'
    )]
    private ?int $next_service_km = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(
        message: 'L\'heure du prochain entretien doit être un nombre positif ou nul.'
    )]
    private ?int $next_service_hours = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_url = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Les notes ne peuvent pas dépasser 500 caractères.'
    )]
    private ?string $notes = null;

    #[ORM\Column]
    private ?bool $is_active = true;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'bikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, BikeDocument>
     */
    #[ORM\OneToMany(targetEntity: BikeDocument::class, mappedBy: 'bike', orphanRemoval: true)]
    private Collection $bikeDocuments;

    /**
     * @var Collection<int, BikeMaintenance>
     */
    #[ORM\OneToMany(targetEntity: BikeMaintenance::class, mappedBy: 'bike', orphanRemoval: true)]
    private Collection $bikeMaintenances;

    public function __construct()
    {
        $this->bikeDocuments = new ArrayCollection(); //collection vide
        $this->bikeMaintenances = new ArrayCollection(); //collection vide
        $this->created_at = new \DateTimeImmutable(); //date du jour
        $this->updated_at = new \DateTimeImmutable(); //date du jour
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getDisplacement(): ?string
    {
        return $this->displacement;
    }

    public function setDisplacement(?string $displacement): static
    {
        $this->displacement = $displacement;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->license_plate;
    }

    public function setLicensePlate(?string $license_plate): static
    {
        $this->license_plate = $license_plate;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTime
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(?\DateTime $purchase_date): static
    {
        $this->purchase_date = $purchase_date;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(?int $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getHours(): ?int
    {
        return $this->hours;
    }

    public function setHours(?int $hours): static
    {
        $this->hours = $hours;

        return $this;
    }

    public function getUsageUnit(): ?string
    {
        return $this->usage_unit;
    }

    public function setUsageUnit(string $usage_unit): static
    {
        $this->usage_unit = $usage_unit;

        return $this;
    }

    public function getLastServiceDate(): ?\DateTime
    {
        return $this->last_service_date;
    }

    public function setLastServiceDate(?\DateTime $last_service_date): static
    {
        $this->last_service_date = $last_service_date;

        return $this;
    }

    public function getNextServiceKm(): ?int
    {
        return $this->next_service_km;
    }

    public function setNextServiceKm(?int $next_service_km): static
    {
        $this->next_service_km = $next_service_km;

        return $this;
    }

    public function getNextServiceHours(): ?int
    {
        return $this->next_service_hours;
    }

    public function setNextServiceHours(?int $next_service_hours): static
    {
        $this->next_service_hours = $next_service_hours;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    public function setPhotoUrl(?string $photo_url): static
    {
        $this->photo_url = $photo_url;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }



    /**
     * @return Collection<int, BikeDocument>
     */
    public function getBikeDocuments(): Collection
    {
        return $this->bikeDocuments;
    }

    public function addBikeDocument(BikeDocument $bikeDocument): static
    {
        if (!$this->bikeDocuments->contains($bikeDocument)) {
            $this->bikeDocuments->add($bikeDocument);
            $bikeDocument->setBike($this);
        }

        return $this;
    }

    public function removeBikeDocument(BikeDocument $bikeDocument): static
    {
        if ($this->bikeDocuments->removeElement($bikeDocument)) {
            // set the owning side to null (unless already changed)
            if ($bikeDocument->getBike() === $this) {
                $bikeDocument->setBike(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BikeMaintenance>
     */
    public function getBikeMaintenances(): Collection
    {
        return $this->bikeMaintenances;
    }

    public function addBikeMaintenance(BikeMaintenance $bikeMaintenance): static
    {
        if (!$this->bikeMaintenances->contains($bikeMaintenance)) {
            $this->bikeMaintenances->add($bikeMaintenance);
            $bikeMaintenance->setBike($this);
        }

        return $this;
    }

    public function removeBikeMaintenance(BikeMaintenance $bikeMaintenance): static
    {
        if ($this->bikeMaintenances->removeElement($bikeMaintenance)) {
            // set the owning side to null (unless already changed)
            if ($bikeMaintenance->getBike() === $this) {
                $bikeMaintenance->setBike(null);
            }
        }

        return $this;
    }
}
