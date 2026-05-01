<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class RegisterData extends Data
{    
    public function __construct(
        #[StringType, Required, Min(3)]
        public string $name,
        #[Email(Email::RfcValidation), Required, Unique('users')]
        public string $email,
        #[StringType, Required, Confirmed, Password(8, true, true, true, true), ]
        public string $password,
        public string $passwordConfirmation
    ) {}
}
