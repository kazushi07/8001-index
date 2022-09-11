<?php
  require_once('config\config.php'); //設定ファイル読み込み

  //select時に使用する_PDOを使うためにConnectを継承する
  class SelectData extends Connect
  {
    //DBに接続してデータを取得する
    public function select($employee_id){
      $sql = 'SELECT employee_id,name,furigana,birthday,department_cd,address,phone_num,mail_address FROM m_employee WHERE employee_id =' . $employee_id;
      $items = $this->pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $items;
    }
  }
?>