<?php

namespace App\Controller\API;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Request\CarRequest;
use App\Service\CarService;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/cars')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    #[Route('/', name: 'list_car')]
    public function index(Request $request, ValidatorInterface $validator, CarRequest $carRequest): JsonResponse
    {
        $filters = $request->query->all();
        $carRequest = $carRequest->fromArray($filters);
        $validator->validate($carRequest);
        $cars = $this->carService->findAll($carRequest);
        $result = [];
        foreach ($cars as $car) {
            $result[] = $car->jsonSerialize();
        }

        return $this->success($result);
    }

    #[Route('/{id}', name: 'car_detail')]
    public function detail(Car $car): JsonResponse
    {
        return $this->success($car->jsonSerialize());
    }
}
