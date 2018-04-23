<?php

class Watch extends Controller{

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
      $role = $this->user->getRole();
      $course = $this->model('Course');
      if($role == 'student'){
        if(isset($_GET['id']) && isset($_GET['curr'])){
          if($course->isStudentInCurriculum($this->user,$_GET['curr']) ){
            if($course->isContentInCurriculum($_GET['id'],$_GET['curr'])){
              $aws = $this->model('AwsSDK');
              $content = $course->getContentInfo($_GET['id']);
              if($content['type'] == 'webm' || $content['type'] == 'mp4'){
                $stream = $this->model('Stream',$content['path']);
                $this->user->log("watch_history", [$_GET['id'], $_GET['curr']]);
                $stream->start();
              }
              else {
                $stream = $this->model('Stream',$content['path']);
                $this->user->log("watch_history", [$_GET['id'], $_GET['curr']]);
                $stream->streamDoc();
              }
            }
          }
        }
      }
      else {
        if(isset($_GET['id'])){
          if($course->isContentAuthorised($_GET['id'],$this->user->getId()) ){
            $aws = $this->model('AwsSDK');
            $content = $course->getContentInfo($_GET['id']);
            if($content['type'] == 'webm' || $content['type'] == 'mp4'){
              $stream = $this->model('Stream',$content['path']);
              $stream->start($aws);
            }
            else {
              $stream = $this->model('Stream',$content['path']);
              $stream->streamDoc();
            }
          }
        }
      }




    }

}

 ?>
