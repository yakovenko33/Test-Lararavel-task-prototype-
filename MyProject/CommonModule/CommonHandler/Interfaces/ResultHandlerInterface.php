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
     * @param mixed $result
     */
    public function setResult($result): void;

    /**
     * @return mixed
     */
    public function getResult();

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @param int $code
     * @return ResultHandlerInterface
     */
    public function setCodeError(int $code = 500): ResultHandlerInterface;

    /**
     * @return int
     */
    public function getCodeError(): int;
}
