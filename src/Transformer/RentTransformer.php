<?php

namespace App\Transformer;

use App\Entity\Image;
use App\Entity\Rent;

class RentTransformer extends BaseTransformer
{
    public const ALLOW = ['status', 'startDate', 'endDate'];

    public function toArray(Rent $rent): array
    {
        $result = $this->transform($rent, static::ALLOW);
        $result['user'] = $rent->getUser()->getUserIdentifier();
        $result['car'] = $rent->getCar()->getName();

        return $result;
    }
}
