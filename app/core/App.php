<?php
    class App
    {

        protected $controller = 'dashboard';
        protected $method = 'index';
        protected $params = [];

        public function __construct(){

            $url = $this->parseUrl();
            


            include_once './app/controllers/login.php';
            $login = new login;
            if($login->checkLogin()){
                if($url[0] == 'login')
                {
                    if(isset($url[1])){
                        header('Location: '. './dashboard');
                        die();
                    }
                    else{
                        header('Location: '. 'dashboard');
                        die();
                    }
                }
            }
            else {
                if($url[0]!= 'login' && $url[0] != 'forgotpassword'){
                    if(isset($url[1])){
                        header('Location: '. './login');
                        die();
                    }
                    else{
                        header('Location: '. 'login');
                        die();
                    }
                }
            }



            if(file_exists('./app/controllers/'.$url[0].'.php')){
                $this->controller = $url[0];
                unset($url[0]);
                
            }



            include_once './app/controllers/'.$this->controller.'.php';

            $this->controller = new $this->controller;

            if(isset($url[1])){
                if(method_exists($this->controller,$url[1])){
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }

            $this->params = $url? array_values($url):[];

            call_user_func_array([$this->controller, $this->method], $this->params);


        }

        public function parseUrl(){
            if(isset($_GET['url'])){
                return explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
        }
    }

?>
