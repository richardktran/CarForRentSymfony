<?php

namespace App\Controller\API;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Service\CarService;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    #[Route('/', name: 'list')]
    public function index(Request $request): JsonResponse
    {
        $conditions = $request->query->all();
        $cars = $this->carService->findAll($conditions);
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
