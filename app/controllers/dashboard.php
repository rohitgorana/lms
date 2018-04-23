<?php

class Dashboard extends Controller{

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

    public function index(){

        $this->view('dashboard/index');


    }

    public function getUserManagement(){
      $users = $this->user->getUsersToManage();
      $stats = $users['stats'];
      $table = [
        'name'        =>  "user-list",
        'noOfTabs'    =>  sizeof($users['roles']),
        'noOfColumns' =>  sizeof($users['users'])>0?sizeof($users['users'][0])-2:0,
        'data'        =>  [],
        'columnNames' =>  ['Full Name', 'Username', 'Email', 'Contact'],
        'tabNames'    =>  $users['roles']
      ];

      foreach ($users['roles'] as $role) {
        $temp = [];
        foreach ($users['users'] as $user) {
          if($user["usr_ro_name"]== $role)
            $temp[] = [$user['usr_i_full_name'],$user['usr_i_username'],$user['usr_i_emailid'],$user['usr_i_contactno'],$user['usr_i_id']];
        }
        $table['data'][]= $temp;
      }

      $institutes = $this->model('Institute')->getAllInstitutes();
      $insList = [];
      foreach ($institutes as $institute) {
        $insList[] = $institute[0];
      }

      $data = [
        'header'      =>  ['stats' => $stats],
        'main'        =>  ['dataTable' => $table],
        'additional'  =>  [
                            'roles'       => $this->user->getRoles()
                          ]
      ];
      $role = $this->user->getRole();
      if($role != 'instructor' && $role != 'dean') {
        $data['additional']['institutes'] = $insList;
      }



      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);

    }


    public function getInstituteManagement(){
      $institute = $this->model('Institute');
      $institutes = $institute->getAllInstitutes();

      $stats = ['Institute'  => sizeof($institutes)];
      $table = [
        'name' => "ins-list",
        'noOfTabs' => null,
        'noOfColumns' => sizeof(sizeof($institutes)>0? $institutes[0]: [])-1,
        'data' => $institutes,
        'columnNames' => ['Institute Name', 'Code', 'Website', 'Address', 'Contact No']
      ];


      $data = [
        'header'      =>  ['stats' => $stats],
        'main'        =>  ['dataTable' => $table]
      ];

      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);

    }

    public function getCourseManagement(){
      $course = $this->model('Course');

      $courses = $course->getAllCourses($this->user);

      $data = [
        'header'      =>  ['pathNavBar' => []],
        'main'        =>  ['explorer' => $courses]
      ];

      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);

    }
    public function getQuizResponses(){
      $course = $this->model('Course');

      $users = $this->user->getUsersToManage();
      $data = [];

      foreach ($users['users'] as $user) {

        if($user["usr_ro_name"]== 'student'){
          $temp = [
            'name' => $user['usr_i_full_name'],
            'username' =>$user['usr_i_username'],
            'email' => $user['usr_i_emailid'],
            'contact' => $user['usr_i_contactno'],
            'id' => $user['usr_i_id']
          ];
          $data[]= $temp;
        }
      }



      $data = [
        'header'      =>  ['nothing' => []],
        'main'        =>  ['responses' => $data]
      ];

      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);

    }

    public function getCurriculumManagement(){
      $course = $this->model('Course');
      $curriculums = $course->getCurriculum($this->user);
      $courses = $course->getAllCourses($this->user);

      $stats = ['Curriculum'  => sizeof($curriculums)];

      $users = $this->user->getUsersToManage();
      $table = [
        'noOfTabs'    =>  sizeof($users['roles']),
        'noOfColumns' =>  sizeof($users['users'])>0?sizeof($users['users'][0])-2:0,
        'data'        =>  [],
        'columnNames' =>  ['Full Name', 'Username', 'Email', 'Contact'],
        'tabNames'    =>  $users['roles']
      ];
      foreach ($users['roles'] as $role) {
        $temp = [];
        foreach ($users['users'] as $user) {
          if($user["usr_ro_name"]== $role)
            $temp[] = [$user['usr_i_full_name'],$user['usr_i_username'],$user['usr_i_emailid'],$user['usr_i_contactno'],$user['usr_i_id']];
        }
        $table['data'][]= $temp;
      }


      $data = [
        'header'      =>  ['stats' => $stats],
        'main'        =>  ['currList' => $curriculums],
        'additional'  =>  [
                            'users'   =>  $table,
                            'courses' =>  $courses
                          ]
      ];

      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);
    }

    public function getCurriculum(){
      $course = $this->model('Course');
      $curr = $course->getCurriculum($this->user);
      return $curr;
    }

    public function getCourseContent($currId, $courseId){
      $course = $this->model('Course');
      if($course->isStudentInCurriculum($this->user, $currId) && $course->isDirInCurriculum($courseId, $currId)){

        $courseContent = $course->getCourseContent($currId, $courseId, $this->user);
        
        $data = [
          'header'      =>  [],
          'main'        =>  ['courseView' => $courseContent],
          'additional'  =>  []
        ];



        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->data = $data;
        echo json_encode($GLOBALS["res"]);

      }
    }



    public function getData(){
        $role = $this->user->getrole();
        $data = new class{};
        $data->user = $this->user->getUserInfo();
        switch($role){
            case "superadmin" :   $data->sidebar = [
                                    'DASHBOARD'  => [
                                      ['data'=>['method' => 'getUserManagement', 'id' => 'user'], 'name'=> 'User', 'children' => []],
                                      ['data'=>['method' => 'getInstituteManagement', 'id' => 'institute'], 'name'=> 'Institute', 'children' => []],
                                      ['data'=>['method' => 'getCourseManagement', 'id' => 'course'], 'name'=> 'Courses', 'children' => []]
                                    ]
                                  ];


                                  $data->map = ['type' => 'local'];


                                  break;

            case "admin"      :   $data->sidebar = [
                                    'DASHBOARD'  => [
                                      ['data'=>['method' => 'getUserManagement', 'id' => 'user'], 'name'=> 'User', 'children' => []],
                                      ['data'=>['method' => 'getInstituteManagement', 'id' => 'institute'], 'name'=> 'Institute', 'children' => []],
                                      ['data'=>['method' => 'getCourseManagement', 'id' => 'course'], 'name'=> 'Courses', 'children' => []]
                                    ]
                                  ];


                                  $data->map = ['type' => 'local'];


                                  break;

            case 'dean'       :   $data->sidebar = [
                                    'DASHBOARD'  => [
                                      ['data'=>['method' => 'getUserManagement','id' => 'user'], 'name'=> 'User', 'children' => []],
                                      ['data'=>['method' => 'getCurriculumManagement','id' => 'curriculum'], 'name'=> 'Curriculum', 'children' => []],
                                      ['data'=>['method' => 'getCourseManagement','id' => 'course'], 'name'=> 'Courses', 'children' => []],
                                      ['data'=>['method' => 'getQuizResponses','id' => 'responses'], 'name'=> 'Responses', 'children' => []]
                                    ]
                                  ];

                                  $data->map = ['type' => 'local'];

                                  break;

            case 'instructor' :  $data->sidebar = [
                                    'DASHBOARD'  => [
                                      ['data'=>['method' => 'getUserManagement','id' => 'user'], 'name'=> 'User', 'children' => []],
                                      ['data'=>['method' => 'getCurriculumManagement','id' => 'curriculum'], 'name'=> 'Curriculum', 'children' => []],
                                      ['data'=>['method' => 'getCourseManagement','id' => 'course'], 'name'=> 'Courses', 'children' => []],
                                      ['data'=>['method' => 'getQuizResponses','id' => 'responses'], 'name'=> 'Responses', 'children' => []]
                                    ]
                                  ];

                                  $data->map = ['type' => 'local'];

                                  break;


            case "student"    :   $curr = $this->getCurriculum();
                                  $data->sidebar = $curr['courseData'];
                                  $data->header = [];
                                  $data->main = [
                                    'learningHistory' => $curr['history']
                                  ];
                                  // $data->map = ['type' => 'foreign', 'route' => 'classroom'];
                                  $data->map = ['type' => 'alternate', 'params'=>['curr','id']];
                                  $data->additional = [];
                                  break;
        }

        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->data = $data;
        echo json_encode($GLOBALS["res"]);
    }

    public function addNewUser(){
      $role = $this->user->getRole();

      if($role != 'student'){
        if(isset($_POST['username'])){

          $user = $this->model('User');

          $user->username = $_POST['username'];
          $user->fullname = $_POST['fullname'];
          $user->password = $_POST['password'];
          $user->email = $_POST['email'];
          $user->role = $_POST['role'];
          isset($_POST['institute'])?$user->institute = $_POST['institute']: $user->institute = NULL;


          $this->user->addNewUser($user);

        }

      }

    }

    public function deleteUser($id){
      $this->user->deleteUser($id);
    }

    public function addNewInstitute(){
      $role = $this->user->getRole();

      if($role == 'admin' || $role == 'superadmin'){
        if(isset($_POST['name'])){
          $ins = new class{};

          $ins->name = $_POST['name'];
          $ins->code =  $_POST['code'];
          $ins->website = $_POST['website'];
          $ins->address = $_POST['address'];
          $ins->contactno = $_POST['contactno'];
          $ins->limit = $_POST['limit'];

          $institute = $this->model('Institute');
          $institute->addNewInstitute($ins);


        }
      }
    }

    public function deleteInstitute($id){
      $institute = $this->model('Institute');
      $institute->deleteInstitute($id, $this->user);
    }


    public function addNewDir(){

      if(isset($_POST['name'])){
        $role = $this->user->getRole();

        if($role != 'student'){
          $dir = new class{};
          $dir->name = $_POST['name'];
          $dir->parent =  $_POST['parent'];
          $dir->user = $this->user->getId();
          if($role == 'admin' || $role == 'superadmin' ){
            $dir->visibility = 'global';
          }
          else {
            $dir->visibility = 'local';
          }
          $course = $this->model('Course');
          $course->addNewDir($dir);
        }

      }
    }

    public function editDir(){
      if(isset($_POST['name'])){
        $role = $this->user->getRole();

        if($role != 'student'){
          $dir = new class{};
          $dir->name = $_POST['name'];
          $dir->id = $_POST['id'];
          $dir->user = $this->user->getId();

          $course = $this->model('Course');
          $course->editDir($dir);
        }

      }
    }

    // public function editDirContent(){
    //   if(isset($_POST['name'])){
    //     $role = $this->user->getRole();

    //     if($role != 'student'){
    //       $content = new class{};
    //       $content->name = $_POST['name'];
    //       $content->id = $_POST['id'];
    //       $content->user = $this->user->getId();

    //       $course = $this->model('Course');
    //       $course->editDirContent($content);
    //     }

    //   }
    // }

    public function deleteDir($dir = null){
      if(isset($dir) || isset($_POST['dir'])){
        if(isset($dir)){
          $dir = [$dir];
        }
        else{
          $dir = $_POST['dir'];
        }
        $course = $this->model('Course');
        $aws = $this->model('AwsSDK');
        $course->deleteDir($dir, $this->user, $aws);
      }
    }

    public function getDir($id){
      $role = $this->user->getRole();
      if($role != "student"){
          $course = $this->model('Course');
          $course->getDir($id,$this->user);
      }
    }

    public function addDirContent(){


      if (!empty($_FILES)) {

          $userRole = $this->user->getRole();
          $aws = $this->model('AwsSDK');
          $acceptedFiles = ['pdf', 'mp4', 'webm'];
          $tempFile = $_FILES['file']['tmp_name'];
          $filename = pathinfo($_FILES['file']['name'])['filename'];
          $extension = pathinfo($_FILES['file']['name'])['extension'];

          if(!in_array($extension, $acceptedFiles)){
            echo "Error!";
            return 0;
          }

          if(isset($_POST['parent']))
          {
            $targetPath = 's3://a2z-store-production/'. $this->user->username . '/' . $_POST['parent'];

            if(!file_exists($targetPath)){
              mkdir($targetPath,  0777, true);
            }
            $pathKey = $this->user->username. '/' . $_POST['parent'] . '/' . $filename . '.' . $extension;
            $aws->client->putObject(array(
                'Bucket'     => 'a2z-store-production',
                'Key'        => $pathKey,
                'SourceFile' => $tempFile
            ));

            $aws->client->waitUntil('ObjectExists', array(
                'Bucket' => 'a2z-store-production',
                'Key'    => $pathKey,
            ));



            $content = new class{};

            $content->parent = $_POST['parent'];
            $content->name = $filename;
            $content->type = $extension;
            $content->path = 's3://a2z-store-production/'.$pathKey;
            $content->user = $this->user->getId();
            if($userRole == 'superadmin' || $userRole == 'admin'){
              $content->visibility = 'global';
            }
            else {
              $content->visibility = 'local';
            }


            $course = $this->model('Course');
            $course->addDirContent($content);
          }

      }
    }

    public function deleteDirContent($content = null){
      if(isset($content) || isset($_POST['contents'])){
        if(isset($content)){
          $content = [$content];
        }
        else{
          $content = $_POST['contents'];
        }
        $course = $this->model('Course');
        $aws = $this->model('AwsSDK');
        $course->deleteDirContent($content, $this->user, $aws);
      }
    }

    public function addNewCurr(){
      $role = $this->user->getRole();

      if($role == 'dean' || $role == 'instructor'){
        if(isset($_POST['name'])){

          $curr = new class{};
          $curr->name = $_POST['name'];
          $curr->type = $_POST['type'];
          $curr->duration = $_POST['duration'];

          $course = $this->model('Course');
          $course->addNewCurr($curr, $this->user);

        }
      }
    }

    public function editCurr(){
      $role = $this->user->getRole();

      if($role == 'dean' || $role == 'instructor'){
        if(isset($_POST['name'])){

          $curr = new class{};
          $curr->name = $_POST['name'];
          $curr->type = $_POST['type'];
          $curr->duration = $_POST['duration'];
          $curr->id = $_POST['id'];
          $course = $this->model('Course');
          $course->editCurr($curr, $this->user);

        }
      }
    }

    public function deleteCurr($id){
      $course = $this->model('Course');
      $course->deleteCurr($id, $this->user);
    }

    public function addStudentsToCurr(){
      $role = $this->user->getRole();
      if($role == 'dean' || $role == 'instructor'){
        if(isset($_POST['users'])){
          $course = $this->model('Course');
          $course->addStudentToCurr($_POST['users'], $_POST['curr']);
        }
      }
    }

    public function addCourseToCurr(){
      $role = $this->user->getRole();

      if($role == 'dean' || $role == 'instructor'){
        if(isset($_POST['curr'])){
          $course = $this->model('Course');

          // $data = json_decode(str_replace('\\','',$_POST['data']));
          // var_dump($data);
          $dir = [];
          if(isset($_POST['dir']))
            $dir = $_POST['dir'];
          $course->addCourseToCurr($dir, $_POST['curr']);

        }
      }
    }

    public function extendStudCurrPeriod(){
      $role = $this->user->getRole();
      if($role == 'dean' || $role == 'instructor'){
        if(isset($_POST['student'])){
          $course = $this->model('Course');
          $data = new class{};
          $data->curr = $_POST['curr'];
          $data->student = $_POST['student'];
          $data->duration = $_POST['duration'];
          $course->extendStudCurrPeriod($data);
        }
      }
    }



    public function getCurrInfo($curr){
      $role = $this->user->getRole();
      if($role == 'dean' || $role == 'instructor'){
        $course = $this->model('Course');
        $course->getCurrInfo($curr, $this->user);
      }
    }

    public function getCurriculumStudents($curr){
      $role = $this->user->getRole();
      if($role == 'dean' || $role == 'instructor'){
        $course = $this->model('Course');
        $course->getCurriculumStudents($curr, $this->user);
      }
    }

    public function getCurriculumCourses($curr){
      $role = $this->user->getRole();
      if($role == 'dean' || $role == 'instructor'){
        $course = $this->model('Course');
        $course->getCurriculumCourses($curr, $this->user);
      }
    }

    function addNewQuiz(){
      $role = $this->user->getRole();
      if($role != 'student'){
        $course = $this->model('Course');
        $course->addNewQuiz($_POST, $this->user);
      }
    }

    function addNewSubtopic(){
      $role = $this->user->getRole();
      $aws = $this->model('AwsSDK');
      if($role != 'student'){
        $course = $this->model('Course');
        $course->addNewSubtopic($_POST, $_FILES, $this->user,$aws);
      }
    }

    function editSubtopic(){
      if(isset($_POST['name']) && isset($_POST['id'])){
        $role = $this->user->getRole();

        if($role != 'student'){
          $dir = new class{};
          $dir->name = $_POST['name'];
          $dir->id = $_POST['subtopicId'];
          $dir->user = $this->user->getId();

          $course = $this->model('Course');
          $r = $course->editDir($dir, false);

          
          if($r){
            $course->editQuiz($_POST, $this->user);
          }
          else{
            $GLOBALS["res"]->code = 0;
            $GLOBALS["res"]->message = "Failed! Please try again.";
            echo json_encode($GLOBALS["res"]);
          }
        }

      }

      
    }

    function getQuiz($quiz, $curr = null){
      $course = $this->model('Course');
      $course->getQuiz($quiz, $this->user,$curr);
    }

    // function editQuiz(){
    //   $role = $this->user->getRole();
    //   if($role != 'student'){
    //     $course = $this->model('Course');
    //     $course->editQuiz($_POST, $this->user);
    //   }
    // }

    function getStudentQuizResponses($student){
      $role = $this->user->getRole();
      if($role == 'instructor'|| $role == 'student'){
        $course = $this->model('Course');
        $course->getResponses($student, $this->user);

      }
    }

    function test(){
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = $_POST;
      echo json_encode($GLOBALS["res"]);
    }

    

    
}

 ?>
