<?php


namespace MyProject\CommonModule\CommonHandler\Interfaces;


use Illuminate\Contracts\Validation\Validator as Result;

interface CommandQueryInterface
{
    /**
     * @return Result
     */
    public function getValidator(): Result;
}
