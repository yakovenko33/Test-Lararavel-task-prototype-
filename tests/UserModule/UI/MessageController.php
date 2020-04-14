<?php


namespace Tests\UserModule\UI;


use Illuminate\Foundation\Testing\RefreshDatabase;
use MyProject\UserModule\Application\Middleware\UserLoginValidator;
use MyProject\UserModule\Application\Query\UserLogin;
use MyProject\UserModule\Application\Services\Handler\UserLoginHandler;
use Tests\TestCase;

class MessageController extends TestCase
{
    use RefreshDatabase;

    public function testAddMessage(): void
    {
        $jwtToken = $this->getJwtToken();

        $responseAddMessage = $this->json('POST','/api/user/messages', [
            "jwt_token" => $jwtToken,
            "message" => "New message"
        ]);

        $responseAddMessage
            ->assertStatus(201)
            ->assertJson([
                "data" => [
                    'message_id' => 1
                ],
                "status" => "success"
            ]);

        $responseAddMessageError = $this->json('POST','/api/user/messages', [
            "jwt_token" => $jwtToken . "23",
            "message" => "New message"
        ]);

        $responseAddMessageError
            ->assertStatus(403)
            ->assertJson([
                "data" => [
                    "authorization" => [
                        "User authorization failed."
                    ]
                ],
                "status" => "errors"
            ]);
    }

    public function testGetMessages(): void
    {
        $jwtToken = $this->getJwtToken();
        $responseAddMessage = $this->json('POST','/api/user/messages', [
            "jwt_token" => $jwtToken,
            "message" => "New message."
        ]);
        $responseAddMessage->assertStatus(201);

        $responseAddMessage1 = $this->json('POST','/api/user/messages', [
            "jwt_token" => $jwtToken,
            "message" => "New message2."
        ]);
        $responseAddMessage1->assertStatus(201);

        $responseGetMessages = $this->json('GET','/api/user/all/messages', [
            "jwt_token" => $jwtToken
        ]);
        $responseGetMessages
            ->assertStatus(200);
    }

    /**
     * @return string
     */
    private function getJwtToken(): string
    {
        $this->register();
        $userData = $this->login();

        return $userData["jwt_token"];
    }

    private function register(): void
    {
        $responseRegister = $this->json('POST','/api/user/register', [
            "email" => "test@gmail.com",
            "password" => "testPassword",
            "password_repeat" => "testPassword"
        ]);

        $responseRegister->assertStatus(201);
    }

    /**
     * @return array
     */
    private function login(): array
    {
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler(UserLogin::class, UserLoginHandler::class);
        $resultHandler = $bus->dispatch(
            UserLogin::class,
            [
                "email" => "test@gmail.com",
                "password" => "testPassword"
            ],
            [UserLoginValidator::class]
        );

        return $resultHandler->getResult();
    }
}
