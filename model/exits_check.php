<?php
  require_once('config\config.php'); //設定ファイル読み込み

  class RecChk extends Connect
  {
    //DBに接続してレコードの存在チェックを行う
    public function recChk($employee_id){
      $sql = "    
      SELECT EXISTS
      (SELECT name FROM m_employee WHERE employee_id = "
      . $employee_id
      . ")";

      //fetchColumnにより行数をint型で返却
      $items = $this->pdo()->query($sql)->fetchColumn();
      return $items;      
    }
  }

?>