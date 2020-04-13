<?php


namespace MyProject\UserModule\Application\Validation;


use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as Result;

class UserRegister
{
    /**
     * @param array $data
     * @return Result
     */
    public function make(array $data = [])
    {
        return Validator::make($data, $this->getRules());
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'email' => 'required|string|max:50|unique:users,email|',
            'password' => 'required|string|max:50|',
        ];
    }
}
