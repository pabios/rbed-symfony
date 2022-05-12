<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $zipCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\Column(type: 'integer')]
    private $rue;

    #[ORM\OneToMany(mappedBy: 'adresse', targetEntity: Houssing::class)]
    private $houssings;

    public function __construct()
    {
        $this->houssings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(?int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRue(): ?int
    {
        return $this->rue;
    }

    public function setRue(int $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * @return Collection<int, Houssing>
     */
    public function getHoussings(): Collection
    {
        return $this->houssings;
    }

    public function addHoussing(Houssing $houssing): self
    {
        if (!$this->houssings->contains($houssing)) {
            $this->houssings[] = $houssing;
            $houssing->setAdresse($this);
        }

        return $this;
    }

    public function removeHoussing(Houssing $houssing): self
    {
        if ($this->houssings->removeElement($houssing)) {
            // set the owning side to null (unless already changed)
            if ($houssing->getAdresse() === $this) {
                $houssing->setAdresse(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->city;
    }
}
