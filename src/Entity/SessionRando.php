<?php

namespace App\Entity;

use App\Repository\SessionRandoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRandoRepository::class)]
class SessionRando
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $nbPlaces = null;

    #[ORM\ManyToOne(inversedBy: 'lesSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Randonnee $laRandonnee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getLaRandonnee(): ?Randonnee
    {
        return $this->laRandonnee;
    }

    public function setLaRandonnee(?Randonnee $laRandonnee): self
    {
        $this->laRandonnee = $laRandonnee;

        return $this;
    }
}
