<?php


namespace MyProject\UserModule\Application\Services\Handler;


use MyProject\CommonModule\CommonException\ProblemWithDatabase;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\UserModule\Application\Command\AddMessage;
use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;

class AddMessageHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var
     */
    private $messagesRepository;

    /**
     * AddMessageHandler constructor.
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
     * @param AddMessage $command
     * @return ResultHandlerInterface
     */
    public function handle(AddMessage $command): ResultHandlerInterface
    {
        try {
            $message = $this->messagesRepository->insert($command->toArray());

            if (empty($message)) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setResult(['message_id' => $message->id]);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setCodeError();
        }

        return $this->resultHandler;
    }
}
