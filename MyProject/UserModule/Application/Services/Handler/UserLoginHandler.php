<?php


namespace MyProject\UserModule\Application\Services\Handler;


use Illuminate\Support\Facades\Hash;
use MyProject\CommonModule\CommonException\ProblemWithDatabase;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\JWT\JwtDecorator;
use MyProject\UserModule\Application\Exception\UserLoginVerifyException;
use MyProject\UserModule\Application\Query\UserLogin;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;
use MyProject\UserModule\Infrastructure\Models\User;

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
            $user = $this->usersRepository->getByEmail($query->getEmail());

            $this->userEmpty($user);
            $this->userLoginVerify($query->getPassword(), $user->password);

            $this->resultHandler->setResult(JwtDecorator::createToken($user->jwtToArray()));
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setCodeError();
        } catch (UserLoginVerifyException $e) {
            $this->resultHandler->setErrors($e->getError())->setCodeError(401);
        }

        return $this->resultHandler;
    }

    /**
     * @param User $user
     * @throws ProblemWithDatabase
     */
    private function userEmpty(User $user): void
    {
        if (empty($user)) {
            throw new ProblemWithDatabase();
        }
    }

    /**
     * @param string $queryPassword
     * @param string $userPassword
     * @throws UserLoginVerifyException
     */
    private function userLoginVerify(string $queryPassword, string $userPassword): void
    {
        if (!Hash::check($queryPassword, $userPassword)) {
            throw new UserLoginVerifyException();
        }
    }
}
