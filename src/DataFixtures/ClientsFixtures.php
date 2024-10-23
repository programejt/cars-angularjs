<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientsFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $clients = [
      (new Client)->setName('Jan Kowalski')->setCity('Warszawa')->setEmail('jankowalski@email.com')->setAddress('Kowalska 4'),
      (new Client)->setName('Jan Bednarski')->setCity('Warszawa')->setEmail('janbednarski@email.com')->setAddress('Kowalska 5'),
      (new Client)->setName('Adam Kowalski')->setCity('Katowice')->setEmail('adamkowalski@email.com')->setAddress('Wierzbowa 7'),
      (new Client)->setName('Jan Kowalski')->setCity('Zakopane')->setEmail('jankowalski@email.com')->setAddress('Aleje 3'),
      (new Client)->setName('Jan Kowalski')->setCity('Olsztyn')->setEmail('jankowalski@email.com')->setAddress('Bracka 2')
    ];

    foreach ($clients as &$client) {
      $manager->persist($client);
      $manager->flush();
    }
  }
}
