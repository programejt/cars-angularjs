<?php

namespace App\Entity;

use App\Repository\CarBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarBrandRepository::class)]
class CarBrand
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 60)]
  private ?string $name = null;

  /**
   * @var Collection<int, Car>
   */
  #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'brand_id')]
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
      $car->setBrandId($this);
    }

    return $this;
  }

  public function removeCar(Car $car): static
  {
    if ($this->cars->removeElement($car)) {
      // set the owning side to null (unless already changed)
      if ($car->getBrandId() === $this) {
        $car->setBrandId(null);
      }
    }

    return $this;
  }
}
