<?php


namespace Papiyas\Validator\Exceptions;

use Exception;
use Papiyas\Api\Facades\Api;

class ValidationException extends Exception
{
    public function render()
    {
        return Api::failure($this->code, $this->message);
    }
}
