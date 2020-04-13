<?php


namespace MyProject\UserModule\Application\Services\Handler;


use Illuminate\Database\QueryException;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Support\Facades\Log;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\CommonHandler\ResultHandler;
use MyProject\UserModule\Application\Services\Command\UserRegister;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;
use MyProject\UserModule\Models\User;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\DB;

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
    public function handle(UserRegister $command): ResultHandlerInterface//: array
    {
        $user = $this->usersRepository->insertUser($command->toArray());
        if (!empty($user)) {
            $this->resultHandler->setResult(["user_id" => $user->id]);
        } else {
            $this->resultHandler->setErrors(["database" => ["Problem with database try later."]])->setCodeError();
        }

        /*try {
            $this->resultHandler->setResult(["user_id" => $this->usersRepository->insertUser($command->toArray())]);//$this->addUser($command)
        } catch (QueryException $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            $this->resultHandler->setErrors(["database" => ["Problem with database try later."]])->setCodeError();
        }*/

        return $this->resultHandler;
    }
}
