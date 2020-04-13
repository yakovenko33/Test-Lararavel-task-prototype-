<?php


namespace MyProject\UserModule\Infrastructure\Interfaces;


use MyProject\UserModule\Infrastructure\Models\User;

interface UsersRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function insertUser(array $data): ?User;

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): ?User;
}
