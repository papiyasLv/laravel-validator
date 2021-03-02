<?php


namespace Papiyas\Validator\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static \Papiyas\Validator\Validator make(array $data, array $rules, array $messages = [], array $customAttributes = [])
 * @method static void extend(string $rule, \Closure|string $extension, string $message = null)
 * @method static void extendImplicit(string $rule, \Closure|string $extension, string $message = null)
 * @method static void replacer(string $rule, \Closure|string $replacer)
 * @method static array validate(array $data, array $rules, array $messages = [], array $customAttributes = [])
 *
 * @see \Papiyas\Validator\Factory
 */
class Validator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'papiyas_validator';
    }
}
