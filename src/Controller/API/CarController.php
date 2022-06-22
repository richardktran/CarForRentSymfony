<?php

namespace App\Controller\API;

use App\Entity\Car;
use App\Request\AddCarRequest;
use App\Request\CarRequest;
use App\Request\UpdateCarRequest;
use App\Service\CarService;
use App\Traits\JsonResponseTrait;
use App\Transformer\CarTransformer;
use App\Transformer\ValidatorTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    private ValidatorTransformer $validatorTransformer;

    public function __construct(ValidatorTransformer $validatorTransformer)
    {
        $this->validatorTransformer = $validatorTransformer;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(
        Request $request,
        ValidatorInterface $validator,
        CarRequest $carRequest,
        CarService $carService,
        CarTransformer $carTransformer
    ): JsonResponse {
        $filters = $request->query->all();
        $carRequest = $carRequest->fromArray($filters);
        $errors = $validator->validate($carRequest);
        if (count($errors) > 0) {
            $errorsTransformer = $this->validatorTransformer->toArray($errors);
            return $this->error($errorsTransformer);
        }
        $cars = $carService->findAll($carRequest);
        $carsResult = $carTransformer->listToArray($cars);

        return $this->success($carsResult);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
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
        $errors = $validator->validate($carRequest);
        if (count($errors) > 0) {
            $errorsTransformer = $this->validatorTransformer->toArray($errors);

            return $this->error($errorsTransformer);
        }
        $car = $carTransformer->toArray($carService->add($carRequest));

        return $this->success($car);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Car $car,
        Request $request,
        UpdateCarRequest $updateCarRequest,
        CarService $carService,
        ValidatorInterface $validator,
        CarTransformer $carTransformer
    ): JsonResponse {
        $requestBody = json_decode($request->getContent(), true);
        $carRequest = $updateCarRequest->fromArray($requestBody);
        $errors = $validator->validate($carRequest);
        if (count($errors) > 0) {
            $errorsTransformer = $this->validatorTransformer->toArray($errors);

            return $this->error($errorsTransformer);
        }
        $car = $carService->put($car, $carRequest);
        $car = $carTransformer->toArray($car);

        return $this->success($car);
    }

    #[Route('/{id}', name: 'update_patch', methods: ['PATCH'])]
    public function patch(
        Car $car,
        Request $request,
        UpdateCarRequest $updateCarRequest,
        CarService $carService,
        ValidatorInterface $validator,
        CarTransformer $carTransformer
    ): JsonResponse {
        $requestBody = json_decode($request->getContent(), true);
        $carRequest = $updateCarRequest->fromArray($requestBody);
        $errors = $validator->validate($carRequest);
        if (count($errors) > 0) {
            $errorsTransformer = $this->validatorTransformer->toArray($errors);

            return $this->error($errorsTransformer);
        }
        $car = $carService->patch($car, $carRequest);
        $car = $carTransformer->toArray($car);

        return $this->success($car);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Car $car, CarService $carService, CarTransformer $carTransformer): JsonResponse
    {
        $carService->delete($car);

        return $this->success([], Response::HTTP_NO_CONTENT);
    }
}
