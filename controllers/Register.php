<?php


namespace Controllers;


class Register
{
    function register(){
        $view = './views/register/create.php';


        return compact('view');
    }
}