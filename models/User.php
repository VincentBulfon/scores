<?php


namespace Models;


class User extends Model
{
    public function find(string $email): \stdClass
    {
        $userRequest = 'SELECT * FROM users WHERE email = :email';
        $pdoSt = $this->pdo->prepare($userRequest);
        $pdoSt->execute(['email' => $email]);

        return $pdoSt->fetch();

    }

    public function Save(array $user)
    {
        try {
            $userRequest = 'INSERT INTO users(`name`, `email`, `password`) VALUES (:name, :email, :password)';
            $pdoSt = $this->pdo->prepare($userRequest);
            $pdoSt->execute(['name' => $user['name'], 'email' => $user['email'], 'password' => $user['password']]);
        } catch
        (\PDOException $e) {
            die($e->getMessage());
        }
    }
}