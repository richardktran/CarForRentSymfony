<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your ADMIN!',
            'path' => 'src/Controller/API/Admin.php',
        ]);
    }
}
