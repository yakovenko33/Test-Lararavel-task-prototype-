<?php


namespace Tests\UserModule\UI;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use \Illuminate\Testing\TestResponse;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterErrorEmailHasAlready(): void
    {
        $response = $this->creatUserDefault();

        $response
            ->assertStatus(201)
            ->assertJson([
                "data" => ["user_id" => 1],
                "status" => "success",
            ]);

        $response = $this->creatUserDefault();

        $response
            ->assertStatus(400)
            ->assertJson([
                "data" => [
                    "email" => [
                        "The email has already been taken."
                    ]
                ],
                "status" => "errors",
            ]);
   }

   /**
    * @return array
    */
    public function dataProviderRegister(): array
    {
        $request = [
            "email" => "test@gmail.com",
            "password" => "testPassword",
            "password_repeat" => "testPassword"
        ];

        return [
            [
                array_merge($request, ["email" => null]),
                [
                    "email" => [
                        "The email field is required."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["email" => Str::random(51). "@gmail.com"]),
                [
                    "email" => [
                        "The email may not be greater than 50 characters."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["email" => "1234"]),
                [
                    "email" => [
                        "The email must be a valid email address."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["email" => "test@gmail.com"]),
                ["user_id" => 2],
                "success",
                201,
            ],
            [
                array_merge($request, ["password" => null]),
                [
                    "password" => [
                        "The password field is required."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password" => Str::random(51)]),
                [
                    "password" => [
                        "The password may not be greater than 50 characters."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password" => 1111]),
                [
                    "password" => [
                        'The password must be a string.'
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password" => "testPassword"]),
                ["user_id" => 3],
                "success",
                201,
            ],
            [
                array_merge($request, ["password_repeat" => null]),
                [
                    "password_repeat" => [
                        "The password repeat field is required."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password_repeat" => Str::random(51)]),
                [
                    "password_repeat" => [
                        "The password repeat may not be greater than 50 characters."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password_repeat" => 1111]),
                [
                    "password_repeat" => [
                        'The password repeat must be a string.'
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password_repeat" => "testPasswordRepeat"]),
                [
                    "password_repeat" => [
                        "Password and password_repeat are not equivalent."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password_repeat" => "testPassword"]),
                ["user_id" => 4],
                "success",
                201,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderRegister
     * @param $request
     * @param $data
     * @param $status
     * @param $code
     */
    public function testRegisterValidate($request, $data, $status, $code): void
    {
        $response = $this->json('POST','/api/user/register', $request);

        $response
            ->assertStatus($code)
            ->assertJson([
                "data" => $data,
                "status" => $status,
            ]);
    }

    public function testLoginValidateEmail(): void
    {
        $responseRegister = $this->creatUserDefault();

        $responseRegister
            ->assertStatus(201)
            ->assertJson([
                "data" => ["user_id" => 5],
                "status" => "success",
            ]);

        $responseLogin = $this->json('POST','/api/user/login', [
            "email" => "new-test@gmail.com",
            "password" => "testPassword",
        ]);

        $responseLogin
            ->assertStatus(400)
            ->assertJson([
                "data" => [
                    "email" => [
                        "The selected email is invalid."
                    ]
                ],
                "status" => "errors",
            ]);

        $responseLogin = $this->json('POST','/api/user/login', [
            "email" => "test@gmail.com",
            "password" => "testPassword",
        ]);

        $responseLogin
            ->assertStatus(200);
    }

    public function dataProviderLogin(): array
    {
        $request = [
            "email" => "test@gmail.com",
            "password" => "testPassword",
        ];

        return [
            [
                array_merge($request, ["email" => null]),
                [
                    "email" => [
                        "The email field is required."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["email" => Str::random(51) . "@gmail.com"]),
                [
                    "email" => [
                        "The email may not be greater than 50 characters."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["email" => Str::random(20)]),
                [
                    "email" => [
                        "The selected email is invalid.",
                        "The email must be a valid email address."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["email" => "test@gmail.com"]),
                [
                    "email" => [
                        "The selected email is invalid.",
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password" => null]),
                [
                    "email" => [
                        "The selected email is invalid.",
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ],
                "errors",
                400,
            ],
            [
                array_merge($request, ["password" => Str::random(51)]),
                [
                    "email" => [
                        "The selected email is invalid.",
                    ],
                    "password" => [
                        "The password may not be greater than 50 characters."
                    ]
                ],
                "errors",
                400,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLogin
     * @param $request
     * @param $data
     * @param $status
     * @param $code
     */
    public function testLoginValidateError($request, $data, $status, $code): void
    {
        $responseLogin = $this->json('POST','/api/user/login', $request);

        $responseLogin
            ->assertStatus($code)
            ->assertJson([
                "data" => $data,
                "status" => $status,
            ]);
    }

    /**
     * @return TestResponse
     */
    private function creatUserDefault(): TestResponse
    {
        return $this->json('POST','/api/user/register', [
            "email" => "test@gmail.com",
            "password" => "testPassword",
            "password_repeat" => "testPassword"
        ]);
    }
}
