<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Rent;
use App\Manager\FileManager;
use App\Mapper\AddCarRequestToCar;
use App\Mapper\AddRentRequestToRent;
use App\Repository\ImageRepository;
use App\Repository\RentRepository;
use App\Request\Rent\AddRentRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RentService
{
    private RentRepository $rentRepository;
    private AddRentRequestToRent $addRentRequestToRent;

    public function __construct(RentRepository $rentRepository, AddRentRequestToRent $addRentRequestToRent)
    {
        $this->rentRepository = $rentRepository;
        $this->addRentRequestToRent = $addRentRequestToRent;
    }

    public function rent(AddRentRequest $addRentRequest): Rent
    {
        $rent = $this->addRentRequestToRent->mapper($addRentRequest);
        $this->rentRepository->save($rent);

        return $rent;
    }
}
