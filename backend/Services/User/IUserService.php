<?php

namespace ISTPeregrination\Services\User;

use ISTPeregrination\Exceptions\EmailAlreadyExistingException;
use ISTPeregrination\Exceptions\InvalidEmailException;
use ISTPeregrination\Exceptions\InvalidNameException;
use ISTPeregrination\Exceptions\PasswordTooWeakException;
use ISTPeregrination\Services\User\Models\UserModel;

interface IUserService
{
    /**
     * @param UserModel $user The user information to register, including email and other details.
     * @param string $password The password for the user, which will be securely hashed before storage.
     * @return UserModel|null Returns the created user if registration is successful, or null if registration fails (e.g., email already exists)
     * @throws EmailAlreadyExistingException
     * @throws InvalidEmailException
     * @throws InvalidNameException
     * @throws PasswordTooWeakException
     */
    function register(UserModel $user, string $password): ?UserModel;

    /**
     * Attempts to log in a user using the provided email and password. The method will verify the credentials against the stored user data.
     * @param string $email The email provided by the user, which will be used to look up the corresponding user record in the database.
     * @param string $password The password provided by the user, which will be compared against the securely stored hashed password.
     * @return UserModel|null Returns the logged user if the credentials are correct, or null if the login fails (e.g., invalid credentials)
     */
    function login(string $email, string $password): ?UserModel;

    /**
     * Logs out the currently authenticated user by clearing their session or authentication token, effectively ending their authenticated session and requiring them to log in again for future access.
     * @return void
     */
    function logout(): void;

    /**
     * Initiates the password reset process for a user by sending a password reset email to the provided email address. This typically involves generating a secure token, storing it temporarily, and sending an email with instructions on how to reset the password using that token.
     * @param string $email The email address of the user who has requested a password reset. The system will use this email to identify the user and send the password reset instructions.
     * @return void
     */
    function sendResetPassword(string $email): void;

    /**
     * Resets the user's password using the provided token and new password. The method will verify the token's validity, ensure it matches the user who requested the reset, and then securely update the user's password in the database.
     * @param string $token The unique token that was generated and sent to the user's email as part of the password reset process. This token is used to verify the legitimacy of the password reset request and to identify the user who is attempting to reset their password.
     * @param string $newPassword The new password that the user wants to set, which will be securely hashed before being stored in the database.
     * @return void
     * @throws PasswordTooWeakException
     */
    function resetPassword(string $token, string $newPassword): void;

    /**
     * Get all the registered users.
     * @return UserModel[] An array of all users in the system.
     */
    function getAllUsers(): array;
}