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
    #[ORM\OrderBy(["date" => "ASC"])]
    private Collection $lesSessions;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $laMiniature = null;

    #[ORM\OneToMany(mappedBy: 'laRandonnee', targetEntity: Image::class, orphanRemoval: true)]
    private Collection $lesImages;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->lesSessions = new ArrayCollection();
        $this->lesImages = new ArrayCollection();
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

    public function getLaMiniature(): ?Image
    {
        return $this->laMiniature;
    }

    public function setLaMiniature(?Image $laMiniature): self
    {
        $this->laMiniature = $laMiniature;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getLesImages(): Collection
    {
        return $this->lesImages;
    }

    public function addLesImage(Image $lesImage): self
    {
        if (!$this->lesImages->contains($lesImage)) {
            $this->lesImages->add($lesImage);
            $lesImage->setLaRandonnee($this);
        }

        return $this;
    }

    public function removeLesImage(Image $lesImage): self
    {
        if ($this->lesImages->removeElement($lesImage)) {
            // set the owning side to null (unless already changed)
            if ($lesImage->getLaRandonnee() === $this) {
                $lesImage->setLaRandonnee(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
