<?php

namespace App\Service;

use App\Entity\Car;
use App\Mapper\AddCarRequestToCar;
use App\Mapper\PatchCarRequestToCar;
use App\Mapper\PutCarRequestToCar;
use App\Repository\CarRepository;
use App\Request\AddCarRequest;
use App\Request\CarRequest;
use App\Request\UpdateCarRequest;

class CarService
{
    private CarRepository $carRepository;
    private AddCarRequestToCar $addCarRequestToCar;
    private PutCarRequestToCar $putCarRequestToCar;
    private PatchCarRequestToCar $patchCarRequestToCar;

    public function __construct(
        CarRepository $carRepository,
        AddCarRequestToCar $addCarRequestToCar,
        PutCarRequestToCar $putCarRequestToCar,
        PatchCarRequestToCar $patchCarRequestToCar
    ) {
        $this->carRepository = $carRepository;
        $this->addCarRequestToCar = $addCarRequestToCar;
        $this->putCarRequestToCar = $putCarRequestToCar;
        $this->patchCarRequestToCar = $patchCarRequestToCar;
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

    public function put(Car $car, UpdateCarRequest $carRequest): Car
    {
        $updatedCar = $this->putCarRequestToCar->mapper($car, $carRequest);
        $this->carRepository->save($updatedCar);
        return $car;
    }

    public function patch(Car $car, UpdateCarRequest $carRequest): Car
    {
        $updatedCar = $this->patchCarRequestToCar->mapper($car, $carRequest);
        $this->carRepository->save($updatedCar);
        return $car;
    }

    public function delete(Car $car): void
    {
        $this->carRepository->remove($car);
    }
}
