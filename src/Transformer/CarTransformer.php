<?php

namespace App\Transformer;

use App\Entity\Car;
use App\Entity\User;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Request\AddCarRequest;
use Symfony\Component\Security\Core\Security;

class CarTransformer extends BaseTransformer
{
    public const ALLOW = ['id', 'name', 'description', 'color', 'brand', 'price', 'seats', 'year'];

    private ImageRepository $imageRepository;
    private Security $security;

    public function __construct(ImageRepository $imageRepository, Security $security)
    {
        $this->imageRepository = $imageRepository;
        $this->security = $security;
    }

    public function toArray(Car $car): array
    {
        $result = $this->transform($car, static::ALLOW);
        $result['thumbnail'] = $car->getThumbnail()->getPath();
        $result['createdUser'] = $car->getCreatedUser()->getEmail();

        return $result;
    }

    public function requestToEntity(AddCarRequest $addCarRequest): Car
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
