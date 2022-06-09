<?php

namespace App\Service;

use App\Entity\Car;
use Symfony\Component\HttpFoundation\Response;

class CarService
{
    public function createNewCar($car)
    {
        dd($car);
        $image = $form->get('image')->getData();
        $imageName = $uploadImageService->upload($image);
        if ($imageName === "") {
            return new Response("Upload image fail");
        }
        $newCar->setImage('/uploads/' . $imageName);

        $this->entityManager->persist($newCar);
        $this->entityManager->flush();
    }
}
