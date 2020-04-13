<?php


namespace MyProject\CommonModule\CommonHandler;


use Illuminate\Contracts\Validation\Validator as Result;
use MyProject\CommonModule\CommonHandler\Interfaces\CommandQueryInterface;

class CommandQuery implements CommandQueryInterface
{
     /**
     * @var Result
     */
    protected $validator;

    /**
     * @return Result
     */
    public function getValidator(): Result
    {
        return $this->validator;
    }
}
