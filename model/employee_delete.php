<?php
  require_once('config\config.php'); //設定ファイル読み込み

  //select時に使用する_PDOを使うためにConnectを継承する
  class DeleteData extends Connect
  {  
    //DBに接続してデータを削除する
    public function delete($employee_id){        
      $sql = 'DELETE FROM m_employee WHERE employee_id = ' . $employee_id;
      $items = $this->pdo()->query($sql);      
      return $items;
    }
  }

?>