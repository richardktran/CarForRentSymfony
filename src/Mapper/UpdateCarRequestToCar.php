<?php

namespace App\Mapper;

use App\Entity\Car;
use App\Entity\User;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Request\AddCarRequest;
use App\Request\UpdateCarRequest;
use Symfony\Component\Security\Core\Security;

class UpdateCarRequestToCar
{
    private ImageRepository $imageRepository;
    private UserRepository $userRepository;

    public function __construct(ImageRepository $imageRepository, UserRepository $userRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->userRepository = $userRepository;
    }

    public function mapper(Car $car, UpdateCarRequest $addCarRequest): Car
    {
        $createdUser = $this->userRepository->find($addCarRequest->getCreatedUser());
        $thumbnailId = $addCarRequest->getThumbnail();
        $thumbnail = $this->imageRepository->find($thumbnailId);
        $car->setName($addCarRequest->getName())
            ->setDescription($addCarRequest->getDescription())
            ->setColor($addCarRequest->getColor())
            ->setBrand($addCarRequest->getBrand())
            ->setPrice($addCarRequest->getPrice())
            ->setSeats($addCarRequest->getSeats())
            ->setYear($addCarRequest->getYear())
            ->setCreatedUser($createdUser)
            ->setThumbnail($thumbnail);
        return $car;
    }
}
