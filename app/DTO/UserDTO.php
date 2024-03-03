<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        private string $name,
        private string $surname,
        private string $email,
        private int    $age,
        private int $password
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getPassword(): string
    {
        return $this->password;
    }




    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            surname: $data['surname'],
            email: $data['email'],
            age: $data['age'],
            password: $data['password'],
        );
    }

}
