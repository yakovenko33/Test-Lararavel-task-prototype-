<?php


namespace MyProject\UserModule\UI\Controllers;


use Joselfonseca\LaravelTactician\CommandBusInterface;
use MyProject\CommonModule\JWT\Middleware\JwtVerifyUser;
use MyProject\CommonModule\Response\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use MyProject\UserModule\Application\Command\AddMessage;
use MyProject\UserModule\Application\Services\Handler\AddMessageHandler;
use MyProject\UserModule\Application\Services\Handler\GetUserMessagesHandler;
use MyProject\UserModule\Application\Middleware\AddMessageValidator;
use MyProject\UserModule\Application\Middleware\GetUserMessagesValidator;
use MyProject\UserModule\Application\Query\GetUserMessages;

class MessageController extends Controller
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
    public function addMessage(Request $request): JsonResponse
    {
        $this->bus->addHandler(AddMessage::class, AddMessageHandler::class);
        $resultHandler = $this->bus->dispatch(
            AddMessage::class,
            $request->all(),
            [AddMessageValidator::class, JwtVerifyUser::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllUserMessages(Request $request): JsonResponse
    {
        $this->bus->addHandler(GetUserMessages::class, GetUserMessagesHandler::class);
        $resultHandler = $this->bus->dispatch(
            GetUserMessages::class,
            $request->all(),
            [GetUserMessagesValidator::class, JwtVerifyUser::class]
        );

        return $this->getResponse($resultHandler);
    }
}
