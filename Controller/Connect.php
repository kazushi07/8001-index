<?php

require_once('model\employee_select.php');
require_once('model\employee_delete.php');
require_once('model\employee_insert.php');
require_once('model\employee_update.php');
require_once('model\exits_check.php');
require_once('model\employee_showdpt.php');

class ConnectController {

  public function selectEmployee(){
    $id = $_POST["employee_id"];
    $model = new SelectData;
    $items = $model->select($id);
    return $items;
  }

  public function deleteEmployee(){
    $id = $_POST["employee_id"];
    $model = new DeleteData;
    $items = $model->delete($id);
    return $items;
  }

  public function insertEmployee(){
    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $furigana = $_POST["furigana"];
    $birthday = $_POST["birthday"];
    $department_cd = $_POST["department_cd"];
    $address = $_POST["address"];
    $phone_num = $_POST["phone_num"];
    $mail_address = $_POST["mail_address"];
    $model = new InsertData;
    $items = $model->insert($employee_id,$name,$furigana,$birthday,$department_cd,$address,$phone_num,$mail_address);
    return $items;
  }

  public function updateEmployee(){
    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $furigana = $_POST["furigana"];
    $birthday = $_POST["birthday"];
    $department_cd = $_POST["department_cd"];
    $address = $_POST["address"];
    $phone_num = $_POST["phone_num"];
    $mail_address = $_POST["mail_address"];
    $model = new UpdateData;
    $items = $model->update($employee_id,$name,$furigana,$birthday,$department_cd,$address,$phone_num,$mail_address);
    return $items;
  }

  public function recChk(){
    $id = $_POST["employee_id"];
    $model = new RecChk;
    $items = $model->recChk($id);
    return $items;
  }

  public function showdpt(){
    $id = $_POST["department_cd"];
    $model = new ShowDptName;
    $items = $model->showdpt($id);
    return $items;
  }

}

?>