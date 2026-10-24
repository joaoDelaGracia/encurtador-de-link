<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends ApiException
{

    public function __construct() {
        parent::__construct('Credenciais inválidas');
    }

}
