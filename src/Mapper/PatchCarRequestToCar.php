<?php

namespace App\Mapper;

use App\Entity\Car;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Request\UpdateCarRequest;

class PatchCarRequestToCar
{
    private ImageRepository $imageRepository;
    private UserRepository $userRepository;

    public function __construct(ImageRepository $imageRepository, UserRepository $userRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->userRepository = $userRepository;
    }

    public function mapper(Car $car, UpdateCarRequest $updateCarRequest): Car
    {
        $createdUserId = $updateCarRequest->getCreatedUser();
        if (null !== $createdUserId) {
            $createdUser = $this->userRepository->find($createdUserId);
            $car->setCreatedUser($createdUser);
        }
        $thumbnailId = $updateCarRequest->getThumbnail();
        if (null !== $thumbnailId) {
            $thumbnail = $this->imageRepository->find($thumbnailId);
            $car->setThumbnail($thumbnail);
        }

        $car->setName($updateCarRequest->getName() ?? $car->getName())
            ->setDescription($updateCarRequest->getDescription() ?? $car->getDescription())
            ->setColor($updateCarRequest->getColor() ?? $car->getColor())
            ->setBrand($updateCarRequest->getBrand() ?? $car->getBrand())
            ->setPrice($updateCarRequest->getPrice() ?? $car->getPrice())
            ->setSeats($updateCarRequest->getSeats() ?? $car->getSeats())
            ->setYear($updateCarRequest->getYear() ?? $car->getYear());

        return $car;
    }
}
