<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[Assert\NotBlank]
  #[ORM\ManyToOne(inversedBy: 'cars')]
  #[ORM\JoinColumn(nullable: false)]
  private ?CarBrand $brand_id = null;

  #[Assert\Length(
    min: 1,
    max: 100
  )]
  #[ORM\Column(length: 100)]
  private ?string $model = null;

  #[Assert\Length(
    min: 2,
    max: 18
  )]
  #[ORM\Column(length: 18)]
  private ?string $vin = null;

  #[Assert\Length(
    min: 2,
    max: 15
  )]
  #[ORM\Column(length: 15, nullable: true)]
  private ?string $registration_number = null;

  #[ORM\ManyToOne(inversedBy: 'cars')]
  private ?Client $client_id = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function getBrandId(): ?CarBrand
  {
    return $this->brand_id;
  }

  public function setBrandId(?CarBrand $brand_id): static
  {
    $this->brand_id = $brand_id;
    return $this;
  }

  public function getVin(): ?string
  {
    return $this->vin;
  }

  public function setVin(string $vin): static
  {
    $this->vin = $vin;
    return $this;
  }

  public function getRegistrationNumber(): ?string
  {
    return $this->registration_number;
  }

  public function setRegistrationNumber(?string $registration_number): static
  {
    $this->registration_number = $registration_number;
    return $this;
  }

  public function getModel(): ?string
  {
    return $this->model;
  }

  public function setModel(string $model): static
  {
    $this->model = $model;
    return $this;
  }

  public function getClientId(): ?Client
  {
    return $this->client_id;
  }

  public function setClientId(?Client $client_id): static
  {
    $this->client_id = $client_id;
    return $this;
  }

  public function isRented(): bool
  {
    return $this->client_id !== null;
  }

  public function getAddress(): ?string {
    return $this->client_id?->getFullAdress();
  }

  public function __toArray(): array {
    return [
      'id' => $this->id,
      'brand' => $this->brand_id?->getName(),
      'model' => $this->model,
      'vin' => $this->vin,
      'registrationNumber' => $this->registration_number,
      'client' => $this->client_id?->getName(),
      'rented' => $this->isRented(),
      'address' => $this->getAddress()
    ];
  }
}
