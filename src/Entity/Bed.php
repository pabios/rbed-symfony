<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $place;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    #[ORM\OneToMany(mappedBy: 'bed', targetEntity: RoomDetail::class)]
    private $roomDetails;

    public function __construct()
    {
        $this->roomDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, RoomDetail>
     */
    public function getRoomDetails(): Collection
    {
        return $this->roomDetails;
    }

    public function addRoomDetail(RoomDetail $roomDetail): self
    {
        if (!$this->roomDetails->contains($roomDetail)) {
            $this->roomDetails[] = $roomDetail;
            $roomDetail->setBed($this);
        }

        return $this;
    }

    public function removeRoomDetail(RoomDetail $roomDetail): self
    {
        if ($this->roomDetails->removeElement($roomDetail)) {
            // set the owning side to null (unless already changed)
            if ($roomDetail->getBed() === $this) {
                $roomDetail->setBed(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->type;
    }
}
