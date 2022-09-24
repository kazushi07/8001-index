<?php
  require_once('config\config.php'); //設定ファイル読み込み

  class ShowDptName extends Connect
  {
    //DBに接続してデータを登録する
    public function showdpt($department_cd){    

      $sql = "SELECT department_name 
      FROM m_department 
      WHERE department_cd ='" 
      . $department_cd
      .
      "'";
      $items = $this->pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $items;
    }
  }

?>