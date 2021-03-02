<?php


namespace Papiyas\Validator;


use App\Enums\ApiCodeEnum;

/**
 * Class Message
 * @package Papiyas\Validator
 * 主要用于处理Validation校验数据时的错误提示
 */
class Message
{
    public function message($apiCode = ApiCodeEnum::failure, $message = ''): array {
        return [$apiCode, $message];
    }

//    public function required($name): string {
//        return __('validation.not_empty', ['name' => $this->trans($name)]);
//    }

//    public function regex($name, $rule) {
//        return __('validation.format_error', ['0' => $this->trans($name), '1' => $rule]);
//    }

    protected function trans($key): string {
        return __('message.' . $key);
    }

    public function __call(string $name, array $arguments): string
    {
        $arguments[0] = $this->trans($arguments[0]);
        return __('validation.' . $name, $arguments);
    }
}
