<?php


namespace MyProject\UserModule\Application\Services\Middleware;


use League\Tactician\Middleware;
use MyProject\CommonModule\Validator\ValidatorRoot;

class GetUserMessagesValidator extends ValidatorRoot implements Middleware
{
    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        return $this->validate($command->toArray()) ? $next($command) : $this->resultHandler;
    }

    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'jwt_token' => 'required|string',
        ];
    }
}
