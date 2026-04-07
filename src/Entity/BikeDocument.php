<?php

namespace App\Entity;

use App\Repository\BikeDocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BikeDocumentRepository::class)]
class BikeDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Choice(
        choices: ['Assurance', 'Facture d\'achat', 'Facture de pièce','Garantie'],
    )]
    private ?string $document_type = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom du document ne peux pas dépasser 255 caractères.'
    )]
    private ?string $document_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_url = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $upload_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $expiry_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank()]
    #[Assert\PositiveOrZero(message: 'Le coût doit être un nombre positif ou nul.')]
    #[Assert\Type(type: 'numeric', message: 'Le coût doit être un nombre.')]
    private ?string $amount = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Les notes ne peuvent pas dépasser 500 caractères.'
    )]
    private ?string $notes = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'bikeDocuments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bike $bike = null;

    public function __construct(){
        $this->created_at= new \DateTimeImmutable();
        $this->updated_at=new \DateTimeImmutable();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentType(): ?string
    {
        return $this->document_type;
    }

    public function setDocumentType(string $document_type): static
    {
        $this->document_type = $document_type;

        return $this;
    }

    public function getDocumentName(): ?string
    {
        return $this->document_name;
    }

    public function setDocumentName(string $document_name): static
    {
        $this->document_name = $document_name;

        return $this;
    }

    public function getFileUrl(): ?string
    {
        return $this->file_url;
    }

    public function setFileUrl(string $file_url): static
    {
        $this->file_url = $file_url;

        return $this;
    }

    public function getUploadDate(): ?\DateTime
    {
        return $this->upload_date;
    }

    public function setUploadDate(\DateTime $upload_date): static
    {
        $this->upload_date = $upload_date;

        return $this;
    }

    public function getExpiryDate(): ?\DateTime
    {
        return $this->expiry_date;
    }

    public function setExpiryDate(\DateTime $expiry_date): static
    {
        $this->expiry_date = $expiry_date;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

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
