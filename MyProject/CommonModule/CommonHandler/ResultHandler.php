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
     * @var mixed
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
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
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
    public function setCodeError(int $code = 500): ResultHandlerInterface
    {
        $this->codeError = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getCodeError(): int
    {
        return $this->codeError;
    }
}
