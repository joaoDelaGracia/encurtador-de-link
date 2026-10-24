<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class RegisterDataDto extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function createDto(array $dadosRequest): self{

        return new self(
            $dadosRequest['name'],
            $dadosRequest['email'],
            $dadosRequest['password']
        );

    }
}
