<?php


namespace MyProject\UserModule\Application\Services\Handler;


use MyProject\CommonModule\CommonException\ProblemWithDatabase;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\CommonHandler\ResultHandler;
use MyProject\UserModule\Application\Command\UserRegister;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;

class UserRegisterHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var UsersRepositoryInterface
     */
    private $usersRepository;

    /**
     * UserRegisterHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param UsersRepositoryInterface $usersRepository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        UsersRepositoryInterface $usersRepository
    ) {
        $this->resultHandler = $resultHandler;
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param UserRegister $command
     * @return ResultHandler
     */
    public function handle(UserRegister $command): ResultHandlerInterface
    {
        try {
            $user = $this->usersRepository->insert($command->toArray());

            if (empty($user)) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setResult(["user_id" => $user->id])->setCode(201);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setCode(500);
        }

        return $this->resultHandler;
    }
}
