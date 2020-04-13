<?php


namespace MyProject\UserModule\Application\Services\Handler;


use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\UserModule\Application\Services\Command\AddMessage;
use MyProject\UserModule\Models\Message;

class AddMessageHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * UserLoginHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(ResultHandlerInterface $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param AddMessage $command
     * @return ResultHandlerInterface
     */
    public function handle(AddMessage $command): ResultHandlerInterface
    {
        /*echo "<pre>";
        var_dump([
            'user_id' => $command->getUserId(),
            'message' => $command->getMessage()
        ]);
        die;*/
        try {
            echo "<pre>";
            var_dump($this->addMessage($command));
            die;
            $this->resultHandler->setResult(['message_id' => $this->addMessage($command)]);
        } catch (QueryException $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            $this->resultHandler->setErrors(["database" => ["Problem with database try later."]])->setCodeError();
        }

        return $this->resultHandler;
    }

    /**
     * @param AddMessage $command
     * @return int
     */
    private function addMessage(AddMessage $command): int
    {
        $message = Message::create([
            'user_id' => $command->getUserId(),
            'text' => $command->getMessage()
        ]);
        $message->save();

        return $message->id;
    }
}
