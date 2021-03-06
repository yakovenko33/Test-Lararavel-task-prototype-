<?php


namespace MyProject\UserModule\Application\Middleware;


use League\Tactician\Middleware;
use MyProject\CommonModule\Validator\ValidatorRoot;

class UserLoginValidator extends ValidatorRoot implements Middleware
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
            'email' => 'required|string|max:50|exists:users,email|email:rfc,dns',
            'password' => 'required|string|max:50|',
        ];
    }
}
