<?php

namespace App\Mapper;

use App\Entity\Car;
use App\Entity\User;
use App\Repository\ImageRepository;
use App\Request\AddCarRequest;
use Symfony\Component\Security\Core\Security;

class AddCarRequestToCar
{
    private ImageRepository $imageRepository;
    private Security $security;

    public function __construct(ImageRepository $imageRepository, Security $security)
    {
        $this->imageRepository = $imageRepository;
        $this->security = $security;
    }

    public function mapper(AddCarRequest $addCarRequest): Car
    {
        /**
         * @var User $currentUser
         */
        $currentUser = $this->security->getUser();
        $thumbnailId = $addCarRequest->getThumbnail();
        $thumbnail = $this->imageRepository->find($thumbnailId);
        $car = new Car();
        $car->setName($addCarRequest->getName())
            ->setDescription($addCarRequest->getDescription())
            ->setColor($addCarRequest->getColor())
            ->setBrand($addCarRequest->getBrand())
            ->setPrice($addCarRequest->getPrice())
            ->setSeats($addCarRequest->getSeats())
            ->setYear($addCarRequest->getYear())
            ->setCreatedUser($currentUser)
            ->setThumbnail($thumbnail);

        return $car;
    }
}
