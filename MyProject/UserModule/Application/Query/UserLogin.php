<?php


namespace MyProject\UserModule\Application\Query;


class UserLogin
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * UserLogin constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
