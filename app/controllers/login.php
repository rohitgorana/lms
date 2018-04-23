<?php

class Login extends Controller{


    public function index(){
        $this->view('login/index');

        if (isset($_POST) && !empty($_POST))
        {
            foreach ($_POST as $key => $value)
            {
                $_POST[$key] = $GLOBALS["con"]->real_escape_string($value);
            }
        }
    }

    public function attemptLogin(){
        $user = $this->model('User');
        $user->login();
    }

    public function checkLogin(){
        $user = $this->model('User');
        return $user->isLoggedIn();
    }
}

 ?>
