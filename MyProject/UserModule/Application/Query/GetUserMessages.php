<?php


namespace MyProject\UserModule\Application\Query;


use MyProject\CommonModule\JWT\Command\VerifyCommandQuery;

class GetUserMessages extends VerifyCommandQuery
{
    /**
     * GetUserMessages constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data["jwt_token"]);
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
