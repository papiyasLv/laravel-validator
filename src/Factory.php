<?php


namespace Papiyas\Validator;

use Illuminate\Validation\Factory as ValidationFactory;
use Papiyas\Validator\Exceptions\ValidationException;

class Factory extends ValidationFactory
{
    /**
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return Validator
     */
    protected function resolve(array $data, array $rules, array $messages, array $customAttributes)
    {
        if (is_null($this->resolver)) {
            return new Validator($this->translator, $data, $rules, $messages, $customAttributes);
        }

        return call_user_func($this->resolver, $this->translator, $data, $rules, $messages, $customAttributes);
    }

    public function make(array $data, array $rules, array $messages = [], array $customAttributes = []): Validator
    {
        /**
         * @var Validator $validator
         */
        $validator = parent::make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new ValidationException($validator->getFailedMessage(), $validator->getFailedStatus());
        }

        return $validator;
    }
}
