<?php


namespace MyProject\CommonModule\CommonHandler;

//use MyProject\CommonModule\CommonHandler\Interfaces

use MyProject\CommonModule\CommonHandler\Interfaces\CommandQueryInterface;

abstract class AbstractHandler
{
    /**
     * @var ResultHandler
     */
    private $resultHandler;

    /**
     * UserRegisterHandler constructor.
     * @param ResultHandler $resultHandler
     */
    public function __construct(ResultHandler $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @return ResultHandler
     */
    public function handle(CommandQueryInterface $commandQuery): ResultHandler//: array
    {
        if ($commandQuery->getValidator()->fails()) {
            $this->resultHandler->setErrors($commandQuery->getValidator()->errors()->messages());

            return $this->resultHandler;
        }

        $this->handleService($commandQuery);

        return $this->resultHandler;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     */
    abstract protected function handleService(CommandQueryInterface $commandQuery): void;
}
