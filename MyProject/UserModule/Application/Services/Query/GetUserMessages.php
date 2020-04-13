<?php


namespace MyProject\UserModule\Application\Services\Query;


use MyProject\CommonModule\JWT\Command\VerifyCommandQuery;

class GetUserMessages extends VerifyCommandQuery
{
    /**
     * GetUserMessagesHandler constructor.
     * @param string|null $jwtToken
     */
    public function __construct(string $jwtToken = null)
    {
        parent::__construct($jwtToken);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'jwt_token' => $this->jwtToken
        ];
    }
}
