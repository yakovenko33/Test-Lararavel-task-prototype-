<?php


namespace MyProject\UserModule\Application\Services\Command;


use MyProject\CommonModule\JWT\Command\VerifyCommandQuery;


class AddMessage extends VerifyCommandQuery
{
    /**
     * @var string
     */
    private $message;

    /**
     * AddMessage constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data['jwt_token']);
        $this->message = $data['message'];
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'jwt_token' => $this->jwtToken
        ];
    }
}
