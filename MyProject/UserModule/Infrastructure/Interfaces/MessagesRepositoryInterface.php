<?php


namespace MyProject\UserModule\Infrastructure\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use MyProject\UserModule\Infrastructure\Models\Message;

interface MessagesRepositoryInterface
{
    /**
     * @param array $data
     * @return Message|null
     */
    public function insert(array $data): ?Message;

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function getAllByUserId(int $userId): ?Collection;

    public function deleteMoreOneHour(): void;
}
