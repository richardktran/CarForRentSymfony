<?php

namespace App\Mapper;

use App\Entity\Car;
use App\Entity\Rent;
use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Request\AddCarRequest;
use App\Request\Rent\AddRentRequest;
use Symfony\Component\Security\Core\Security;

class AddRentRequestToRent
{
    private CarRepository $carRepository;
    private Security $security;

    public function __construct(CarRepository $carRepository, Security $security)
    {
        $this->carRepository = $carRepository;
        $this->security = $security;
    }

    public function mapper(AddRentRequest $addRentRequest): Rent
    {
        /**
         * @var User $currentUser
         */
        $currentUser = $this->security->getUser();
        $carId = $addRentRequest->getCarId();
        $car = $this->carRepository->find($carId);
        $newRent = new Rent();
        $newRent->setStartDate($addRentRequest->getStartDate())
            ->setEndDate($addRentRequest->getEndDate());

        return $newRent;
    }
}
