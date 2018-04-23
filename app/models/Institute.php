<?php

  class Institute{

    public function getAllInstitutes(){
      $data = [];
      $result = $GLOBALS['query']->select('*', 'institute_profile');

      if($result!=null){
        while($row = $result->fetch_assoc()){
          $data[] =[$row['ins_p_name'], $row['ins_p_code'], $row['ins_p_website'], $row['ins_p_address'], $row['ins_p_contactno'], $row['ins_p_id']];
        }
      }

      return $data;

    }

    public function addNewInstitute($ins){
      $r = $GLOBALS["query"]->insert(array("ins_p_name", "ins_p_code", "ins_p_website", "ins_p_address", "ins_p_contactno", "ins_p_stud_limit"),
             array($ins->name, $ins->code, $ins->website, $ins->address, $ins->contactno, $ins->limit),
             "institute_profile",
             "ssssss"
           );

      if($r){
        $GLOBALS["res"]->code = -1;
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

    public function deleteInstitute($id, $user){
      $role = $user->getRole();
      if($role == "admin" || $role == "superadmin")
      {

        if($GLOBALS["query"]->delete('institute_profile', 'ins_p_id', $id,'s')){
          $GLOBALS["res"]->code = 1;
          $GLOBALS["res"]->message = "success";
          echo json_encode($GLOBALS["res"]);
        }
      }
    }

  }

 ?>
