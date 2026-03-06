<?php

namespace ISTPeregrination\Services\User;

use ISTPeregrination\Common\SingletonTrait;
use ISTPeregrination\Exceptions\EmailAlreadyExistingException;
use ISTPeregrination\Exceptions\InvalidEmailException;
use ISTPeregrination\Exceptions\NotFoundException;
use ISTPeregrination\Exceptions\PasswordTooWeakException;
use ISTPeregrination\Services\Database\DatabaseService;
use ISTPeregrination\Services\Email\EmailService;
use ISTPeregrination\Services\User\Models\UserModel;
use Random\RandomException;

class UserService implements IUserService
{
    use SingletonTrait;

    public function __construct()
    {
    }

    private function fetchUserByEmail(string $email): ?UserModel
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetchAll(\PDO::FETCH_NAMED);
        $rsAmount = count($result);
        if ($rsAmount === 0)
            return null;

        if ($rsAmount > 1)
            throw new \RuntimeException("Multiple users with the same email found in database, this should not happen");

        return UserModel::fromDatabaseRecord($result[0]);
    }

    public function register(UserModel $user, string $password): ?UserModel
    {
        $conflictingUser = $this->fetchUserByEmail($user->email);
        if ($conflictingUser !== null)
            throw new EmailAlreadyExistingException();

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL))
            throw new InvalidEmailException();

        if (strlen($user->email) <= 0 || strlen($user->email) > 255)
            throw new InvalidEmailException();

        if (strlen($user->firstname) <= 0 || strlen($user->firstname) > 255)
            throw new InvalidEmailException();

        if (strlen($user->lastname) <= 0 || strlen($user->lastname) > 255)
            throw new InvalidEmailException();

        if (strlen($password) < 8)
            throw new PasswordTooWeakException();

        $user->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->lastname = strtoupper($user->lastname);

        $stmt = DatabaseService::getInstance()->getPDO()->prepare("INSERT INTO user (email, hashedpassword, firstname, lastname) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $user->email,
            $user->hashedPassword,
            $user->firstname,
            $user->lastname
        ]);
        $lastInsertId = DatabaseService::getInstance()->getPDO()->lastInsertId();
        if ($lastInsertId === false)
            throw new \RuntimeException("Failed to retrieve last insert id after user registration");

        $user->id = intval($lastInsertId);

        return $user;
    }

    public function login(string $email, string $password): ?UserModel
    {
        $user = $this->fetchUserByEmail($email);
        if ($user === null)
            return null;

        if (!password_verify($password, $user->hashedPassword))
            return null;

        $_SESSION['user'] = $user;
        return $user;
    }

    public function logout(): void
    {
        session_destroy();
    }

    /**
     * @param int $length
     * @param string $keyspace
     * @return string
     * @throws RandomException
     */
    private function randomStr(
        int $length,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new \InvalidArgumentException('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    public function sendResetPassword(string $email): void
    {
        $user = $this->fetchUserByEmail($email);
        if ($user === null)
            return;

        $token = $this->randomStr(200);
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("UPDATE user SET passwordrecoverytoken = ?, passwordrecoveryexpire = ? WHERE userid = ?");
        $stmt->execute([
            $token,
            currentTimeInMillis() + (10 * 60 * 1000),
            $user->id,
        ]);

        EmailService::getInstance()->send(
            $user->email,
            $user->firstname . " " . $user->lastname,
            "Réinitialisation de votre mot de passe",
            "Bonjour " . $user->firstname . ",\n\n" .
            "Vous avez demandé une réinitialisation de votre mot de passe. Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :\n\n" .
            $_ENV["FRONTEND_URL"] . "/resetpassword?token=" . $token . "\n\n" .
            "Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email.\n"
        );
    }

    public function resetPassword(string $token, string $newPassword): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("SELECT * FROM user WHERE passwordrecoverytoken = ?");
        $stmt->execute([$token]);
        $result = $stmt->fetchAll(\PDO::FETCH_NAMED);
        if (count($result) === 0)
            return;

        if (count($result) > 1)
            throw new \RuntimeException("Multiple users with the same password recovery token found in database, this should not happen");

        $user = UserModel::fromDatabaseRecord($result[0]);
        if ($user->passwordRecoveryExpire === null || currentTimeInMillis() > $user->passwordRecoveryExpire)
            throw new \RuntimeException("Password reset token has expired");

        if (strlen($newPassword) < 8)
            throw new PasswordTooWeakException();

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("UPDATE user SET hashedpassword = ?, passwordrecoverytoken = NULL, passwordrecoveryexpire = NULL WHERE userid = ?");
        $stmt->execute([
            $hashedPassword,
            $user->id,
        ]);
    }

    public function getAllUsers(): array
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("SELECT * FROM user");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_NAMED);
        $users = [];
        foreach ($result as $record) {
            $users[] = UserModel::fromDatabaseRecord($record);
        }
        return $users;
    }
}
