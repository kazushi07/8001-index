<?php
  require_once('./Controller/Connect.php');
  
class CommonFunction
{ 
  public function display_reload(){
    $connect_controller = new ConnectController();
    //レコード存在チェック
    try{$result = $connect_controller->recChk();                          
      if($result > 0){
        //データ取得
        $result = $connect_controller->selectEmployee();
      
        foreach ($result as $val){
            $employee_id = $val['employee_id'];                  
            $name = $val['name'];
            $furigana = $val['furigana'];
            $birthday = str_replace('-', '/', $val['birthday']); //ハイフンをスラッシュに置き換え
            $department_cd = $val['department_cd'];
            $address = $val['address'];
            //電話番号を分割してハイフン挿入,ただしスマホのみ
            $phone_num_fwd = substr($val['phone_num'], 0, 3);
            $phone_num_middle = substr($val['phone_num'], 3, 4);
            $phone_num_last = substr($val['phone_num'], 7, 4);                                    
            $phone_num = $phone_num_fwd . "-" . $phone_num_middle . "-" . $phone_num_last;
            $mail_address = $val['mail_address'];
        }
      }
    } catch (PDOException $e){
      $warn_msg = $e->getMessage();
      echo($warn_msg);
    }
  }
}
?>