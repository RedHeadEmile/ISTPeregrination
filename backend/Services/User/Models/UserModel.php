<?php

namespace ISTPeregrination\Services\User\Models;

class UserModel
{
    public int $id;
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $hashedPassword;

    public ?string $passwordRecoveryToken;
    public ?int $passwordRecoveryExpire;

    public function __construct(int $id, string $firstname, string $lastname, string $email, string $hashedPassword, ?string $passwordRecoveryToken, ?int $passwordRecoveryExpire)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->passwordRecoveryToken = $passwordRecoveryToken;
        $this->passwordRecoveryExpire = $passwordRecoveryExpire;
    }

    public function getAsViewModel(): array {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email
        ];
    }

    public static function fromDatabaseRecord(mixed $record): UserModel {
        return new UserModel(
            $record['id'],
            $record['firstname'],
            $record['lastname'],
            $record['email'],
            $record['hashed_password'],
            $record['password_recovery_token'] ?? null,
            $record['password_recovery_expire'] ?? null
        );
    }
}