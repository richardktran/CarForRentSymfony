<?php

namespace App\Transformer;

use App\Entity\User;

class UserTransformer
{
    public function toArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];
    }
}
