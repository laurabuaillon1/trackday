<?php

namespace App\Entity;

use App\Repository\BikeMaintenanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BikeMaintenanceRepository::class)]
class BikeMaintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column]
    private ?int $hours = null;

    #[ORM\Column(length: 255)]
    private ?string $maintenance_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: false)]
    private ?string $cost = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $workshop = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $parts_used = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $next_service_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $next_service_km = null;

    #[ORM\Column(nullable: true)]
    private ?int $next_service_hours = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $receipt_url = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'bikeMaintenances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bike $bike = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getHours(): ?int
    {
        return $this->hours;
    }

    public function setHours(int $hours): static
    {
        $this->hours = $hours;

        return $this;
    }

    public function getMaintenanceType(): ?string
    {
        return $this->maintenance_type;
    }

    public function setMaintenanceType(string $maintenance_type): static
    {
        $this->maintenance_type = $maintenance_type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(?string $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getWorkshop(): ?string
    {
        return $this->workshop;
    }

    public function setWorkshop(?string $workshop): static
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getPartsUsed(): ?string
    {
        return $this->parts_used;
    }

    public function setPartsUsed(?string $parts_used): static
    {
        $this->parts_used = $parts_used;

        return $this;
    }

    public function getNextServiceDate(): ?\DateTime
    {
        return $this->next_service_date;
    }

    public function setNextServiceDate(?\DateTime $next_service_date): static
    {
        $this->next_service_date = $next_service_date;

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

    public function getReceiptUrl(): ?string
    {
        return $this->receipt_url;
    }

    public function setReceiptUrl(?string $receipt_url): static
    {
        $this->receipt_url = $receipt_url;

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

    public function getBike(): ?Bike
    {
        return $this->bike;
    }

    public function setBike(?Bike $bike): static
    {
        $this->bike = $bike;

        return $this;
    }
}
