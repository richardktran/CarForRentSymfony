<?php

namespace App\Service;

use App\Entity\Car;
use App\Mapper\AddCarRequestToCar;
use App\Mapper\UpdateCarRequestToCar;
use App\Repository\CarRepository;
use App\Request\AddCarRequest;
use App\Request\CarRequest;
use App\Request\UpdateCarRequest;

class CarService
{
    private CarRepository $carRepository;
    private AddCarRequestToCar $addCarRequestToCar;
    private UpdateCarRequestToCar $updateCarRequestToCar;

    public function __construct(
        CarRepository $carRepository,
        AddCarRequestToCar $addCarRequestToCar,
        UpdateCarRequestToCar $updateCarRequestToCar
    ) {
        $this->carRepository = $carRepository;
        $this->addCarRequestToCar = $addCarRequestToCar;
        $this->updateCarRequestToCar = $updateCarRequestToCar;
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

    public function update(Car $car, UpdateCarRequest $carRequest): Car
    {
        $updatedCar = $this->updateCarRequestToCar->mapper($car, $carRequest);
        $this->carRepository->save($updatedCar);
        return $car;
    }

    public function delete(Car $car): void
    {
        $this->carRepository->remove($car);
    }
}
