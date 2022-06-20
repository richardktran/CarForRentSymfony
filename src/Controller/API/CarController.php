<?php

namespace App\Controller\API;

use App\Entity\Car;
use App\Request\AddCarRequest;
use App\Request\CarRequest;
use App\Service\CarService;
use App\Traits\JsonResponseTrait;
use App\Transformer\CarTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(
        Request $request,
        ValidatorInterface $validator,
        CarRequest $carRequest,
        CarTransformer $carTransformer
    ): JsonResponse {
        $filters = $request->query->all();
        $carRequest = $carRequest->fromArray($filters);
        $error = $validator->validate($carRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $cars = $this->carService->findAll($carRequest);
        $result = [];
        foreach ($cars as $car) {
            $result[] = $carTransformer->toArray($car);
        }

        return $this->success($result);
    }

    #[Route('/{id}', name: 'detail')]
    public function detail(Car $car, CarTransformer $carTransformer): JsonResponse
    {
        return $this->success($carTransformer->toArray($car));
    }

    #[Route('/', name: 'add', methods: ['POST'])]
    public function store(
        Request $request,
        AddCarRequest $addCarRequest,
        ValidatorInterface $validator,
        CarService $carService,
        CarTransformer $carTransformer
    ): JsonResponse {
        $requestBody = json_decode($request->getContent(), true);
        $carRequest = $addCarRequest->fromArray($requestBody);
        $error = $validator->validate($carRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $car = $carTransformer->toArray($carService->add($carRequest));
        return $this->success($car);
    }
}
