<?php

namespace App\Controller\API;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/auth', name: 'auth_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login', methods: 'POST')]
    public function login(JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        $user = $this->getUser();
        $token = $JWTTokenManager->create($user);
        if ($user === null) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $this->json([
            'user' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'token' => $token
        ]);
    }
}
