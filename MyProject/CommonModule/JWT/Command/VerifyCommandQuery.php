<?php


namespace MyProject\CommonModule\JWT\Command;


use MyProject\CommonModule\JWT\Command\Interfaces\VerifyCommandQueryInterface;

class VerifyCommandQuery implements VerifyCommandQueryInterface
{
    /**
     * @var string
     */
    protected $jwtToken;

    /**
     * @var integer
     */
    protected $userId;

    /**
     * VerifyCommandQuery constructor.
     * @param string $jwtToken
     */
    public function __construct(string $jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getJwtToken(): string
    {
        return $this->jwtToken;
    }
}
