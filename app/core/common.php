<?php
    class Response{
        var $code;
        var $message;
        var $data;

        function __construct( $d="", $m = "", $c=1 ) {
            $this->data = $d;
            $this->message = $m;
            $this->code = $c;
        }
    }
    function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
    }
 ?>
