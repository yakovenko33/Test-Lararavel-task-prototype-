<?php


namespace MyProject\UserModule\UI\Controllers;


use App\Http\Controllers\Controller;
use Joselfonseca\LaravelTactician\CommandBusInterface;
use MyProject\CommonModule\Response\Response;
use MyProject\UserModule\Application\Services\Command\UserRegister;
use MyProject\UserModule\Application\Services\Handler\UserLoginHandler;
use MyProject\UserModule\Application\Services\Handler\UserRegisterHandler;
use Illuminate\Http\Request;
use MyProject\UserModule\Application\Services\Middleware\UserRegister\CheckPassword;
use MyProject\UserModule\Application\Services\Middleware\UserLoginValidator;
use MyProject\UserModule\Application\Services\Middleware\UserRegister\UserRegisterValidator;
use \Illuminate\Http\JsonResponse;
use MyProject\UserModule\Application\Services\Query\UserLogin;

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
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        //Log::debug("UserController::test()");
        return response()->json(['UserController' => "test"], 200);
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

    /**
     * @return array
     */
    private function testData(): array
    {
        return [
            "email" => "test@gmail.com",
            "password" => "1234",
            "password_repeat" => "1234"
        ];
    }
}
