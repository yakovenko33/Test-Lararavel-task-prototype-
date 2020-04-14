<?php


namespace MyProject\UserModule\Application\Services\Handler;


use MyProject\CommonModule\CommonException\ProblemWithDatabase;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\UserModule\Application\Query\GetUserMessages;
use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;

class GetUserMessagesHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var MessagesRepositoryInterface
     */
    private $messagesRepository;

    /**
     * GetUserMessagesHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param MessagesRepositoryInterface $messagesRepository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        MessagesRepositoryInterface $messagesRepository
    ) {
        $this->resultHandler = $resultHandler;
        $this->messagesRepository = $messagesRepository;
    }

    /**
     * @param GetUserMessages $query
     * @return ResultHandlerInterface
     */
    public function handle(GetUserMessages $query): ResultHandlerInterface
    {
        try {
            $messages = $this->messagesRepository->getAllByUserId($query->getUserId());

            if(empty($messages)) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setResult(["messages" => $messages->toArray()]);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setCodeError();
        }

        return $this->resultHandler;
    }
}
