<?php
  require_once('config\config.php'); //設定ファイル読み込み

  class UpdateData extends Connect
  {
    //DBに接続してデータを登録する
    public function update($employee_id,$name,$furigana,$birthday,$department_cd,$address,$phone_num,$mail_address){
      
      //DB登録前に電話番号のハイフンを削除する
      $phone_num = str_replace('-', '', $phone_num);
      
      $sql = "
      UPDATE m_employee
      SET   name = '" . $name . "' 
          , furigana = '" . $furigana . "' 
          , birthday = '" . $birthday. "'
          , department_cd =  '" . $department_cd . "' 
          , address = '" . $address . "'
          , phone_num = '" . $phone_num . "'
          , mail_address = '" . $mail_address . "'
          WHERE employee_id = " . $employee_id . "
      ";
      // echo($sql);
      $items = $this->pdo()->query($sql);
      return $items;      
    }
  }

?>