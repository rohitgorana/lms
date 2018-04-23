<?php

class Logout extends Controller{


    public function index(){
      $user = $this->model('User');
      $user->logout();
    }


}

 ?>
