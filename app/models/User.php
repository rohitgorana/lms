<?php
class User{
  var $username;
  var $fullname;

   function __construct($username = null) {
       $this->username = $username;
   }

   function getUserInfo(){
     $result = $GLOBALS["query"]->select(array('usr_i_full_name', 'usr_i_username', 'usr_i_emailid', 'usr_ro_name', 'usr_i_contactno'),
      'user_info',
      'usr_i_id',
      $this->getId(),
      "s"
      )->fetch_assoc();
      $info = [];
      $info['fullname'] = $result['usr_i_full_name'];
      $info['username'] = $result['usr_i_username'];
      $info['email'] = $result['usr_i_emailid'];
      $info['role'] = $result['usr_ro_name'];
      $info['contact'] = $result['usr_i_contactno'];

      return $info;
   }

   function getUsersToManage(){
    $result = null;
    $role = $this->getRole();

    if($role == 'dean' || $role == 'instructor'){

      $result = $GLOBALS["query"]->querySQL("SELECT user_info.usr_i_id, user_info.usr_i_full_name, user_info.usr_i_username, user_info.usr_i_emailid, user_info.usr_ro_name, user_info.usr_i_contactno FROM `user_info`
       Inner Join user_roles On user_info.usr_ro_name = user_roles.usr_ro_name
       inner join institute_user on user_info.usr_i_id = institute_user.usr_i_id
       WHERE user_roles.usr_ro_rank > (SELECT user_roles.usr_ro_rank from user_roles Inner Join user_info on user_info.usr_ro_name = user_roles.usr_ro_name where user_info.usr_i_username = '$this->username') and institute_user.ins_p_id =
       (select institute_user.ins_p_id from institute_user where institute_user.usr_i_id =
        (select user_info.usr_i_id from user_info where user_info.usr_i_username = '$this->username')) ORDER BY user_info.usr_i_full_name ;");
    }
    else
    {

     $result = $GLOBALS["query"]->querySQL("SELECT user_info.usr_i_id, user_info.usr_i_full_name, user_info.usr_i_username, user_info.usr_i_emailid, user_info.usr_ro_name, user_info.usr_i_contactno FROM `user_info`
       Inner Join user_roles On user_info.usr_ro_name = user_roles.usr_ro_name
       WHERE user_roles.usr_ro_rank > (SELECT user_roles.usr_ro_rank from user_roles Inner Join user_info on user_info.usr_ro_name = user_roles.usr_ro_name where user_info.usr_i_username = '$this->username') ORDER BY user_info.usr_i_full_name ;");
    }

     $users = [];
     if($result != NULL){
       while($row = $result->fetch_array(MYSQLI_ASSOC))
       {
          $users[] = $row;
       }
      }



     $result = $GLOBALS['query']->querySQL("SELECT usr_ro_name FROM user_roles
       WHERE usr_ro_rank > (SELECT user_roles.usr_ro_rank from user_roles
                                Inner Join user_info on user_info.usr_ro_name = user_roles.usr_ro_name
                                where user_info.usr_i_username = '$this->username')");


     $roles = [];
     if($result != NULL){
       while($row = $result->fetch_array(MYSQLI_ASSOC))
       {
          $roles[] = $row['usr_ro_name'];
       }
      }

     $data =  ["users"=>$users, "roles" => $roles, "stats"=>[]];
     foreach ($roles as $role) {
       $result = $GLOBALS['query']->querySQL("SELECT count(user_info.usr_i_id) As count from user_info where user_info.usr_ro_name = '$role'");
       $data['stats'][$role] = $result->fetch_assoc()['count'];
     }

     return $data;

   }

   function login(){
       $result = $GLOBALS["query"]->select("usr_i_password", "user_info", "usr_i_username", $_POST["username"],"s");
       if($result != NULL)
       {
            while($row = $result -> fetch_assoc())
			{
                if(password_verify($_POST["password"], $row["usr_i_password"]))
    			{

    				$session = md5(generateRandomString(10) . $_POST["username"]);
    				$_SESSION["username"] = $_POST["username"];
    				$_SESSION["value"] = $session;
    				$GLOBALS["query"]->update("user_info","usr_i_session",$session,"usr_i_username", $_POST['username'] ,  "ss");
    				$GLOBALS["res"]->code = -1;
    				$GLOBALS["res"]->message = "Login Success";
                    $GLOBALS["res"]->data = "dashboard";
    				echo json_encode($GLOBALS["res"]);
    			}
    			else
    			{
    				$GLOBALS["res"]->code = 0;
    				$GLOBALS["res"]->message = "Username or Password is incorrect";
    				echo json_encode($GLOBALS["res"]);
    			}
			}
        }
        else{
            $GLOBALS["res"]->code = 0;
            $GLOBALS["res"]->message = "Username is incorrect";
            echo json_encode($GLOBALS["res"]);
        }

   }

   function addNewUser($user){
     $insId = null;
     $insLimit = null;
     if($user->role == 'student'){
       $result = null;
       if(isset($user->institute)){
         $result = $GLOBALS['query']->select(array('ins_p_id', 'ins_p_stud_limit'), 'institute_profile', 'ins_p_name', $user->institute, "s")->fetch_assoc();
       }
       else{
         $result = $GLOBALS["query"]->querySQL("SELECT iu.ins_p_id, ip.ins_p_stud_limit from institute_user iu inner join institute_profile ip on ip.ins_p_id = iu.ins_p_id where usr_i_id =
               (select usr_i_id from user_info where usr_i_username = '$this->username')")->fetch_assoc();
       }
       $insId = $result['ins_p_id'];
       $insLimit = $result['ins_p_stud_limit'];

        $ns = $GLOBALS['query']->querySQL("SELECT COUNT(iu.usr_i_id) as count from institute_user iu inner join user_info ui on ui.usr_i_id = iu.usr_i_id where iu.ins_p_id = $insId")->fetch_assoc()['count'];
        if($ns >= $insLimit){
          $GLOBALS["res"]->code = 0;
          $GLOBALS["res"]->message = "Student Limit Reached. Contact Administrator for further details.";
          echo json_encode($GLOBALS["res"]);
          return 0;
        }

     }


       if(!$GLOBALS["query"]->find($user->username, 'usr_i_username', 'user_info', 'usr_i_username', $user->username, "s"))
       {

           $r = $GLOBALS["query"]->insert(array("usr_i_username", "usr_i_full_name", "usr_i_emailid", "usr_i_password", "usr_ro_name"),
									array($user->username, $user->fullname,$user->email, password_hash($user->password, PASSWORD_DEFAULT), $user->role),
									"user_info",
									"sssss"
                );
          $newUserId = $GLOBALS['query']->getInsertId();

          if($r && $user->role != 'admin'){

             $r = $GLOBALS["query"]->insert(array('usr_i_id', 'ins_p_id'),
                array($newUserId, $insId),
                'institute_user',
                'ss'
             );
          }


            if($r){
                  $GLOBALS["res"]->code = 1;
                  $GLOBALS["res"]->message = "Registration Success";
                  $GLOBALS["res"]->data = "dashboard";
                  echo json_encode($GLOBALS["res"]);

             }
             else {
                  $GLOBALS["res"]->code = 0;
                  $GLOBALS["res"]->message = "Registration Failed! Please try again.";
                  echo json_encode($GLOBALS["res"]);
              }
       }
       else {
           $GLOBALS["res"]->code = 0;
           $GLOBALS["res"]->message = "Username already exists.";
           echo json_encode($GLOBALS["res"]);
       }
   }

   function deleteUser($id){
     $role = $this->getRole();

     $rank = $GLOBALS["query"]->querySQL("SELECT usr_ro_rank FROM user_roles WHERE usr_ro_name = '$role'")->fetch_assoc()['usr_ro_rank'];
     $userRank = $GLOBALS["query"]->querySQL("SELECT usr_ro_rank FROM user_roles WHERE usr_ro_name = (SELECT usr_ro_name FROM user_info Where usr_i_id = $id)")->fetch_assoc()["usr_ro_rank"];
     if($rank < $userRank){
       if($GLOBALS["query"]->delete('user_info', 'usr_i_id', $id,'s'))
       {
         $GLOBALS["res"]->code = 1;
         $GLOBALS["res"]->message = "success";
         echo json_encode($GLOBALS["res"]);
       }
     }
     else {
       $GLOBALS["res"]->code = 0;
       $GLOBALS["res"]->message = "Unauthorised";
       echo json_encode($GLOBALS["res"]);
     }
   }

   function logout(){
       session_destroy();
       session_unset();
       $GLOBALS["res"]->code = -1;
       $GLOBALS["res"]->data = "login";
       echo json_encode($GLOBALS["res"]);
   }

   function isLoggedIn(){

     if(isset($_SESSION['value']) && isset($_SESSION['username'])){
        return $GLOBALS["query"]->find($_SESSION['value'], "usr_i_session", "user_info", "usr_i_username", $_SESSION['username'], "s");
    }
     else return false;

    }

   // function checkLogin(){
   //     if(isset($_SESSION["value"]) && isset($_SESSION["username"]))
   //     {
   //         if($GLOBALS["query"]->find($_SESSION['value'], "usr_i_session", "user_info", "usr_i_username", $_SESSION['username'], "s")){
   //             $GLOBALS["res"]->code = 1;
   //             $GLOBALS["res"]->data = $_SESSION["username"];
   //         }
   //         else {
   //             $GLOBALS["res"]->code = 0;
   //         }
   //     }
   //     else {
   //             $GLOBALS["res"]->code = 0;
   //     }
   //     echo json_encode($GLOBALS["res"]);
   // }

   function addPermission($permission){

   }

   function removePermission($permission){

   }

   function getPermissions(){
       $permissions = $GLOBALS["query"]->querySQL('SELECT user_info.usr_i_username, user_rules.lms_m_name
                        FROM user_info
                        INNER JOIN userrole_permissions ON user_info.usr_ro_name = userrole_permissions.usr_ro_name
                        INNER JOIN user_rules ON userrole_permissions.usr_ru_id = user_rules.usr_ru_id where user_info.usr_i_username = "'.$this->username.'"');

        return $permissions;
   }

   function getRole(){
       $result = $GLOBALS["query"]->select('usr_ro_name',
                'user_info',
                'usr_i_username', $this->username, 's');
        return $result -> fetch_assoc()['usr_ro_name'];
   }

   function editRole(){

   }

   function getRoles(){
     $result = $GLOBALS['query']->querySQL("SELECT usr_ro_name FROM user_roles
       WHERE usr_ro_rank > (SELECT user_roles.usr_ro_rank from user_roles
                                Inner Join user_info on user_info.usr_ro_name = user_roles.usr_ro_name
                                where user_info.usr_i_username = '$this->username')");
      $rows = [];
      while($row = $result->fetch_array(MYSQLI_ASSOC))
      {
        $rows[] = $row["usr_ro_name"];
      }

      return $rows;
   }

  function getLogs($type, $add){
    $data = [];
    switch ($type) {
      case 'watch_history'  : $id = $this->getId();
                              $result = $GLOBALS['query']->querySQL(" SELECT usr_l_data, usr_l_detail,  MAX(usr_l_timestamp) usr_l_timestamp FROM user_logs WHERE usr_i_id = $id AND usr_l_type = 'watch_history' GROUP BY usr_l_data ORDER BY  usr_l_timestamp DESC
 LIMIT 6");
                              if($result != NULL)
                              {
                                while($row = $result->fetch_assoc())
                                {
                                  $course = $add;
                                  $date = new DateTime($row["usr_l_timestamp"], new DateTimeZone('UTC'));
                                  $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
                                  $r = $GLOBALS['query']->select('drc_m_id', 'content_mgmt', 'cnt_m_id', $row["usr_l_data"],'s');
                                  if($r){
                                    $dirId= $r->fetch_assoc()['drc_m_id'];
                                    $name = $GLOBALS['query']->select('drc_m_directoryname', 'directory_mgmt', 'drc_m_id', $dirId,'s')->fetch_assoc()['drc_m_directoryname'];
                                    $log = ["id" => $dirId,"curriculum" => $row["usr_l_detail"], "name"=> $name, "time"=> $date->format('d-M-Y H:m')];

                                    if($row["usr_l_detail"] != NULL && $row["usr_l_detail"] != "NULL")
                                    {
                                      if($course->isStudentInCurriculum($this, $row["usr_l_detail"]))
                                      $log['status'] = 'active';
                                      else
                                      $log['status'] = 'expired';
                                    }
                                    else
                                    $log['status'] = 'expired';

                                    $data[] = $log;

                                  }
                                }
                              }
                              break;

    }

    return $data;
  }

  function log($type, $data){
    switch($type){
      case 'watch_history' :  date_default_timezone_set('UTC');
                              $result = $GLOBALS['query']->insert(array('usr_i_id','usr_l_type', 'usr_l_timestamp', 'usr_l_data', 'usr_l_detail'),
                                array($this->getId(), $type, date("Y-m-d H:i:s"), $data[0], $data[1]),
                                'user_logs',
                                'sssss'
                              );
                              break;
    }
  }

  function getId(){
    $stdId = $GLOBALS["query"]->select('usr_i_id', 'user_info', 'usr_i_username', $this->username, 's')->fetch_assoc()['usr_i_id'];
    return $stdId;
  }




   function removeRole($role){

   }

   function verifyUser($contact, $method){

   }

   function inviteUser(){

   }



   function updateProfile($info){
      $r = $GLOBALS['query']->update('user_info', array('usr_i_full_name', 'usr_i_username', 'usr_i_emailid', 'usr_i_contactno'),
        array($info['name'], $info['username'], $info['email'], $info['contact']),
        'usr_i_id',
        $this->getId(),
        'sssss'
      );
      if($r){
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

   public function updateProfilePicture($aws){


     if (!empty($_FILES)) {


         $acceptedFiles = ['jpg', 'png', 'jpeg'];
         $tempFile = $_FILES['picture']['tmp_name'];
         $filename = pathinfo($_FILES['picture']['name'])['filename'];
         $extension = pathinfo($_FILES['picture']['name'])['extension'];

         if(!in_array($extension, $acceptedFiles)){
           echo "Error!";
           return 0;
         }

           $targetPath = 's3://a2z-store-production/'. $this->username;

           if(!file_exists($targetPath)){
             mkdir($targetPath,  0777, true);
           }
           $pathKey = $this->username. '/profile.jpg';
           $aws->client->putObject(array(
               'Bucket'     => 'a2z-store-production',
               'Key'        => $pathKey,
               'SourceFile' => $tempFile
           ));

           $aws->client->waitUntil('ObjectExists', array(
               'Bucket' => 'a2z-store-production',
               'Key'    => $pathKey,
           ));


           header("HTTP/1.1 200 OK", true, 200);



     }
   }

   public function changePassword($old, $new){
     $result = $GLOBALS["query"]->select("usr_i_password", "user_info", "usr_i_username", $this->username,"s");
     if($result != NULL)
     {
          while($row = $result -> fetch_assoc()){
            if(password_verify($old, $row["usr_i_password"])){
              $r = $GLOBALS["query"]->update("user_info","usr_i_password", password_hash($new, PASSWORD_DEFAULT),"usr_i_username", $this->username ,  "ss");
              if($r){
                $this->logout();
              }
              else{
                $GLOBALS["res"]->code = 0;
                $GLOBALS["res"]->message = "Something went wrong. Please try again.";
                echo json_encode($GLOBALS["res"]);
              }
            }
            else{
              $GLOBALS["res"]->code = 0;
              $GLOBALS["res"]->message = "Old password does not match!";
              echo json_encode($GLOBALS["res"]);
            }

          }

     }
   }

   public function getUserIdFromPasswordResetToken($token){
    $result = $GLOBALS['query']->select('usr_i_id', 'password_reset_tokens', 'prt_token', $token, 's');
    if($result != NULL){
      return $result->fetch_assoc()['usr_i_id'];
    }
    else
      return null;
   }

   public function addPasswordResetToken($userId, $token){
    $tokenExists = $GLOBALS['query']->find( $userId, 'usr_i_id', 'password_reset_tokens', 'usr_i_id', $userId, 's');
    if($tokenExists){
      $result = $GLOBALS['query']->update('password_reset_tokens', 'prt_token', $token, 'usr_i_id', $userId, 'ss');
      return $result;
    }
    else{
      $result = $GLOBALS['query']->insert(array('usr_i_id', 'prt_token'), array($userId, $token), 'password_reset_tokens', 'ss');
      return $result;

    }
   }

   public function resetPassword($userId, $password){
    $r = $GLOBALS["query"]->update("user_info","usr_i_password", password_hash($password, PASSWORD_DEFAULT),"usr_i_username", $userId ,  "ss");
    return $result;
   }





}

?>
