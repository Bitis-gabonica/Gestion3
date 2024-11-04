<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('login',message:'{value} existe en base de donnee')]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25,unique:true)]
    #[Assert\NotBlank(message:'Le login est obligatoire')]
    private ?string $login = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message:'Le password est obligatoire')]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Client $client = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        // unset the owning side of the relation if necessary
        if ($client === null && $this->client !== null) {
            $this->client->setUtilisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($client !== null && $client->getUtilisateur() !== $this) {
            $client->setUtilisateur($this);
        }

        $this->client = $client;

        return $this;
    }


}
