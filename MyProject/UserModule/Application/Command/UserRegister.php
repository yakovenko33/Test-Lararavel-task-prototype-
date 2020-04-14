<?php


namespace MyProject\UserModule\Application\Command;


class UserRegister
{
    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string|null
     */
    private $passwordRepeat;

    /**
     * UserRegister constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->passwordRepeat = $data['password_repeat'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "email" => $this->email,
            "password" => $this->password,
            "password_repeat" => $this->passwordRepeat
        ];
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getPasswordRepeat(): ?string
    {
        return $this->passwordRepeat;
    }
}
