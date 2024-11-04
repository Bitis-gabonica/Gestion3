<?php

namespace App\Entity;

use App\Repository\DetteRepository;
use App\Enum\Statut;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?float $montantVerse = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    
    #[ORM\Column(type: 'string')] 
    private string $statut;

    #[ORM\ManyToOne(inversedBy: 'dettes')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantVerse(): ?float
    {
        return $this->montantVerse;
    }

    public function setMontantVerse(float $montantVerse): static
    {
        $this->montantVerse = $montantVerse;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        if (!in_array($statut, Statut::getValues())) {
            throw new \InvalidArgumentException("Invalid statut value");
        }
        $this->statut = $statut;

        return $this;
    }
}
