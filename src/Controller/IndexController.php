<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
  #[Route('/', name: 'app_index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
  }
}
