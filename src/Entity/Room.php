<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $surface;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: RoomDetail::class,cascade:['persist'])]
    private $roomDetails;

    #[ORM\ManyToOne(targetEntity: Houssing::class, inversedBy: 'rooms')]
    private $houssing;

    public function __construct()
    {
        $this->roomDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

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
            $roomDetail->setRoom($this);
        }

        return $this;
    }

    public function removeRoomDetail(RoomDetail $roomDetail): self
    {
        if ($this->roomDetails->removeElement($roomDetail)) {
            // set the owning side to null (unless already changed)
            if ($roomDetail->getRoom() === $this) {
                $roomDetail->setRoom(null);
            }
        }

        return $this;
    }

    public function getHoussing(): ?Houssing
    {
        return $this->houssing;
    }

    public function setHoussing(?Houssing $houssing): self
    {
        $this->houssing = $houssing;

        return $this;
    }
}
