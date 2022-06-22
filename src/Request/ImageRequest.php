<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ImageRequest
{
    #[Assert\Image(
        maxSize: '5M',
        mimeTypes: ['image/*'],
        mimeTypesMessage: 'Please upload a valid image',
    )]
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }
}
