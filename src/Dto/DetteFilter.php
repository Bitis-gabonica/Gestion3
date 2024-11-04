<?php
namespace App\Dto;

use App\Entity\Client;
use App\Enum\Statut;

class DetteFilter
{
    private ?\DateTimeImmutable $date = null;
    private ?string $statut = null;
    private ?Client $client = null;

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?\DateTimeImmutable $date): static
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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        if ($statut !== null && !in_array($statut, Statut::getValues())) {
            throw new \InvalidArgumentException("Invalid statut value");
        }
        $this->statut = $statut;
        return $this;
    }
}
