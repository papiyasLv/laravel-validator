<?php


namespace Papiyas\Validator\Facades;

use App\Enums\ApiCodeEnum;
use Illuminate\Support\Facades\Facade;

/**
 * Class Message
 * @package Papiyas\Validator\Facades
 * @method static message(int $apiCode = ApiCodeEnum::failure, string $message = ''): array
 *
 * @see \Papiyas\Validator\Message
 */
class Message extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'message';
    }
}
