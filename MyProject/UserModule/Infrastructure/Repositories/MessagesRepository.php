<?php


namespace MyProject\UserModule\Infrastructure\Repositories;


use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;
use MyProject\UserModule\Infrastructure\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessagesRepository implements MessagesRepositoryInterface
{
    /**
     * @param array $data
     * @return Message
     */
    public function insert(array $data): ?Message
    {
        try {
            $message = Message::create([
                'user_id' => $data['user_id'],
                'text' => $data['message'],
            ]);
            $message->save();
        } catch (QueryException $e) {
            $message = null;
            Log::error($e->getMessage() . $e->getTraceAsString());
        }

        return $message;
    }

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function getAllByUserId(int $userId): ?Collection
    {
        try {
            $messages = Message::where('user_id', $userId)->get();
        } catch (QueryException $e) {
            $messages = null;
            Log::error($e->getMessage() . $e->getTraceAsString());
        }

        return $messages;
    }

    /**
     * @return |null
     */
    public function deleteMoreOneHour(): void
    {
        try {
            DB::table("messages")
                ->where("created_at", "<", Carbon::parse(Carbon::now())->subHour())
                ->delete();
        } catch (QueryException $e) {
            $rows = null;
            Log::error($e->getMessage() . $e->getTraceAsString());
        }
    }
}
