<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VoitureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[ApiResource]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
  /**
     * @Assert\NotBlank(message="Model is required.")
     */
    private string $model;


    #[ORM\Column(nullable: true)]
   /**
     * @Assert\NotBlank(message="Km/h is required.")
     * @Assert\Type(type="numeric", message="Km/h must be a number.")
     * @Assert\Positive(message="Km/h must be greater than zero.")
     */
    private float $kmh;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $caracteristiques = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getKmh(): ?int
    {
        return $this->kmh;
    }

    public function setKmh(?int $kmh): static
    {
        $this->kmh = $kmh;

        return $this;
    }

    public function getCaracteristiques(): ?string
    {
        return $this->caracteristiques;
    }

    public function setCaracteristiques(?string $caracteristiques): static
    {
        $this->caracteristiques = $caracteristiques;

        return $this;
    }
}
