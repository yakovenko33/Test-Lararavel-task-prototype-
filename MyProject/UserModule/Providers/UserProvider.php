<?php


namespace MyProject\UserModule\Providers;


use Illuminate\Support\ServiceProvider;
use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use MyProject\CommonModule\CommonHandler\ResultHandler;
use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;
use MyProject\UserModule\Infrastructure\Interfaces\UsersRepositoryInterface;
use MyProject\UserModule\Infrastructure\Repositories\MessagesRepository;
use MyProject\UserModule\Infrastructure\Repositories\UsersRepository;
use MyProject\UserModule\UI\Console\DeleteMessagesMoreOneHour;

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
        $this->commands([
            DeleteMessagesMoreOneHour::class
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../UI/Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Migrations');
    }
}
