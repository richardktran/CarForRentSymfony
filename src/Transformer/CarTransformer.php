<?php

namespace App\Transformer;

use App\Entity\Car;

class CarTransformer extends BaseTransformer
{

    const ALLOW = ['id', 'name', 'description', 'color', 'brand', 'price', 'seats', 'year'];

    public function toArray(Car $car): array
    {
        $result = $this->transform($car, static::ALLOW);
        $result['thumbnail'] = $car->getThumbnail()->getPath();
        $result['createdUser'] = $car->getCreatedUser()->getEmail();
        return $result;
    }
}
