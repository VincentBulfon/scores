<?php


namespace Models;


class User extends Model
{
    public  function find(string $email): \stdClass{
        $userRequest = 'SELECT * FROM users WHERE email = :email';
        $pdoSt = $this->pdo->prepare($userRequest);
        $pdoSt->execute(['email'=>$email]);

        return $pdoSt->fetch();
    }
}