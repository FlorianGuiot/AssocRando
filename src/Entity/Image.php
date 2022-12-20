<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    #[ORM\ManyToOne(inversedBy: 'lesImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Randonnee $laRandonnee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

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
