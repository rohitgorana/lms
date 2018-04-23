<?php

class Course{


  public function getPath($id){
    $d = "";

    $result = $GLOBALS["query"]->select(array('drc_m_directoryname', 'drc_m_perentdirectoryid'), 'directory_mgmt', 'drc_m_id', $id, 's');


    if($result!=null){
      while($row = $result->fetch_assoc()){

        $d = '/'.$row["drc_m_directoryname"] . $d;
        if($row['drc_m_perentdirectoryid']!= "NULL" && $row['drc_m_perentdirectoryid']!= NULL)
          $d = $this->getPath($row['drc_m_perentdirectoryid']). $d;
      }
    }

    return $d;
  }


  function getDir($id, $user, $response = true){
    $userId = $user->getId();
    $data = ['topics' => [], 'content'=> [], 'quiz' => ['id'=>'', 'title'=> '', 'questions' => []]];

    $topics = $GLOBALS["query"]->querySQL("SELECT drc_m_id, drc_m_directoryname, usr_i_id FROM directory_mgmt WHERE drc_m_perentdirectoryid = $id AND (drc_m_visibility = 'global' OR usr_i_id = $userId)");
    if($topics != NULL){
      while($row = $topics->fetch_assoc()){
        $own = $row['usr_i_id'] == $userId?true:false;
        $data['topics'][] = ["id"=> $row['drc_m_id'],"name"=> $row['drc_m_directoryname'], "own" => $own];
      }
    }

    $content = $GLOBALS["query"]->querySQL("SELECT cnt_m_id, cnt_m_name, cnt_m_type, usr_i_id FROM content_mgmt WHERE drc_m_id = $id AND (cnt_m_visibility = 'global' OR usr_i_id = $userId)");
    if($content != NULL){
      while($row = $content->fetch_assoc()){
        if($row['cnt_m_type'] != 'quiz'){
          $own = $row['usr_i_id'] == $userId?true:false;
          $data['content'][] = ["id"=> $row['cnt_m_id'],"name"=> $row['cnt_m_name'], "type" => $row['cnt_m_type'], "own" => $own];
        }
        else
          $data['quiz'] = $this->getQuiz($row['cnt_m_id'], $user, null, false);
      }
    }



    if($response){
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->message = "Success";
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);
    }
    else {
      return $data;
    }
  }

  function addNewDir($dir){
    $dir->parent=="null"?$dir->parent = null: $dir->parent = $dir->parent;
    $r = $GLOBALS["query"]->insert(array("drc_m_directoryname", "drc_m_perentdirectoryid", "drc_m_visibility", "usr_i_id"),
           array($dir->name, $dir->parent, $dir->visibility, $dir->user),
           "directory_mgmt",
           "ssss"
         );
    if($r){
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->message = "Success";
      echo json_encode($GLOBALS["res"]);
    }
    else {
      $GLOBALS["res"]->code = 0;
      $GLOBALS["res"]->message = "Failed! Please try again.";
      echo json_encode($GLOBALS["res"]);
    }
  }

  function editDir($dir, $res = true){
    $r = $GLOBALS["query"]->select('usr_i_id', 'directory_mgmt', 'drc_m_id', $dir->id, 's');
    if($r!= null){
      $dirUser = $r->fetch_assoc()['usr_i_id'];
      if($dirUser == $dir->user){
        $r = $GLOBALS["query"]->update('directory_mgmt',
          'drc_m_directoryname',
          $dir->name,
          'drc_m_id',
          $dir->id,
          'ss'
        );
        if($res){
          if($r){
            $GLOBALS["res"]->code = 1;
            $GLOBALS["res"]->message = "Success";
            echo json_encode($GLOBALS["res"]);
          }
          else {
            $GLOBALS["res"]->code = 0;
            $GLOBALS["res"]->message = "Failed! Please try again.";
            echo json_encode($GLOBALS["res"]);
          }
        }
        else{
          return $r;
        }
      }
      else {
        if($res){
          $GLOBALS["res"]->code = 0;
          $GLOBALS["res"]->message = "Failed! Unauthorised.";
          echo json_encode($GLOBALS["res"]);
        }
        else{
          return false;
        }
      }
    }
    else{
      if($res){
        $GLOBALS["res"]->code = 0;
        $GLOBALS["res"]->message = "Failed! Topic does not exist";
        echo json_encode($GLOBALS["res"]);

      }
      else{
        return false;
      }
    }


  }



  function deleteDir($dirs, $user, $aws, $response = true){

    foreach ($dirs as $dir) {

      $dirItems = $this->getdir($dir, $user, false);
      foreach ($dirItems['topics'] as $topic) {
        $this->deleteDir([$topic['id']], $user, $aws, false);
      }
      foreach ($dirItems['content'] as $content) {
        $this->deleteDirContent([$content['id']], $user, $aws, false);
      }

      if($GLOBALS['query']->find($user->getId(), 'usr_i_id', 'directory_mgmt', 'drc_m_id', $dir, 's')){
        $dirHasSubdir = $GLOBALS['query']->find($dir, 'drc_m_perentdirectoryid', 'directory_mgmt', 'drc_m_perentdirectoryid', $dir, 's');
        $dirHasContent = $GLOBALS['query']->find($dir, 'drc_m_id', 'content_mgmt', 'drc_m_id', $dir, 's');
        if(!$dirHasContent && !$dirHasSubdir){
          $GLOBALS["query"]->delete('directory_mgmt', 'drc_m_id', $dir,"s");
          if($response){
            $GLOBALS["res"]->code = 1;
            $GLOBALS["res"]->data = ['success' => true];
            echo json_encode($GLOBALS["res"]);
          }
        }
      }
      else {

        if($response){
          $GLOBALS["res"]->code = 1;
          $GLOBALS["res"]->data = ['success' => false];
          echo json_encode($GLOBALS["res"]);
        }
      }
    }
  }


  function addDirContent($content){
    $r = $GLOBALS["query"]->insert(array("drc_m_id", "cnt_m_name", "cnt_m_type", "cnt_m_path", "cnt_m_visibility" , "usr_i_id"),
           array($content->parent, $content->name, $content->type, $content->path, $content->visibility, $content->user),
           "content_mgmt",
           "ssssss"
         );
    if($r){
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->message = "Success";
      echo json_encode($GLOBALS["res"]);
    }
    else {
      $GLOBALS["res"]->code = 0;
      $GLOBALS["res"]->message = "Failed! Please try again.";
      echo json_encode($GLOBALS["res"]);
    }
  }

  function editDirContent($content){
    $r = $GLOBALS["query"]->select('usr_i_id', 'content_mgmt', 'cnt_m_id', $content->id, 's');
    if($r!= null){
      $contentUser = $r->fetch_assoc()['usr_i_id'];
      if($contentUser == $content->user){
        $r = $GLOBALS["query"]->update('content_mgmt',
          'cnt_m_name',
          $content->name,
          'cnt_m_id',
          $content->id,
          'ss'
        );
        if($r){
          $GLOBALS["res"]->code = 1;
          $GLOBALS["res"]->message = "Success";
          echo json_encode($GLOBALS["res"]);
        }
        else {
          $GLOBALS["res"]->code = 0;
          $GLOBALS["res"]->message = "Failed! Please try again.";
          echo json_encode($GLOBALS["res"]);
        }
      }
      else {
        $GLOBALS["res"]->code = 0;
        $GLOBALS["res"]->message = "Failed! Unauthorised.";
        echo json_encode($GLOBALS["res"]);
      }
    }
    else{
      $GLOBALS["res"]->code = 0;
      $GLOBALS["res"]->message = "Failed! Topic does not exist";
      echo json_encode($GLOBALS["res"]);
    }


  }

  function deleteDirContent($contents, $user, $aws, $response = true){
    $auth = true;
    foreach ($contents as $content) {
      if(true){
        $contentInfo = $GLOBALS['query']->select(array('cnt_m_path','cnt_m_type', 'usr_i_id'), 'content_mgmt', 'cnt_m_id', $content, 's');
        if($contentInfo != null){
          $contentInfo = $contentInfo->fetch_assoc();
          if($contentInfo['usr_i_id'] == $user->getId()){
            if($contentInfo['cnt_m_type'] !='quiz'){
              $aws->client->deleteObject(array(
                  'Bucket'     => 'a2z-store-production',
                  'Key'        => str_replace('s3://a2z-store-production/', "", $contentInfo['cnt_m_path'])
              ));
            }
            $GLOBALS['query']->delete('content_mgmt', 'cnt_m_id', $content, 's');

          }
          else{
            $auth = false;
          }
        }
      }
    }

    if($response){
      if($auth){
        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->data = ['success' => true];
        echo json_encode($GLOBALS["res"]);
      }
      else{
        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->data = ['success' => false];
        echo json_encode($GLOBALS["res"]);
      }
    }
    else {
      return true;
    }
  }

  function getAllCourses($user){
    $userId = $user->getId();
    $modules = $GLOBALS["query"]->querySQL("SELECT drc_m_id, drc_m_directoryname FROM directory_mgmt WHERE drc_m_perentdirectoryid IS NULL AND (drc_m_visibility = 'global' OR usr_i_id = $userId)");

    $data = ['topics' => [], 'content' => []];
    if($modules != NULL){
      while($row = $modules->fetch_assoc()){
        $data['topics'][] = ["id"=> $row['drc_m_id'],"name"=> $row['drc_m_directoryname']];
      }
    }

    return $data;

}

