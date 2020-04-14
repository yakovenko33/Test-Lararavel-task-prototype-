<?php


namespace MyProject\CommonModule\Validator;


use Illuminate\Contracts\Validation\Validator as Result;
use Illuminate\Support\Facades\Validator;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;

class ValidatorRoot
{
    /**
     * @var ResultHandlerInterface
     */
    protected $resultHandler;

    /**
     * UserRegisterValidator constructor.
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(ResultHandlerInterface $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function validate(array $data): bool
    {
        $validator = $this->make($data);
        if ($validator->fails()) {
            $this->resultHandler
                ->setErrors($validator->errors()->getMessages())
                ->setCode(400);

            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @return Result
     */
    protected function make(array $data = [])
    {
        return Validator::make($data, $this->getRules());
    }
}
