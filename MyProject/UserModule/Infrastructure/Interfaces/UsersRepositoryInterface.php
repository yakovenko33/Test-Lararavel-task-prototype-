<?php


namespace MyProject\UserModule\Infrastructure\Interfaces;


use MyProject\UserModule\Infrastructure\Models\User;

interface UsersRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function insert(array $data): ?User;

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): ?User;
}