function getStudentEnrolledCurriculums($student, $expired = false){
  $curriculums= [];
  $studId = $student->getId();
  $result = $GLOBALS["query"]->select(array('cc_id','sc_date_added','sc_extended_period'), 'student_curriculum', 'usr_i_id', $studId, 's');
  if($result != NULL){
    while($row = $result->fetch_assoc()){
      $curr = $GLOBALS["query"]->select(array('cc_access_type','cc_duration', 'usr_i_id'), 'course_curriculum', 'cc_id', $row['cc_id'], 's')->fetch_assoc();
      if($expired)
      {
        $curriculums[] = $row['cc_id'];
      }
      else
      {
        if($curr['cc_access_type'] == 'general'){
          $curriculums[] = ['id' => $row['cc_id'], 'user' => $curr['usr_i_id']];
        }
        else {
          $duration = $curr['cc_duration'] + $row['sc_extended_period'];
          $dateAdded = date_create($row['sc_date_added']);
          $now = date_create(gmdate("Y-m-d H:i:s"));
          $weeks = (int) $dateAdded->diff($now)->days/7;
          if($weeks < $duration)
          $curriculums[] = ['id' => $row['cc_id'], 'user' => $curr['usr_i_id']];
        }
      }
    }
  }

  return $curriculums;
}


function getCurriculumStudents($curr, $user){
  $data = [];
  $role = $user->getRole();
  if($role == 'instructor' || $role == 'dean'){

    if($GLOBALS['query']->find($user->getId(), 'usr_i_id', 'course_curriculum', 'cc_id', $curr, 's')){
      $result = $GLOBALS['query']->select(array('usr_i_id', 'sc_extended_period'), 'student_curriculum', 'cc_id', $curr, 'i');
      if($result != null){
        while($row = $result->fetch_assoc()){
          $data[] = $row['usr_i_id'];
        }
      }

      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->data = ['users' => $data];
      echo json_encode($GLOBALS["res"]);
    }
  }
}

function getCurriculumCourses($curr, $user){
  $data = [];


  if($GLOBALS['query']->find($user->getId(), 'usr_i_id', 'course_curriculum', 'cc_id', $curr, 's')){
    $result = $GLOBALS['query']->select('drc_m_id', 'course_curriculum_topics', 'cc_id', $curr, 'i');
    if($result != null){
      while($row = $result->fetch_assoc()){
        $data[] = $row['drc_m_id'];
      }
    }

    $GLOBALS["res"]->code = 1;
    $GLOBALS["res"]->data = ['dir' => $data];
    echo json_encode($GLOBALS["res"]);
  }

}

