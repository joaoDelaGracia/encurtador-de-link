<?php

namespace App\Data\Auth;

use App\Models\User;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Cookie;

class LoginResultDto extends Data
{
    public function __construct(
        public readonly Cookie $cookie,
        public readonly User $user
    ) {}

}
