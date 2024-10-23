<?php

namespace App\Tests\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CarControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/car/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Car::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Car index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'car[vin]' => 'Testing',
            'car[registration_number]' => 'Testing',
            'car[model]' => 'Testing',
            'car[is_rented]' => 'Testing',
            'car[brand_id]' => 'Testing',
            'car[client_id]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Car();
        $fixture->setVin('My Title');
        $fixture->setRegistration_number('My Title');
        $fixture->setModel('My Title');
        $fixture->setIs_rented('My Title');
        $fixture->setBrand_id('My Title');
        $fixture->setClient_id('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Car');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Car();
        $fixture->setVin('Value');
        $fixture->setRegistration_number('Value');
        $fixture->setModel('Value');
        $fixture->setIs_rented('Value');
        $fixture->setBrand_id('Value');
        $fixture->setClient_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'car[vin]' => 'Something New',
            'car[registration_number]' => 'Something New',
            'car[model]' => 'Something New',
            'car[is_rented]' => 'Something New',
            'car[brand_id]' => 'Something New',
            'car[client_id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/car/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getVin());
        self::assertSame('Something New', $fixture[0]->getRegistration_number());
        self::assertSame('Something New', $fixture[0]->getModel());
        self::assertSame('Something New', $fixture[0]->getIs_rented());
        self::assertSame('Something New', $fixture[0]->getBrand_id());
        self::assertSame('Something New', $fixture[0]->getClient_id());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Car();
        $fixture->setVin('Value');
        $fixture->setRegistration_number('Value');
        $fixture->setModel('Value');
        $fixture->setIs_rented('Value');
        $fixture->setBrand_id('Value');
        $fixture->setClient_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/car/');
        self::assertSame(0, $this->repository->count([]));
    }
}
