<?php


namespace MyProject\CommonModule\CommonHandler\Interfaces;


interface ResultHandlerInterface
{
    /**
     * @param array $errors
     * @return ResultHandlerInterface
     */
    public function setErrors(array $errors): ResultHandlerInterface;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @param array $result
     * @return ResultHandlerInterface
     */
    public function setResult(array $result): ResultHandlerInterface;

    /**
     * @return mixed
     */
    public function getResult(): array;

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @param int $code
     * @return ResultHandlerInterface
     */
    public function setCode(int $code = 200): ResultHandlerInterface;

    /**
     * @return int
     */
    public function getCode(): int;
}
