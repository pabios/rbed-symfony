<?php

namespace App\Entity;

use App\Repository\HoussingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoussingTypeRepository::class)]
class HoussingType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'houssingType', targetEntity: Houssing::class)]
    private $houssings;

    public function __construct()
    {
        $this->houssings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $houssing->setHoussingType($this);
        }

        return $this;
    }

    public function removeHoussing(Houssing $houssing): self
    {
        if ($this->houssings->removeElement($houssing)) {
            // set the owning side to null (unless already changed)
            if ($houssing->getHoussingType() === $this) {
                $houssing->setHoussingType(null);
            }
        }

        return $this;
    }
}
