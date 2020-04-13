<?php


namespace MyProject\UserModule\Application\Services\Handler;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\UserModule\Application\Services\Query\GetUserMessages;

class GetUserMessagesHandler
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
     * @param GetUserMessages $query
     * @return ResultHandlerInterface
     */
    public function handle(GetUserMessages $query): ResultHandlerInterface
    {
        try {
            $this->resultHandler->setResult($this->getMessages($query->getUserId()));
        } catch (QueryException $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            $this->resultHandler->setErrors(["database" => ["Problem with database try later."]])->setCodeError();
        }
    }

    /**
     * @param int $userId
     * @return Collection
     */
    private function getMessages(int $userId)
    {
        return Collection::make();
    }
}
