<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 50)]
  private ?string $name = null;

  #[ORM\Column(length: 100)]
  private ?string $email = null;

  #[ORM\Column(length: 100)]
  private ?string $address = null;

  #[ORM\Column(length: 50)]
  private ?string $city = null;

  /**
   * @var Collection<int, Car>
   */
  #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'client_id')]
  private Collection $cars;

  public function __construct()
  {
    $this->cars = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): static
  {
    $this->email = $email;

    return $this;
  }

  public function getAddress(): ?string
  {
    return $this->address;
  }

  public function setAddress(string $address): static
  {
    $this->address = $address;

    return $this;
  }

  public function getCity(): ?string
  {
    return $this->city;
  }

  public function setCity(string $city): static
  {
    $this->city = $city;

    return $this;
  }

  /**
   * @return Collection<int, Car>
   */
  public function getCars(): Collection
  {
    return $this->cars;
  }

  public function addCar(Car $car): static
  {
    if (!$this->cars->contains($car)) {
      $this->cars->add($car);
      $car->setClientId($this);
    }

    return $this;
  }

  public function removeCar(Car $car): static
  {
    if ($this->cars->removeElement($car)) {
      // set the owning side to null (unless already changed)
      if ($car->getClientId() === $this) {
        $car->setClientId(null);
      }
    }

    return $this;
  }

  public function getFullAdress(): string {
    return $this?->address.", ".$this?->city;
  }
}
