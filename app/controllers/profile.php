<?php

  class Profile extends Controller{

    protected $user;

    public function __construct(){
      $this->user = $this->model('User');
      $this->user->username = $_SESSION['username'];
      if (isset($_POST) && !empty($_POST))
      {
          foreach ($_POST as $key => $value)
          {
              $_POST[$key] = $GLOBALS["con"]->real_escape_string($value);
          }
      }
    }

    public function index(){
        $this->view('profile/index');
    }

      public function getData(){
        $info = $this->user->getUserInfo();
        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->data = json_encode($info);
        echo json_encode($GLOBALS["res"]);
      }

    public function updateProfile(){
      $this->user->updateProfile($_POST);
    }

    public function updateProfilePicture(){
       $aws = $this->model('AwsSDK');
      $this->user->updateProfilePicture($aws);
    }

    public function profilePicture(){
      $aws = $this->model('AwsSDK');
      $pic = 's3://a2z-store-production/'. $this->user->username.'/profile.jpg';
      header('Content-Type: image/jpeg');
      if(file_exists($pic))
        readfile($pic);
      else
        readfile('./assets/dist/img/user.jpg');

    }

    public function changePassword(){
      $old = $_POST['old-pw'];
      $new = $_POST['new-pw'];

      $this->user->changePassword($old, $new);
    }

  }
?>
