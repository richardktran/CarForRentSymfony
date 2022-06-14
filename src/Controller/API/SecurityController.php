<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Traits\JsonResponseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/auth', name: 'auth_')]
class SecurityController extends AbstractController
{
    use JsonResponseTrait;

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/login', name: 'login', methods: 'POST')]
    public function login(JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        $user = $this->getUser();
        $token = $JWTTokenManager->create($user);
        return $this->success([
            'user' => $user->jsonSerialize(),
            'token' => $token
        ]);
    }
}
