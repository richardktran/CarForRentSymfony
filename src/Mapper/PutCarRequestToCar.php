<?php

namespace App\Mapper;

use App\Entity\Car;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Request\UpdateCarRequest;

class PutCarRequestToCar
{
    private ImageRepository $imageRepository;
    private UserRepository $userRepository;

    public function __construct(ImageRepository $imageRepository, UserRepository $userRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->userRepository = $userRepository;
    }

    public function mapper(Car $car, UpdateCarRequest $putCarRequest): Car
    {
        $createdUser = $this->userRepository->find($putCarRequest->getCreatedUser());
        $thumbnailId = $putCarRequest->getThumbnail();
        $thumbnail = $this->imageRepository->find($thumbnailId);
        $car->setName($putCarRequest->getName())
            ->setDescription($putCarRequest->getDescription())
            ->setColor($putCarRequest->getColor())
            ->setBrand($putCarRequest->getBrand())
            ->setPrice($putCarRequest->getPrice())
            ->setSeats($putCarRequest->getSeats())
            ->setYear($putCarRequest->getYear())
            ->setCreatedUser($createdUser)
            ->setThumbnail($thumbnail);

        return $car;
    }
}
