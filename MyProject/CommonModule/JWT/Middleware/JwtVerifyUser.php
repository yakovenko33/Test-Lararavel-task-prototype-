<?php


namespace MyProject\CommonModule\JWT\Middleware;


use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\JWT\Command\Interfaces\VerifyCommandQueryInterface;
use MyProject\CommonModule\JWT\JwtDecorator;
use League\Tactician\Middleware;

class JwtVerifyUser implements Middleware
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * UserRegisterValidator constructor.
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(ResultHandlerInterface $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param VerifyCommandQueryInterface $command
     * @param callable $next
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        try {
            $decoded = JwtDecorator::getDataByToken($command->getJwtToken());
            $command->setUserId($decoded->data->id);
        } catch (\Exception $e) {
            $this->resultHandler
                ->setErrors(["authorization" => ["User authorization failed."]])
                ->setCode(403);

            return $this->resultHandler;
        }

        return $next($command);
    }
}
