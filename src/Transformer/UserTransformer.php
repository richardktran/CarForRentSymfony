<?php

namespace App\Transformer;

use App\Entity\User;

class UserTransformer extends BaseTransformer
{
    public const ALLOW = ['id', 'email'];

    public function toArray(User $user): array
    {
        return $this->transform($user, static::ALLOW);
    }
}
