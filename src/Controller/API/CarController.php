<?php

namespace App\Controller\API;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    #[Route('/', name: 'list')]
    public function index(): JsonResponse
    {
        $cars = $this->carRepository->findAll();
        $result = [];
        foreach ($cars as $car) {
            $result[] = $car->jsonSerialize();
        }
        return $this->success($result);
    }

    #[Route('/{id}', name: 'detail')]
    public function detail(Car $car): JsonResponse
    {
        return $this->success($car->jsonSerialize());
    }
}
