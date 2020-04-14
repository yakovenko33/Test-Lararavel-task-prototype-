<?php


namespace MyProject\UserModule\Application\Middleware\UserRegister;


use League\Tactician\Middleware;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;

class CheckPassword implements Middleware
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * CheckPassword constructor.
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(ResultHandlerInterface $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        if (!($command->getPassword() === $command->getPasswordRepeat())) {
            $this->resultHandler
                ->setErrors(["password_repeat" => ["Password and password_repeat are not equivalent"]])
                ->setCodeError(400);

            return $this->resultHandler;
        }

        return $next($command);
    }
}
