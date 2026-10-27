<?php

namespace App\Data\Link;

use Spatie\LaravelData\Data;

class RegisterLinkDto extends Data
{
   
    public function __construct(
        public readonly string $originalUrl,
        public readonly string $title,
        public readonly string|null $expiresAt
    )
    {}
}
