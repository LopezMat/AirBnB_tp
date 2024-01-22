<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_path = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $alt = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Logement $logementId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(string $image_path): static
    {
        $this->image_path = $image_path;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getLogementId(): ?Logement
    {
        return $this->logementId;
    }

    public function setLogementId(?Logement $logementId): static
    {
        $this->logementId = $logementId;

        return $this;
    }
}
