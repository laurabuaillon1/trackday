<?php

namespace App\Entity;

use App\Repository\DocumentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentTypeRepository::class)]
class DocumentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, DocumentLegal>
     */
    #[ORM\OneToMany(targetEntity: DocumentLegal::class, mappedBy: 'documentType', orphanRemoval: true)]
    private Collection $documentLegals;

    public function __construct()
    {
        $this->documentLegals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, DocumentLegal>
     */
    public function getDocumentLegals(): Collection
    {
        return $this->documentLegals;
    }

    public function addDocumentLegal(DocumentLegal $documentLegal): static
    {
        if (!$this->documentLegals->contains($documentLegal)) {
            $this->documentLegals->add($documentLegal);
            $documentLegal->setDocumentType($this);
        }

        return $this;
    }

    public function removeDocumentLegal(DocumentLegal $documentLegal): static
    {
        if ($this->documentLegals->removeElement($documentLegal)) {
            // set the owning side to null (unless already changed)
            if ($documentLegal->getDocumentType() === $this) {
                $documentLegal->setDocumentType(null);
            }
        }

        return $this;
    }
}
