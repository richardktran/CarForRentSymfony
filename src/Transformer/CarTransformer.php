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

    public function toArray(Car $car): array
    {
        $result = $this->transform($car, static::ALLOW);
        $result['thumbnail'] = $car->getThumbnail()->getPath();
        $result['createdUser'] = $car->getCreatedUser()->getEmail();

        return $result;
    }
}
