<?php

namespace App\Entity;

use App\Repository\VentureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentureRepository::class)]
class Venture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $link = null;

    #[ORM\ManyToOne(targetEntity: Media::class, cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Media $media = null;

    #[ORM\Column(nullable: true)]
    private ?int $spot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getSpot(): ?int
    {
        return $this->spot;
    }

    public function setSpot(?int $spot): static
    {
        $this->spot = $spot;

        return $this;
    }
}
