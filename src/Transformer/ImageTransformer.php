<?php

namespace App\Transformer;

use App\Entity\Image;

class ImageTransformer extends BaseTransformer
{
    public const ALLOW = ['id', 'path'];

    public function toArray(Image $image): array
    {
        return $this->transform($image, static::ALLOW);
    }
}
