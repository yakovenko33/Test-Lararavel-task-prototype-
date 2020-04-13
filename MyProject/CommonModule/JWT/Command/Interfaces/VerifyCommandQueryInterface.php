<?php


namespace MyProject\CommonModule\JWT\Command\Interfaces;


interface VerifyCommandQueryInterface
{
    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void;

    /**
     * @return int
     */
    public function getUserId(): int;

    /**
     * @return string
     */
    public function getJwtToken(): string;
}
