<?php
class Connect
{
  //DB接続情報　
  const DB_NAME ='company';
  const HOST    ='localhost';
  const UTF     ='utf8';
  const USER    ='root';
  const PASS    =''; //動作確認後、passを追加

  //DBに接続
  public function pdo(){
    $dsn  = "mysql:dbname=" .self::DB_NAME. "; host=" .self::HOST. "; charset=" .self::UTF;
    $user = self::USER;
    $pass = self::PASS;
    try{
      $pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF));
    }catch(Exception $e){
      echo 'エラーが発生しました '.$e->getMessage;
      die();
    }
    return $pdo;
  }
}

?>