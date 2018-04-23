<?php

class ForgotPassword extends Controller{

    private function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    private function verifytoken($token){
        $user = $this->model('User');
        return $user->getUserIdFromPasswordResetToken($token);
    }

    public function index(){
        $this->view('forgetpassword/index');
    }

    public function setnew($token){
       $userId = $this->verifytoken($token);
       if(isset($userId)){
        $this->view('forgetpassword/newpassword', $token);
       }
       else{
           $this-view('404/index');
       }
    }

    public function reset(){
        $userId = $this->verifytoken($_POST['token']);
        if(isset($userId)){
            $user = $this->model('User');
            $result = $user->resetPassword($userId, $_POST['password']);
            if($result){
                $GLOBALS["res"]->code = 1;
                $GLOBALS["res"]->message = "Success";
                echo json_encode($GLOBALS["res"]);
            }
            else{
                $GLOBALS["res"]->code = 0;
                $GLOBALS["res"]->message = "Something went wrong. Please try again.";
                echo json_encode($GLOBALS["res"]);
            }
        }
    }

    public function sendresetlink(){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<32;$i++){
            $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
        }

        $user = $this->model('User');
        // $user->addPasswordResetToken()

        echo $token;
        
    }

}

 ?>
