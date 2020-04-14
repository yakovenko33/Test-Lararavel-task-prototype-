<?php


namespace MyProject\CommonModule\CommonHandler;


use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;

class ResultHandler implements ResultHandlerInterface
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $result;

    /**
     * @var int
     */
    private $codeError;

    /**
     * @param array $errors
     * @return ResultHandlerInterface
     */
    public function setErrors(array $errors): ResultHandlerInterface
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $result
     * @return ResultHandlerInterface
     */
    public function setResult(array $result): ResultHandlerInterface
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @param int $code
     * @return ResultHandlerInterface
     */
    public function setCode(int $code = 500): ResultHandlerInterface
    {
        $this->codeError = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->codeError;
    }
}
