<?php

namespace App\EventListener;

use App\Traits\JsonResponseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSuccessListener
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = [];
        $token = $event->getData()['token'];
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }
        $jsonUser = $this->serializer->serialize($user, JsonEncoder::FORMAT);
        $data[] = [
            'data' => $jsonUser,
            'token' => $token
        ];

        $event->setData($data);
    }
}
