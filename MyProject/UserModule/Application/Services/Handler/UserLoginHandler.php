<?php


namespace MyProject\UserModule\Application\Services\Handler;


use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\JWT\JwtDecorator;
use MyProject\UserModule\Application\Services\Exception\UserLoginVerifyException;
use MyProject\UserModule\Application\Services\Query\UserLogin;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;
use MyProject\UserModule\Models\User;

class UserLoginHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var
     */
    private $user;

    /**
     * @var UsersRepositoryInterface
     */
    private $usersRepository;

    /**
     * UserLoginHandler constructor.
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
     * @param UserLogin $query
     * @return ResultHandlerInterface
     */
    public function handle(UserLogin $query): ResultHandlerInterface
    {
        try {
            $user = $this->usersRepository->getUserByEmail($query->getEmail());

            if (!Hash::check($query->getPassword(), $user->password)) {
                throw new UserLoginVerifyException();
            }

            $this->resultHandler->setResult(JwtDecorator::createToken($user->jwtToArray()));
        } catch (QueryException $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            $this->resultHandler->setErrors(["database" => ["Problem with database try later."]])->setCodeError();
        } catch (UserLoginVerifyException $e) {
            $this->resultHandler->setErrors($e->getError())->setCodeError(401);
        }

        return $this->resultHandler;
    }
}
