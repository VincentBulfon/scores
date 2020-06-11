<?php


namespace Controllers;


class Login
{
    public function create()
    {
        $view = './views/login/create.php';


        return compact('view');
    }

    public function check()
    {
        //validation #TODO

        //Identification
        $email = $_POST['email'];
        $pwd = $_POST['password'];

        $userModel = new \Models\User();
        $user = $userModel->find($email);

        //Authentification
        if (password_verify($pwd, $user->password)) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
        } else {
            header('Location: index.php?action=view&resource=login-form');
        }
        exit;
    }

    public function delete()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header('Location: index.php ');
        exit();
    }
}