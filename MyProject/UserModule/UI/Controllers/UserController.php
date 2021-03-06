<?php


namespace MyProject\UserModule\UI\Controllers;


use App\Http\Controllers\Controller;
use Joselfonseca\LaravelTactician\CommandBusInterface;
use MyProject\CommonModule\Response\Response;
use MyProject\UserModule\Application\Command\UserRegister;
use MyProject\UserModule\Application\Services\Handler\UserLoginHandler;
use MyProject\UserModule\Application\Services\Handler\UserRegisterHandler;
use Illuminate\Http\Request;
use MyProject\UserModule\Application\Middleware\UserRegister\CheckPassword;
use MyProject\UserModule\Application\Middleware\UserLoginValidator;
use MyProject\UserModule\Application\Middleware\UserRegister\UserRegisterValidator;
use \Illuminate\Http\JsonResponse;
use MyProject\UserModule\Application\Query\UserLogin;

class UserController extends Controller
{
    use Response;
    /**
     * @var CommandBusInterface
     */
    private $bus;

    /**
     * UserController constructor.
     * @param CommandBusInterface $bus
     */
    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $this->bus->addHandler(UserRegister::class, UserRegisterHandler::class);
        $resultHandler = $this->bus->dispatch(
            UserRegister::class,
            $request->all(),
            [UserRegisterValidator::class, CheckPassword::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $this->bus->addHandler(UserLogin::class, UserLoginHandler::class);
        $resultHandler = $this->bus->dispatch(
            UserLogin::class,
            $request->all(),
            [UserLoginValidator::class]
        );

        return $this->getResponse($resultHandler);
    }
}
