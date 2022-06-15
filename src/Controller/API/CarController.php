<?php

namespace App\Controller\API;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    #[Route('/', name: 'list')]
    public function index(): JsonResponse
    {
        $cars = $this->carRepository->findAll();
        dd($cars);
    }
}
