<?php

namespace App\Entity;

use App\Repository\RandonneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RandonneeRepository::class)]
class Randonnee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $dureeMinutes = null;

    #[ORM\OneToMany(mappedBy: 'laRandonnee', targetEntity: SessionRando::class, orphanRemoval: true)]
    private Collection $lesSessions;

    public function __construct()
    {
        $this->lesSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDureeMinutes(): ?int
    {
        return $this->dureeMinutes;
    }

    public function setDureeMinutes(int $dureeMinutes): self
    {
        $this->dureeMinutes = $dureeMinutes;

        return $this;
    }

    /**
     * @return Collection<int, SessionRando>
     */
    public function getLesSessions(): Collection
    {
        return $this->lesSessions;
    }

    public function addLesSession(SessionRando $lesSession): self
    {
        if (!$this->lesSessions->contains($lesSession)) {
            $this->lesSessions->add($lesSession);
            $lesSession->setLaRandonnee($this);
        }

        return $this;
    }

    public function removeLesSession(SessionRando $lesSession): self
    {
        if ($this->lesSessions->removeElement($lesSession)) {
            // set the owning side to null (unless already changed)
            if ($lesSession->getLaRandonnee() === $this) {
                $lesSession->setLaRandonnee(null);
            }
        }

        return $this;
    }
}
