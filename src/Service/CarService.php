<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Entity\Car;
use App\Request\CarRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CarService
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function findAll(CarRequest $carRequest): array
    {
        return $this->carRepository->all($carRequest);
    }


}
