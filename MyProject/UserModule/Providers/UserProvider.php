<?php


namespace MyProject\UserModule\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\CommonHandler\ResultHandler;
use MyProject\UserModule\Application\Services\Command\UserRegister;
use MyProject\UserModule\Application\Services\Handler\UserRegisterHandler;
use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;
use MyProject\UserModule\Infrastructure\Repositories\MessagesRepository;
use MyProject\UserModule\Infrastructure\Repositories\UsersRepository;

class UserProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        ResultHandlerInterface::class => ResultHandler::class,
        UsersRepositoryInterface::class => UsersRepository::class,
        MessagesRepositoryInterface::class => MessagesRepository::class
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../UI/Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Migrations');

        //$this->registerCommandsQueriesHandlers();
    }

    private function registerCommandsQueriesHandlers(): void
    {
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');

        $bus->addHandler(UserRegister::class, UserRegisterHandler::class);
    }

    /*private function registerCommandsQueriesHandlers(): void
    {
        Bus::map([
            UserRegister::class => UserRegisterHandler::class
        ]);
    }*/
}
