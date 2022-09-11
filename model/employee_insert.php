<?php
  require_once('config\config.php'); //設定ファイル読み込み

  class InsertData extends Connect
  {
    //DBに接続してデータを登録する
    public function insert($employee_id,$name,$furigana,$birthday,$department_cd,$address,$phone_num,$mail_address){
      $sql = "
      INSERT 
      INTO m_employee( 
          employee_id
          , name
          , furigana
          , birthday
          , department_cd
          , address
          , phone_num
          , mail_address
      ) 
      VALUES ("
          . $employee_id
          . ", ' "
          . $name
          . "' , ' "
          . $furigana          
          . "' , ' "
          . $birthday
          . "' , ' "
          . $department_cd          
          . "' , ' "
          . $address          
          . "' , ' "
          . $phone_num
          . "' , ' "
          . $mail_address
          .
          "  '
      )";

      $items = $this->pdo()->query($sql);
      return $items;
    }
  }
?>