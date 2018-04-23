<?php

class Classroom extends Controller{

    protected $user;

    public function __construct(){
      $this->user = $this->model('User');
      $this->user->username = $_SESSION['username'];

      if (isset($_POST) && !empty($_POST))
      {
          foreach ($_POST as $key => $value)
          {
            if(is_string($_POST[$key]))
              $_POST[$key] = $GLOBALS["con"]->real_escape_string($value);
          }
      }
    }

    public function index($name = null, $curr = null, $id = null){
      if(isset($name) && isset($curr) && isset($id))
        $this->view('classroom/topic/index');
      else
        $this->view('404/index');
    }

    public function test($currId = null, $topicId = null){
      if(isset($currId) && isset($topicId))
        $this->view('classroom/test/index');
      else
        $this->view('404/index');
    }



    public function getTopic($currId = null, $topicId = null){

      $data = new class{};

      if($topicId !=null && $currId != null){
        $course = $this->model('Course');
        $data = [
          "user"=>$this->user->getUserInfo(),
          "content" => $course->getClassroomContent($this->user,$currId, $topicId)
        ];


        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->data = json_encode($data);
        echo json_encode($GLOBALS["res"]);

      }
      else {
        $GLOBALS["res"]->code = 0;
        $GLOBALS["res"]->message = "Seems like you lost track! Heading back a little might help.";
        echo json_encode($GLOBALS["res"]);
      }
    }

    function getQuiz($curr, $topic , $type){
      $course = $this->model('Course');
      $course->getQuiz($curr, $topic, $type, $this->user);
    }

    public function submitQuiz(){
      if(!$GLOBALS['query']->find($_POST['quiz'], 'cnt_m_id', 'quiz_response', array('usr_i_id', 'cc_id'), array($this->user->getId(), $_POST['curr']), 'ss')){
        $hit = []; $miss = []; $correct = 0;
        foreach ($_POST['que'] as $qId => $answer) {
          $qAns = $GLOBALS['query']->select('qq_answer', 'quiz_question', 'qq_id', $qId, 's')->fetch_assoc()['qq_answer'];
          if(strtolower($qAns) == strtolower($answer)){
            ++$correct;
            $hit[] = $qId;
          }
          else {
            $miss[] = $qId;
          }
        }

        $score = ($correct/sizeof($_POST['que']))*100;

        $r = $GLOBALS['query']->insert(array('cnt_m_id', 'usr_i_id', 'qr_score', 'cc_id', 'qr_hit', 'qr_miss'),
                                      array($_POST['quiz'], $this->user->getId(), $score, $_POST['curr'], json_encode($hit), json_encode($miss)),
                                      'quiz_response',
                                     'ssssss');

        if($r){
          $GLOBALS["res"]->code = 1;
          $GLOBALS["res"]->data = $score;
          echo json_encode($GLOBALS["res"]);
        }
        else {
          $GLOBALS["res"]->code = 0;
          $GLOBALS["res"]->message = 'Something went wrong. Please try again.';
          echo json_encode($GLOBALS["res"]);
        }

      }
    }

    public function getPracticeQuestion($currId, $subtopicId){
      $course = $this->model('Course');
      $aws = $this->model('AwsSDK');
      if($course->isStudentInCurriculum($this->user,$currId) && $course->isDirInCurriculum($subtopicId, $currId)){
        $question = $course->getTestQuestion($subtopicId,$aws,true,$this->user);
        if(isset($question)){
          $GLOBALS['res']->code = 1;
          $GLOBALS['res']->data = $question;
          echo json_encode($GLOBALS['res']);
        }
        else{
          $GLOBALS['res']->code = 1;
          $GLOBALS['res']->data = false;
          echo json_encode($GLOBALS['res']);
        }
      }

    }

    public function checkPracticeQuestion($currId, $subtopicId){
      $course = $this->model('Course');

      if(isset($_POST['question'])){
        $questionId = $_POST['question'];
        $answer = isset($_POST['answer'])?$_POST['answer']: $_POST['sequence'];
        if($course->isStudentInCurriculum($this->user,$currId) && $course->isDirInCurriculum($subtopicId, $currId)){
          $result =  $course->checkPracticeQuestion($questionId, $answer, $this->user);
          $GLOBALS['res']->code = 1;
          $GLOBALS['res']->data = $result;
          echo json_encode($GLOBALS['res']);
        }
      }
    }

    public function getTest($currId = null, $conceptId = null){
      $aws = $this->model('AwsSDK');
      if($conceptId !=null && $currId != null){
        if($course->isStudentInCurriculum($this->user,$currId) && $course->isDirInCurriculum($conceptId, $currId)){
          $course = $this->model('Course');
          $data = $course->getConceptTestQuestion($conceptId, $aws);

          $GLOBALS['res']->code = 1;
          $GLOBALS['res']->data = $data;
          echo json_encode($GLOBALS['res']);
        }
      }
    }

}

 ?>
