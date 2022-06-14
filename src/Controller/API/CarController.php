<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/', name: 'list')]
    public function index(): JsonResponse
    {
        return $this->success([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/API/CarController.php',
        ]);
    }

}
