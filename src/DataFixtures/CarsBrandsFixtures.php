<?php

namespace App\DataFixtures;

use App\Entity\CarBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarsBrandsFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $brandNames = ['Audi', 'Mercedes', 'Opel', 'Toyota', 'BMW', 'KIA', 'Honda', 'Hyundai'];

    foreach ($brandNames as $brandName) {
      $carBrand = new CarBrand;
      $carBrand->setName($brandName);

      $manager->persist($carBrand);
      $manager->flush();
    }
  }
}