function isTopicOpen($topicId, $studentId){
  $subtopicsResult = $GLOBALS['query']->select(array('drc_m_id', 'drc_m_directoryname'), 'directory_mgmt', 'drc_m_perentdirectoryid',$topicId, 's');
  if($subtopicsResult != null){
    $previousSubtopicQuizId = null;
    while($subtopic = $subtopicsResult->fetch_assoc()){
      
      $subtopicId = $subtopic['drc_m_id'];
      if($previousSubtopicQuizId != null){
        
        $unattempted = $GLOBALS['query']->querySQL("SELECT COUNT(*) as N FROM quiz_question WHERE cnt_m_id = $subtopicId AND qq_id NOT IN (SELECT qq_id FROM quiz_question_responses WHERE usr_i_id = $studentId)")->fetch_assoc()['N'];
        if($unattempted != '0'){
          return false;
        }
      }

      $previousSubtopicQuizId = $subtopicId;
    }
  }
  else{
    return false;
  }

  return false;
}

function getCourseContent($currId,$courseId,$userId){
  $data =['name'=>'', 'id'=>$courseId, 'description'=> '', 'modules'=>[]];
  $data['name'] = $GLOBALS['query']->select('drc_m_directoryname', 'directory_mgmt', 'drc_m_id', $courseId, 's')->fetch_assoc()['drc_m_directoryname'];
  $modules = $GLOBALS['query']->select(array('drc_m_id', 'drc_m_directoryname'), 'directory_mgmt', 'drc_m_perentdirectoryid', $courseId, "s");
  if($modules != NULL){
    while($module = $modules->fetch_assoc()){
      $m = ['name'=> $module['drc_m_directoryname'], 'id'=>$module['drc_m_id'], 'topics' => []];
      $topics = $GLOBALS['query']->select(array('drc_m_id', 'drc_m_directoryname'), 'directory_mgmt', 'drc_m_perentdirectoryid', $module['drc_m_id'], "s");
      if($topics != NULL){
        $previousTopicId = null;
        while($topic = $topics->fetch_assoc()){
          $t = ['name'=> $topic['drc_m_directoryname'], 'id'=>$topic['drc_m_id'], 'curr' => $currId, 'access' =>'open'];
          if($previousTopicId != null){
            if($this->isTopicOpen($topic['drc_m_id'], $userId))
              $t['access'] = 'locked';
          }
          $m['topics'][] = $t;
        }
      }
      $data['modules'][] = $m;
    }
  }

  return $data;
}

