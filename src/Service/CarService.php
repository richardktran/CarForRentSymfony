<?php

namespace App\Service;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Request\AddCarRequest;
use App\Request\CarRequest;
use App\Transformer\CarTransformer;

class CarService
{
    private CarRepository $carRepository;
    private CarTransformer $carTransformer;

    public function __construct(CarRepository $carRepository, CarTransformer $carTransformer)
    {
        $this->carRepository = $carRepository;
        $this->carTransformer = $carTransformer;
    }

    public function findAll(CarRequest $carRequest): array
    {
        return $this->carRepository->all($carRequest);
    }

    public function add(AddCarRequest $carRequest): Car
    {
        $car = $this->carTransformer->requestToEntity($carRequest);
        $this->carRepository->save($car);
        return $car;
    }
}
