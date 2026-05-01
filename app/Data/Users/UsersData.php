<?php

namespace App\Data\Users;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\CamelCaseMapper;

#[MapOutputName(CamelCaseMapper::class)]
class UsersData extends Data
{   
    public function __construct(
        public string $id,
        #[StringType(), Min(3)]
        public string $name,
        #[Email(Email::RfcValidation)]
        public string $email
    ) {}
}
