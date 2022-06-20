<?php

namespace App\Service;

use App\Entity\Car;
use App\Mapper\AddCarRequestToCar;
use App\Repository\CarRepository;
use App\Request\AddCarRequest;
use App\Request\CarRequest;

class CarService
{
    private CarRepository $carRepository;
    private AddCarRequestToCar $addCarRequestToCar;

    public function __construct(CarRepository $carRepository, AddCarRequestToCar $addCarRequestToCar)
    {
        $this->carRepository = $carRepository;
        $this->addCarRequestToCar = $addCarRequestToCar;
    }

    public function findAll(CarRequest $carRequest): array
    {
        return $this->carRepository->all($carRequest);
    }

    public function add(AddCarRequest $carRequest): Car
    {
        $car = $this->addCarRequestToCar->mapper($carRequest);
        $this->carRepository->save($car);
        return $car;
    }

    public function delete(Car $car): void
    {
        $this->carRepository->remove($car);
    }
}
