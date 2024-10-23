<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarBrand;
use App\Repository\CarBrandRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarsFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    // $car = new Car;
    // $car->setModel('A4');
    // $car->setVin('FWTERTGGHFG534');
    // $car->setRegistrationNumber('TGGHFG534');
    // $car->setBrandId((new CarBrand)->setId(1));

    // $manager->persist($car);
    // $manager->flush();
  }
}
