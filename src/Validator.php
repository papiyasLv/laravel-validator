<?php


namespace Papiyas\Validator;

use App\Enums\ApiCodeEnum;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator as BaseValidator;
use Papiyas\Validator\Facades\Message;

class Validator extends BaseValidator
{
    private $failedStatus = ApiCodeEnum::failure;

    public function getFailedStatus(): int
    {
        return $this->failedStatus;
    }


    public function passes()
    {
        $this->messages = new MessageBag;

        [$this->distinctValues, $this->failedRules] = [[], []];

        // We'll spin through each rule, validating the attributes attached to that
        // rule. Any error messages will be added to the containers with each of
        // the other error messages, returning true if we don't have messages.
        foreach ($this->rules as $attribute => $rules) {
            if ($this->shouldBeExcluded($attribute)) {
                $this->removeAttribute($attribute);

                continue;
            }

            foreach ($rules as $rule) {
                $this->validateAttribute($attribute, $rule);

                if ($this->shouldBeExcluded($attribute)) {
                    $this->removeAttribute($attribute);

                    break;
                }

                // 取消Laravel原生单属性停止检查
//                if ($this->shouldStopValidating($attribute)) {
//                    break;
//                }

                /**
                 * 一旦遇到错误则立即停止, 不再查找其它错误信息
                 * @author papiyas
                 */
                if (!empty($this->failedRules)) {
                    break 2;
                }
            }
        }

        // Here we will spin through all of the "after" hooks on this validator and
        // fire them off. This gives the callbacks a chance to perform all kinds
        // of other validation that needs to get wrapped up in this operation.
        foreach ($this->after as $after) {
            $after();
        }

        return $this->messages->isEmpty();
    }

    /**
     * @return string
     */
    public function getFailedMessage(): string
    {
        // 获取错误的校验字段名
        $key = key($this->failedRules);
        // 获取错误规则信息
        $error = $this->failedRules[$key];

        // 获取错误规则名称
        $ruleName = key($error);


        if (!$message = $this->errors()->messages()[$key][0]) {
            $message = call_user_func([Message::class, Str::snake($ruleName)], $key, ...$error[$ruleName]);
        }

        return $message;
    }


    protected function getMessage($attribute, $rule)
    {
        $inlineMessage = $this->getInlineMessage($attribute, $rule);

        // First we will retrieve the custom message for the validation rule if one
        // exists. If a custom validation message is being used we'll return the
        // custom message, otherwise we'll keep searching for a valid message.
        if (is_array($inlineMessage)) {
            list($this->failedStatus, $inlineMessage) = $inlineMessage;
        } elseif (is_integer($inlineMessage)) {
            $this->failedStatus = $inlineMessage;
            $inlineMessage = '';
        }

        return $inlineMessage;


        // 取消额外的自定义消息读取
    }
}
