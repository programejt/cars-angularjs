<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/car')]
final class CarController extends AbstractController
{
  #[Route(name: 'app_car_index', methods: ['GET'])]
  public function index(
    CarRepository $carRepository,
    Request $request
  ): Response
  {
    if ($request->get('xhr')) {
      $cars = $carRepository->findAll();
      foreach ($cars as &$car) {
        $car = $car->__toArray();
        $car['hrefShow'] = $this->generateUrl('app_car_show', ['id' => $car['id']]);
        $car['hrefEdit'] = $this->generateUrl('app_car_edit', ['id' => $car['id']]);
      }
      return new JsonResponse([
        'cars' => $cars,
        'hrefNew' => $this->generateUrl('app_car_new')
      ]);
    }
    return $this->render('car/index.html.twig', [
      'cars' => $carRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
  public function new(
    Request $request,
    EntityManagerInterface $entityManager
  ): Response
  {
    $car = new Car();
    $form = $this->createForm(CarType::class, $car);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->persist($car);
      $entityManager->flush();

      return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }

    if ($request->get('xhr')) {
      return $this->render('car/_new.html.twig', [
        'form' => $form,
        'action' => $this->generateUrl('app_car_new')
      ]);
    }

    return $this->render('base.html.twig');
  }

  #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
  public function show(
    Car $car,
    Request $request
  ): Response
  {
    if ($request->get('xhr')) {
      $car = $car->__toArray();
      $car['hrefEdit'] = $this->generateUrl('app_car_edit', ['id' => $car['id']]);
      $car['hrefIndex'] = $this->generateUrl('app_car_index');
      return new JsonResponse($car);
    }
    return $this->render('car/show.html.twig', [
      'car' => $car,
    ]);
  }

  #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
  public function edit(
    Request $request,
    Car $car,
    EntityManagerInterface $entityManager
  ): Response
  {
    $form = $this->createForm(CarType::class, $car);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->flush();

      return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }

    if ($request->get('xhr')) {
      return $this->render('car/_edit.html.twig', [
        'car' => $car,
        'form' => $form,
        'action' => $this->generateUrl('app_car_edit', ['id' => $car->getId()])
      ]);
    }

    return $this->render('base.html.twig');
  }

  #[Route('/{id}', name: 'app_car_delete', methods: ['POST'])]
  public function delete(
    Request $request,
    Car $car,
    EntityManagerInterface $entityManager
  ): Response
  {
    if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->getPayload()->getString('_token'))) {
      $entityManager->remove($car);
      $entityManager->flush();
    }

    return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
  }
}
