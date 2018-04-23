<?php

class Controller
{



    public function model($model, $arg = null){
        require_once './app/models/'.$model.'.php';
        if($arg != null)
            return new $model($arg);
        else
            return new $model();
    }

    public function view($view, $data=[]){
        require_once './app/views/'.$view.'.php';

    }
}

?>