function getCurriculum($user){
  $data = [];
  $role = $user->getRole();
  $curriculums = [];
  if($role == 'student')
  {
    $data = ['courseData' => [], 'history' => []];
    $stdId = $user->getId();

    $curriculums = $this->getStudentEnrolledCurriculums($user);
    // $users = [];
    $courses = [];
    foreach ($curriculums as $curriculum) {
      // $users[]= $curriculum['user'];
      $curriculumId = $curriculum['id'];
      $result = $GLOBALS["query"]->querySQL("SELECT dm.drc_m_directoryname AS name, cct.drc_m_id  AS id
      FROM course_curriculum_topics cct
      INNER JOIN directory_mgmt dm
      ON dm.drc_m_id = cct.drc_m_id
      WHERE cct.cc_id = $curriculumId");

      if($result != NULL){
        while($row = $result->fetch_assoc()){
          $courses[] = ['name' => $row['name'],'data'=>['curr' => $curriculum['id'], 'id' => $row['id'], 'method'=> 'getCourseContent'],'children' => []];
        }
      }
    }


    // function getTree($users,$curr,$pid, $id = NULL){
    //     $d = [];
    //     $result = NULL;
    //     if($pid == NULL){
    //       $result = $GLOBALS["query"]->select(array('drc_m_directoryname', 'drc_m_label', 'drc_m_id','drc_m_visibility', 'usr_i_id'), 'directory_mgmt', 'drc_m_id', $id, 's');
    //       if($result!=null){
    //         while($row = $result->fetch_assoc()){
    //           if(($row['drc_m_visibility']=='global' || in_array($row['usr_i_id'],$users)) && $row['drc_m_label'] != 'subtopic')
    //             $d = ['data'=>["id"=> $row['drc_m_id'],"curr" => $curr],"name"=> $row['drc_m_directoryname'], "children" => getTree($users,$curr,$row['drc_m_id'])];
    //         }
    //       }
    //       return $d;
    //     }
    //     else{
    //       $result = $GLOBALS["query"]->select(array('drc_m_directoryname', 'drc_m_label',  'drc_m_id','drc_m_visibility', 'usr_i_id'), 'directory_mgmt', 'drc_m_perentdirectoryid', $pid, 's');
    //       if($result!=null){
    //         while($row = $result->fetch_assoc()){
    //           if(($row['drc_m_visibility']=='global' || in_array($row['usr_i_id'],$users)) && $row['drc_m_label'] != 'subtopic')
    //               $d[] = ['data'=>["id"=> $row['drc_m_id'],"curr" => $curr],"name"=> $row['drc_m_directoryname'], "children" => getTree($users,$curr,$row['drc_m_id'])];
    //         }
    //       }
    //       return $d;
    //     }


    // }

    $data['courseData']['Courses'] = $courses;

    // foreach ($courses as $course) {
    //   $data['courseData']['Courses'][] = getTree($users,$course['curr'], NULL, $course['id']);
    // }

    $history = $user->getLogs('watch_history', $this);


    $data['history'] = $history;

  }
  else
  {

    $result = $GLOBALS["query"]->querySQL("SELECT cc_name, cc_id, cc_access_type, cc_duration FROM course_curriculum WHERE usr_i_id = (select usr_i_id from user_info where user_info.usr_i_username = '$user->username')");
    if($result != null){
      while($row = $result->fetch_assoc()){
        $data[] = ["name"=>$row['cc_name'], "id" => $row['cc_id'], 'type' => $row['cc_access_type'], 'duration' => $row['cc_duration']];
      }
    }



  }

  return $data;

}

function addNewCurr($curr, $user){

  $id = $user->getId();

  $result = $GLOBALS["query"]->insert(array('cc_name','cc_access_type','cc_duration', 'usr_i_id'),
      array($curr->name,$curr->type, $curr->duration, $id),
      'course_curriculum',
      'ssss'
    );



  if($result){
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->message = "Success";
      $GLOBALS["res"]->data = "dashboard";
      echo json_encode($GLOBALS["res"]);
    }
    else {
      $GLOBALS["res"]->code = 0;
      $GLOBALS["res"]->message = "Failed! Please try again.";
      echo json_encode($GLOBALS["res"]);
    }


}

function getCurrInfo($curr, $user){
  $data = [];
  $userId = $user->getId();
  $result = $GLOBALS["query"]->select(array('cc_name', 'cc_access_type', 'cc_duration'), 'course_curriculum', array('cc_id', 'usr_i_id'), array($curr, $userId), 'ss');
  if($result != null){
    while($row = $result->fetch_assoc()){
      $data = ["name"=>$row['cc_name'], 'type' => $row['cc_access_type'], 'duration' => $row['cc_duration']];

    }
  }

  $GLOBALS["res"]->code = 1;
  $GLOBALS["res"]->message = "Success";
  $GLOBALS["res"]->data = $data;
  echo json_encode($GLOBALS["res"]);
}

function editCurr($curr, $user)
{
    if($GLOBALS["query"]->find($curr->id, 'cc_id', 'course_curriculum', 'usr_i_id', $user->getId(),"s")){
      $result = $GLOBALS["query"]->update('course_curriculum',
        array('cc_name','cc_access_type','cc_duration'),
        array($curr->name, $curr->type, $curr->duration),
        'cc_id',
        $curr->id,
        'ssss'
      );

      if($result){
        $GLOBALS["res"]->code = 1;
        $GLOBALS["res"]->message = "Success";
        echo json_encode($GLOBALS["res"]);
      }
      else {
        $GLOBALS["res"]->code = 0;
        $GLOBALS["res"]->message = "Failed! Please try again.";
        echo json_encode($GLOBALS["res"]);
      }

    }
}

function deleteCurr($id, $user){
  if($GLOBALS["query"]->find($id, 'cc_id', 'course_curriculum', 'usr_i_id', $user->getId(),"s")){
    if($GLOBALS["query"]->delete('course_curriculum', 'cc_id', $id, 's'))
    {
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->message = "Success";
      echo json_encode($GLOBALS["res"]);
    }
  }
  else {
    $GLOBALS["res"]->code = 0;
    $GLOBALS["res"]->message = "Unauthorised";
    echo json_encode($GLOBALS["res"]);
  }
}

function isStudentInCurriculum($student, $curriculum, $expired = false){
  $curriculums = $this->getStudentEnrolledCurriculums($student, $expired);
  foreach ($curriculums as $curr) {
    if($curr['id'] == $curriculum)
      return true;
  }
  return false;
}


function getRootDir($dir){
  $parent = $GLOBALS["query"]->select('drc_m_perentdirectoryid', 'directory_mgmt', 'drc_m_id', $dir, 's')->fetch_assoc()['drc_m_perentdirectoryid'];

  if($parent!= "NULL" && $parent!= NULL)
    return $this->getRootDir($parent);
  else
    return $dir;
}

function isContentInCurriculum($content, $curriculum){

  $contentDir = $GLOBALS["query"]->select('drc_m_id', 'content_mgmt', 'cnt_m_id' , $content, "s")->fetch_assoc()['drc_m_id'];
  $module = $this->getRootDir($contentDir);
  return $GLOBALS["query"]->find($module, 'drc_m_id', 'course_curriculum_topics', 'cc_id', $curriculum, 's');
}

function isDirInCurriculum($dir, $curriculum){
  $module = $this->getRootDir($dir);
  return $GLOBALS["query"]->find($module, 'drc_m_id', 'course_curriculum_topics', 'cc_id', $curriculum, 's');
}

function isContentAuthorised($content, $user){
  $content = $GLOBALS["query"]->select(array('cnt_m_visibility', 'usr_i_id'), 'content_mgmt', 'cnt_m_id' , $content, "s");
  if($content != null){
    while($row = $content->fetch_assoc()){
      if($row['cnt_m_visibility'] == 'global' || $row['usr_i_id'] == $user)
        return true;
      else
        return false;
    }
  }
  else
    return false;
}

function isTopicAuthorised($topic, $user){
  $topic = $GLOBALS["query"]->select(array('cnt_m_visibility', 'usr_i_id'), 'content_mgmt', 'cnt_m_id' , $topic, "s");
  if($topic != null){
    while($row = $topic->fetch_assoc()){
      if($row['cnt_m_visibility'] == 'global' || $row['usr_i_id'] == $user)
        return true;
      else
        return false;
    }
  }
  else
    return false;
}



function getContentInfo($content){
  $result = $GLOBALS["query"]->select(array('cnt_m_path', 'cnt_m_type'), 'content_mgmt', 'cnt_m_id' , $content, "s")->fetch_assoc();
  $content = [];
  $content['type'] = $result['cnt_m_type'];
  $content['path'] = $result['cnt_m_path'];

  return $content;
}

function getClassroomContent($student,$currId, $topicId){
  $data = ['classroomData' => [], 'content' => []];
  $studentId = $student->getId();
  if($this->isStudentInCurriculum($student,$currId) && $this->isDirInCurriculum($topicId, $currId)){
    $currUsrId = $GLOBALS['query']->select('usr_i_id', 'course_curriculum', 'cc_id', $currId, 's')->fetch_assoc()['usr_i_id'];
    //Get subtopics
    $subtopicsResult = $GLOBALS['query']->select(array('drc_m_id', 'drc_m_directoryname'), 'directory_mgmt', 'drc_m_perentdirectoryid',$topicId, 's');
    if($subtopicsResult != null){
      $previousSubtopicQuizId = null;
      while($subtopic = $subtopicsResult->fetch_assoc()){
        $subtopicId = $subtopic['drc_m_id'];
        $subtopicName = $subtopic['drc_m_directoryname'];
        
        $subtopicContents = ['id' => $subtopicId, 'name' => $subtopicName, 'access'=> 'open' , 'content' => []];
        if($previousSubtopicQuizId != null){
          
          $unattempted = $GLOBALS['query']->querySQL("SELECT COUNT(*) as N FROM quiz_question WHERE cnt_m_id = $previousSubtopicQuizId AND qq_id NOT IN (SELECT qq_id FROM quiz_question_responses WHERE usr_i_id = $studentId)")->fetch_assoc()['N'];
          if($unattempted != '0'){
            $subtopicContents['access'] = 'locked';
          }
        }
        if($subtopicContents['access'] == 'open'){
          //Get Subtopic Content
          $contentResult = $GLOBALS['query']->select(array('cnt_m_id','cnt_m_name', 'cnt_m_type', 'usr_i_id', 'cnt_m_visibility'), 'content_mgmt', 'drc_m_id', $subtopicId, "s");
          if($contentResult != null){
            while($content = $contentResult->fetch_assoc())
            {
              if($content['cnt_m_type'] == 'quiz'){
                $previousSubtopicQuizId = $content['cnt_m_id'];
              }

              if($content['usr_i_id'] == $currUsrId || $content['cnt_m_visibility'] == 'global')
                $subtopicContents['content'][$content['cnt_m_type']][] = ['id' => $content['cnt_m_id'],'name' => $content['cnt_m_name']];
            }
          }
        }
        
        $data['content'][] = $subtopicContents;
      }
    }

    $curr = $this->getCurriculum($student);

    $data['classroomData'] = $curr['courseData'];


  }

  return $data;
}


public function getStudentCurriculum($user){
  $data = [];
  $result = $GLOBALS['query']->querySQL("SELECT m.drc_m_directoryname as Module, c.drc_m_directoryname as Concept, t.drc_m_directoryname as Topic, st.drc_m_directoryname as Subtopic, t.drc_m_id as TopicId from directory_mgmt m
                                          INNER join directory_mgmt c on c.drc_m_perentdirectoryid = m.drc_m_id
                                          INNER join directory_mgmt t on t.drc_m_perentdirectoryid = c.drc_m_id
                                          INNER join directory_mgmt st on st.drc_m_perentdirectoryid = t.drc_m_id
                                          INNER join course_curriculum_topics cct on cct.drc_m_id = st.drc_m_id
                                          WHERE cct.cc_id in (select course_curriculum.cc_id from course_curriculum inner join student_curriculum on student_curriculum.cc_id = course_curriculum.cc_id
                                          where student_curriculum.usr_i_id = (select usr_i_id from user_info where user_info.usr_i_username = '$user->username'));");

  if($result != null){
    while($row = $result->fetch_assoc()){
      $data[$row['Module']][$row['Concept']][$row['Topic']]['id'] = $row['TopicId'];
    }
  }

  return $data;

}


public function addStudentToCurr($students, $curr){
  date_default_timezone_set('UTC');
  foreach ($students as $student) {
    $stdId = $GLOBALS["query"]->select('usr_i_id', 'user_info', 'usr_i_id', $student, 's')->fetch_assoc()['usr_i_id'];
    $r = $GLOBALS['query']->find($stdId, 'usr_i_id', 'student_curriculum', 'cc_id', $curr, 's');
    if(!$r)
    {     $res = $GLOBALS['query']->insert(array('cc_id','sc_date_added', 'usr_i_id'), array($curr, date("Y-m-d H:i:s"), $stdId), 'student_curriculum', 'sss');

    }



  }


   $GLOBALS["res"]->code = 1;
   $GLOBALS["res"]->message = "Success";
   echo json_encode($GLOBALS["res"]);
}

public function addCourseToCurr($courses, $curr){

  $result = true;
   
  $courselistResult = $GLOBALS['query']->select('drc_m_id', 'course_curriculum_topics', 'cc_id', $curr, 's');
  $courselist = [];

  if($courselistResult != null){
    while($row = $courselistResult->fetch_assoc()){
      $courselist[] = $row['drc_m_id'];
    }
  }

  $unsetlist = implode(', ',array_diff($courselist,$courses));
  $GLOBALS['query']->querySQL("DELETE FROM course_curriculum_topics where cc_id = $curr AND drc_m_id IN ($unsetlist)");

  $setlist = array_diff($courses,$courselist);

   foreach ($courses as $course) {
    if($result){
      $result = $GLOBALS["query"]->insert(array('cc_id', 'drc_m_id'),
      array($curr, $course),
      'course_curriculum_topics',
      'ss'
     );
   }
 }

  if($result){
    $GLOBALS["res"]->code = 1;
    $GLOBALS["res"]->message = "Success";
    echo json_encode($GLOBALS["res"]);
  }
  else {
    $GLOBALS["res"]->code = 0;
    $GLOBALS["res"]->message = "Something went wrong. Try Again.";
    echo json_encode($GLOBALS["res"]);
  }
}

public function removeStudentFromCurr($student){

  if($GLOBALS["query"]->delete('student_curriculum', 'usr_i_id', $student->getId(), 's'))
  {
    $GLOBALS["res"]->code = 1;
    $GLOBALS["res"]->message = "Success";
    echo json_encode($GLOBALS["res"]);
  }


}

public function extendStudCurrPeriod($data){
  $res = $GLOBALS['query']->update('student_curriculum','sc_extended_period', $data->duration, array('cc_id', 'usr_i_id'), array($data->curr, $data->student), 'sss');
  if($res){
    $GLOBALS["res"]->code = 0;
    $GLOBALS["res"]->message = "Success";
    echo json_encode($GLOBALS["res"]);
  }
  else{
    $GLOBALS["res"]->code = 0;
    $GLOBALS["res"]->message = "Somthing went wrong";
    echo json_encode($GLOBALS["res"]);
  }
}

public function addNewQuiz($data,$files, $user,$aws){
  $acceptedFiles = ['png', 'jpeg', 'jpg'];
  $role = $user->getRole();
  $userId = $user->getId();
  $visibility = null;
  if($role =='admin' || $role == 'superadmin')
    $visibility = 'global';
  else
    $visibility = 'local';

  $r = $GLOBALS["query"]->insert(array("cnt_m_name", "cnt_m_type", "cnt_m_visibility", "usr_i_id", "drc_m_id"),
         array($data['name'], 'quiz', $visibility , $userId, $data['parent']),
         "content_mgmt",
         "sssss"
       );
  $quizId = $GLOBALS["query"]->getInsertId();

  for($i=0; $i< sizeof($data['question']); $i++){
    $answer = null;

    if($data['question'][$i]['type'] == 'SA'){
      $answer = $data['question'][$i]['answer'];
    }
    elseif ($data['question'][$i]['type'] == 'TF') {
      $answer = $data['question'][$i]['correct'];
    }
    elseif($data['question'][$i]['type'] == 'MUL'){
      $answer = $data['question'][$i]['options'][$data['question'][$i]['correct']];
    }

    if($r){
      $r = $GLOBALS["query"]->insert(array("cnt_m_id", "qq_type", "qq_text", 'qq_answer'),
      array($quizId, $data['question'][$i]['type'], $data['question'][$i]['text'], $answer),
      "quiz_question",
      "ssss"
      );
      $questionId = $GLOBALS['query']->getInsertId();
      //QUESTION DIAGRAM -----------------------------------------------------------
      if($files['question']['name'][$i]['diagram'] !="" && $r){
        
        $tempFile = $files['question']['tmp_name'][$i]['diagram'];
        $extension = pathinfo($files['question']['name'][$i]['diagram'])['extension'];

        if(!in_array($extension, $acceptedFiles)){
          echo "Error!";
          return 0;
        }

        $targetPath = 's3://a2z-store-production/'. $user->username . '/quiz-questions/' . $questionId;

        if(!file_exists($targetPath)){
          mkdir($targetPath,  0777, true);
        }
        $pathKey = $user->username. '/quiz-questions/' . $questionId . '/question.' . $extension;
        $aws->client->putObject(array(
            'Bucket'     => 'a2z-store-production',
            'Key'        => $pathKey,
            'SourceFile' => $tempFile
        ));

        $aws->client->waitUntil('ObjectExists', array(
            'Bucket' => 'a2z-store-production',
            'Key'    => $pathKey,
        ));

        $GLOBALS['query']->update('quiz_question', 'qq_diag', 's3://a2z-store-production/'.$pathKey, 'qq_id', $questionId, 'ss');

          
      }
      //END QUESTION DIAGRAM -------------------------------------
      
      //QUESTION OPTIONS
      if($data['question'][$i]['type'] == 'MUL'){
        for ($j=0; $j < sizeof($data['question'][$i]['options']); $j++) {
          $option = $data['question'][$i]['options'][$j];
          if($r){
            $r = $GLOBALS["query"]->insert(array("qq_id", "qqo_text"),
                   array($questionId, $option),
                   "quiz_question_option",
                   "ss"
                 );
            
            $optionId = $GLOBALS['query']->getInsertId();
            
            //OPTION DIAGRAM--------------------------------------
            if($files['question']['name'][$i]['options'][$j] !="" && $r){
              
              $tempFile = $files['question']['tmp_name'][$i]['options'][$j];
              $extension = pathinfo($files['question']['name'][$i]['options'][$j])['extension'];
      
              if(!in_array($extension, $acceptedFiles)){
                echo "Error!";
                return 0;
              }
      
              $targetPath = 's3://a2z-store-production/'. $user->username . '/quiz-questions/' . $questionId;
      
              if(!file_exists($targetPath)){
                mkdir($targetPath,  0777, true);
              }
              $pathKey = $user->username. '/quiz-questions/' . $questionId . '/option.'.$j+1 . $extension;
              $aws->client->putObject(array(
                  'Bucket'     => 'a2z-store-production',
                  'Key'        => $pathKey,
                  'SourceFile' => $tempFile
              ));
      
              $aws->client->waitUntil('ObjectExists', array(
                  'Bucket' => 'a2z-store-production',
                  'Key'    => $pathKey,
              ));
      
              $GLOBALS['query']->update('quiz_question_option', 'qqo_diag', 's3://a2z-store-production/'.$pathKey, 'qqo_id', $optionId, 'ss');
      
                
            }
            //END OPTION DIAGRAM-----------------------------------
          }
        }
      }
      elseif($data['question'][$i]['type'] == 'SEQ'){
        for ($j=0; $j < sizeof($data['question'][$i]['options']); $j++) {
          $option = $data['question'][$i]['options'][$j];
          if($r){
            $r = $GLOBALS["query"]->insert(array("qq_id", "qqo_text"),
                   array($questionId, $option),
                   "quiz_question_option",
                   "ss"
                 );
        
          }
        }
      }
      //END QUESTION OPTIONS------------------------------------
    }

  }

  if($r){
    $GLOBALS["res"]->code = 1;
    $GLOBALS["res"]->message = "Success";
    $GLOBALS['res']->data = $data['parent'];
    echo json_encode($GLOBALS["res"]);
  }
  else{
    $GLOBALS["res"]->code = 0;
    $GLOBALS["res"]->message = "Something went wrong. Try Again!";
    echo json_encode($GLOBALS["res"]);
  }
}

function addNewSubtopic($data, $files, $user, $aws){
  $userId = $user->getId();
  $userRole = $user->getRole();
  $dirVisibility = 'local';
  if($userRole == 'admin' || $userRole == 'superadmin' ){
    $dirVisibility = 'global';
  }

  $data['parent']=="null"?$data['parent'] = null: $data['parent'] = $data['parent'];
  $r = $GLOBALS["query"]->insert(array("drc_m_directoryname", "drc_m_perentdirectoryid", "drc_m_visibility", "usr_i_id"),
         array($data['name'], $data['parent'], $dirVisibility, $userId),
         "directory_mgmt",
         "ssss"
       );

  if($r){
    $data['parent'] = $GLOBALS['query']->getInsertId();
    $this->addNewQuiz($data, $files, $user, $aws);
  }
}

function getResponses($student, $user){
  $role = $user->getRole();
  $usrId = $user->getId();
  if($role == 'instructor' || $role == 'dean'){
    $studIns = $GLOBALS['query']->select('ins_p_id', 'institute_user', 'usr_i_id', $student, 's')->fetch_assoc()['ins_p_id'];
    if ($GLOBALS['query']->find($studIns, 'ins_p_id', 'institute_user', 'usr_i_id', $usrId, 's')) {
      $data = [];
      $responses = $GLOBALS['query']->querySQL("SELECT qr.qr_id, qr.qr_score, qr.qr_hit, qr.qr_miss, cm.cnt_m_name from quiz_response qr inner join course_curriculum cc on (cc.cc_id = qr.cc_id) Inner join content_mgmt cm on(cm.cnt_m_id = qr.cnt_m_id) where cc.usr_i_id = $usrId and qr.usr_i_id = $student");
      if($responses != null){
        while($response = $responses->fetch_assoc()){
          $temp = ['id'=>$response['qr_id'], 'score' => $response['qr_score'], 'hit'=> $response['qr_hit'], 'miss'=> $response['qr_miss'], 'name' => $response['cnt_m_name']];
        } $data[] = $temp;
      }
      $GLOBALS["res"]->code = 1;
      $GLOBALS["res"]->message = "Success";
      $GLOBALS["res"]->data = $data;
      echo json_encode($GLOBALS["res"]);
    }
    else{
      $GLOBALS["res"]->code = 0;
      $GLOBALS["res"]->message = "Unauthorised";
      echo json_encode($GLOBALS["res"]);
    }
  }
}


function getQuiz($id, $user, $curr, $res = true){
  $authorised = false;
  $role = $user->getRole();
  $usrId = $user->getId();
  if($role == 'student'){
    $authorised = $this->isStudentInCurriculum($user,$curr) && $this->isDirInCurriculum($id,$curr);
  }
  else {
    $authorised = $this->isTopicAuthorised($id, $usrId);
  }

  if($authorised){
    
        $quiz = ['id' => $id, 'title' => '', 'questions' => []];
        $quiz['title'] = $GLOBALS['query']->select('cnt_m_name', 'content_mgmt', 'cnt_m_id', $id, 's')->fetch_assoc()['cnt_m_name'];
    
        $questions = $GLOBALS['query']->select(array('qq_id', 'qq_type', 'qq_text', 'qq_answer'), 'quiz_question', 'cnt_m_id', $id, 's');
        if($questions != NULL){
          while($question = $questions->fetch_assoc()){
              $q = [];
              $q['id'] = $question['qq_id'];
              $q['text'] = $question['qq_text'];
              $q['type'] = $question['qq_type'];
              if($q['type'] == 'MUL' || $q['type'] == 'SEQ'){
                $q['options'] = [];
                $options = $GLOBALS['query']->select('qqo_text', 'quiz_question_option', 'qq_id', $question['qq_id'], 's');
                if($options != NULL){
                  while($option = $options->fetch_assoc()){
                    $q['options'][] = $option['qqo_text'];
                  }
                }
              }
              if($role != 'student'){
                $q['answer'] = $question['qq_answer'];
              }
              $quiz['questions'][] = $q;
    
    
          }
        }
        $data = $quiz;
        
    
    
        if($res){
          $GLOBALS["res"]->code = 1;
          $GLOBALS["res"]->message = "Success";
          $GLOBALS["res"]->data = $data;
      
          echo json_encode($GLOBALS["res"]);
        }
        else
          return $data;
    
      }
  else{
    if($res){
      $GLOBALS["res"]->code = 0;
      $GLOBALS["res"]->message = "Unauthorised";
  
      echo json_encode($GLOBALS["res"]);
    }
    else{
      return null;
    }
  }
}

public function editQuiz($data, $user){
  if ($GLOBALS['query']->find($user->getId(), 'usr_i_id', 'content_mgmt', 'cnt_m_id', $data['id'], 's')) {
    $questions = [];
    $result = $GLOBALS['query']->select('qq_id', 'quiz_question', 'cnt_m_id', $data['id'], 's');
    if($result != null){
      while($row = $result->fetch_assoc()){
        $questions[] = $row['qq_id'];
      }
    }

    $GLOBALS["query"]->update("content_mgmt", "cnt_m_name",
             $data['name'],
             'cnt_m_id',
             $data['id'],
             "ss"
    );
    $data['question'] = array_values($data['question']);

    foreach ($questions as $question) {
      $delete = true;
      if(isset($data['question'])){

        for($i=0; $i< sizeof($data['question']); $i++){

          if(isset($data['question'][$i])){

            if($question == $data['question'][$i]['id']){
              $delete = false;
              $answer = null;

              if($data['question'][$i]['type'] == 'SA'){
                $answer = $data['question'][$i]['answer'];
              }
              elseif ($data['question'][$i]['type'] == 'TF') {
                $answer = $data['question'][$i]['correct'];
              }
              else{
                $answer = $data['question'][$i]['options'][$data['question'][$i]['correct']];
              }

              $questionId = $data['question'][$i]['id'];
              $optionsResult = $GLOBALS['query']->select(array('qqo_id', 'qqo_type', 'qqo_diag'), 'quiz_question_option', 'qq_id', $questionId, 's');
              if($optionsResult != null){
                while($row = $optionsResult->fetch_assoc()){
                  if($row['qqo_type'] == 'DIAG'){
                    //TODO:delete diag from aws
                    $GLOBALS['query']->delete('quiz_question_option', 'qqo_id', $row['qqo_id'], 's');
                  }
                  else{
                    $GLOBALS['query']->delete('quiz_question_option', 'qqo_id', $row['qqo_id'], 's');
                  }
                }
              }




              $r = $GLOBALS["query"]->update("quiz_question", array("qq_type", "qq_text", 'qq_answer'),
                       array($data['question'][$i]['type'], $data['question'][$i]['text'], $answer),
                       'qq_id',
                       $questionId,
                       "ssss"
              );

              if($data['question'][$i]['type'] == 'MUL'){
                for ($j=0; $j < sizeof($data['question'][$i]['options']); $j++) {
                  $option = $data['question'][$i]['options'][$j];
                  if($r){
                    $r = $GLOBALS["query"]->insert(array("qq_id", "qqo_text"),
                            array($questionId, $option),
                            "quiz_question_option",
                            "ss"
                          );
                  }
                }
              }

            }
          }

        }
      }
      if($delete){
        $GLOBALS['query']->delete('quiz_question', 'qq_id', $question, 's');
      }

    }

    //insert newely added questions
    for($i=0; $i< sizeof($data['question']); $i++){
      if(isset($data['question'][$i])){
        if($data['question'][$i]['id'][0] == 'q'){
          $answer = null;

          if($data['question'][$i]['type'] == 'SA'){
            $answer = $data['question'][$i]['answer'];
          }
          elseif ($data['question'][$i]['type'] == 'TF') {
            $answer = $data['question'][$i]['correct'];
          }
          else{
            $answer = $data['question'][$i]['options'][$data['question'][$i]['correct']];
          }


          $r = $GLOBALS["query"]->insert(array("cnt_m_id", "qq_type", "qq_text", 'qq_answer'),
                 array($data['id'], $data['question'][$i]['type'], $data['question'][$i]['text'], $answer),
                 "quiz_question",
                 "ssss"
               );
          $questionId = $GLOBALS["query"]->getInsertId();
          if($data['question'][$i]['type'] == 'MUL'){
            for ($j=0; $j < sizeof($data['question'][$i]['options']); $j++) {
              $option = $data['question'][$i]['options'][$j];
              if($r){
                $r = $GLOBALS["query"]->insert(array("qq_id", "qqo_text"),
                       array($questionId, $option),
                       "quiz_question_option",
                       "ss"
                     );
              }
            }
          }

        }
      }
    }
    $GLOBALS["res"]->code = 1;
    $GLOBALS["res"]->message = "Success";
    echo json_encode($GLOBALS["res"]);
  }
  else{
    $GLOBALS["res"]->code = 0;
    $GLOBALS["res"]->message = "Unauthorised";
    echo json_encode($GLOBALS["res"]);
  }
}


  public function getTestQuestion($subtopicId, $aws, $practice = false ,$user=null){
    $userId = $user->getId();
    $quizResult = $GLOBALS['query']->select('cnt_m_id', 'content_mgmt', array('cnt_m_type', 'drc_m_id'), array('quiz', $subtopicId), 'ss');
    if($quizResult != null){
      $quizId = $quizResult->fetch_assoc()['cnt_m_id'];
      if($practice)
        $questionResult = $GLOBALS['query']->querySQL("SELECT * FROM quiz_question WHERE cnt_m_id = $quizId AND qq_id NOT IN (SELECT qq_id FROM quiz_question_responses WHERE usr_i_id = $userId) ORDER BY RAND() LIMIT 1");
      else
        $questionResult = $GLOBALS['query']->querySQL("SELECT * FROM quiz_question WHERE cnt_m_id = $quizId  ORDER BY RAND() LIMIT 1");

      if($questionResult != NULL){
        $question = $questionResult->fetch_assoc();
        $q = [];
        $q['id'] = $question['qq_id'];
        $q['text'] = $question['qq_text'];
        $q['type'] = $question['qq_type'];
        if($question['qq_diag'] != null){
          $q['diagram'] = $aws->getSignedUrl('a2z-store-production', str_replace('s3://a2z-store-production/','',$question['qq_diag']));
        }
        if($q['type'] == 'MUL' || $q['type'] == 'SEQ'){
          $q['options'] = [];
          $options = $GLOBALS['query']->select(array('qqo_id','qqo_text', 'qqo_diag'), 'quiz_question_option', 'qq_id', $question['qq_id'], 's');
          if($options != NULL){
            while($option = $options->fetch_assoc()){
              $o = ['text'=>$option['qqo_text'], 'id'=>md5($option['qqo_id'])];
              if($option['qqo_diag'] != null){
                $o['diagram'] = $aws->getSignedUrl('a2z-store-production', str_replace('s3://a2z-store-production/','',$option['qqo_diag']));
              }
              $q['options'][] = $o;
            }
          }
          shuffle($q['options']);
        }

        return $q;
      }
      else
        return null;
    }
    else
      return null;
  }

  public function checkPracticeQuestion($questionId, $answer, $user){
    $userId = $user->getId();
    $qResult = $GLOBALS['query']->select(array('qq_answer', 'qq_type'), 'quiz_question', 'qq_id', $questionId, 's');
    if($qResult != NULL){
      $q = $qResult->fetch_assoc();
      if($q['qq_type'] == 'SEQ'){
        $seqResult = $GLOBALS['query']->select('qqo_id', 'quiz_question_option', 'qq_id', $questionId, 's');
        $seq = [];
        while($item = $seqResult->fetch_assoc()){
          $seq[] = md5((string)$item['qqo_id']);
        }
        if($seq === $answer){
          if(!$GLOBALS['query']->find($questionId, 'qq_id', 'quiz_question_responses', 'usr_i_id', $userId, 's')){
            $result = $GLOBALS["query"]->insert(array('qq_id', 'usr_i_id'),
            array($questionId, $userId),
            'quiz_question_responses',
            'ss'
           );
          }
        }
        return $seq === $answer;
        
      }
      else{
        if(strtolower($q['qq_answer']) == strtolower($answer)){
          if(!$GLOBALS['query']->find($questionId, 'qq_id', 'quiz_question_responses', 'usr_i_id', $userId, 's')){
            $result = $GLOBALS["query"]->insert(array('qq_id', 'usr_i_id'),
            array($questionId, $userId),
            'quiz_question_responses',
            'ss'
           );
          }
    
          return true;
        }
        else
          return false;
      }
      
    }
    else
      return false;
  }

  public function getConceptTestQuestion($conceptId, $aws){
    $questions = [];
    $topicResult = $GLOBALS['query']->select('drc_m_id', 'directory_mgmt', 'drc_m_perentdirectoryid', $conceptId, 's');
    if ($topicResult!=NULL) {
      while($topic = fetch_assoc()['drc_m_id']){
        $subtopicResult = $GLOBALS['query']->select('drc_m_id', 'directory_mgmt', 'drc_m_perentdirectoryid', $topic, 's');
        if ($subtopicResult!=NULL) {
          while($subtopic = fetch_assoc()['drc_m_id']){
            $q = getTestQuestion($subtopic, $aws);
            if($q!=NULL){
              $questions[] = $q;
            }
          }
        }
      }
    }
    return $questions;
  }



}

?>
