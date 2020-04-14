<?php


namespace MyProject\UserModule\Infrastructure\Repositories;


use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;
use MyProject\UserModule\Infrastructure\Models\User;

class UsersRepository implements UsersRepositoryInterface
{
    /**
     * @param array $data
     * @return User|null
     */
    public function insert(array $data): ?User
    {
        try {
            $user = User::create([
                "email" => $data["email"],
                "password" => Hash::make($data["password"]),
                "status" => User::STATUS_ACTIVE
            ]);
            $user->save();
        } catch (QueryException $e) {
            $user = null;
            Log::error($e->getMessage() . $e->getTraceAsString());
        }

        return $user;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): ?User
    {
        try {
            $user = User::where("email", $email)->first();
        } catch (QueryException $e) {
            $user = null;
            Log::error($e->getMessage() . $e->getTraceAsString());
        }

        return $user;
    }
}
