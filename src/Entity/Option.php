<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: Houssing::class, inversedBy: 'options')]
    private $houssing;

    public function __construct()
    {
        $this->houssing = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Houssing>
     */
    public function getHoussing(): Collection
    {
        return $this->houssing;
    }

    public function addHoussing(Houssing $houssing): self
    {
        if (!$this->houssing->contains($houssing)) {
            $this->houssing[] = $houssing;
        }

        return $this;
    }

    public function removeHoussing(Houssing $houssing): self
    {
        $this->houssing->removeElement($houssing);

        return $this;
    }
}
