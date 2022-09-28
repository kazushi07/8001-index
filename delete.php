<?php
  //selectクラスを呼び出し
  require_once('Controller\Connect.php');
  require_once('function\function.php');  
  $connect_controller = new ConnectController();
  $common_function = new CommonFunction();

  //表示用変数初期化
  $employee_id = "";
  $name = "";
  $furigana = "";
  $birthday = "";
  $department_cd = "";
  $address = "";
  $phone_num = "";
  $mail_address = "";
  $department_name = "";

  $warn_msg = "";
  
  //=====================================================
  //CRUD処理
  //=====================================================

  if(!empty($_GET['employee_id'])){
    $employee_id = $_GET["employee_id"];    
  }
  //GETしたデータをform上に表示する
  if(!empty($_GET['employee_id'])){
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
      }else{
        $text = '<br>' . $employee_id . 'は存在しない社員番号です。<br>お手数ですがもう一度ご入力ください';
      }
    } catch (PDOException $e){
      $warn_msg = $e->getMessage();
    }
  }

  //削除ボタン押下時
    if (isset($_POST['delete'])) {
      if(!empty($employee_id)){
        $_POST['employee_id'] = $employee_id;
        try{
          $connect_controller->deleteEmployee();
          $text = "データを削除しました。戻るボタンを押してください";          
        } catch (PDOException $e){
          $warn_msg = $e->getMessage();
        }
      }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\style.css">
        <title>社員マスタメンテナンス</title>
    </head>
<body>
  <div class="field_body">
    <h1 class="top_label">社員マスタメンテナンス</h1>
    <p class="text-confirm">以下の投稿を削除します。<br>よろしければ「データ削除」ボタンを押してください。</p>
      <form action="" method="POST">
        <div class="info-wrapper">
            <div class="info-contents">
              <div class="info-content">
                  <label for = "" class="lbl-memberInfo">社員番号</label>
                  <input type = "text" name = "employee_id" value = "<?php echo $employee_id;?>" disabled="disabled">
                  <input type = "submit" value = "表示" name = "show">
              </div>
              <div class="info-content">
                  <label for = "" class = "lbl-memberInfo">氏名</label>                  
                  <input type="text" name = "name" value = "<?php echo $name;?>" disabled="disabled">
                  <label for="">フリガナ</label>
                  <input type="text" name = "furigana" value = "<?php echo $furigana;?>" disabled="disabled">
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">生年月日</label>
                  <input type="text" name = "birthday" value = "<?php echo $birthday; ?>" disabled="disabled">
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">部署CD</label>
                  <input type="text" name = "department_cd" value = "<?php echo $department_cd;?>" disabled="disabled">
                  <!-- <?php
                  //部署名取得
                    if(!empty($department_cd)){
                      try{
                        $result = $connect_controller->showdpt();
                        foreach ($result as $val){
                          $department_name = $val['department_name'];
                        }
                      } catch (PDOException $e){
                      $warn_msg = $e->getMessage();
                      echo($warn_msg);
                      }
                    }
                  ?> -->
                  <label for="" id = "lbl-busyo">部署:</label><?php echo $department_name;?>
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">住 所</label>
                  <input type="text" name = "address" value = "<?php echo $address;?>" disabled="disabled">
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">電話番号</label>
                  <input type="text" name = "phone_num" value = "<?php echo $phone_num;?>" disabled="disabled">
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">メールアドレス</label>
                  <input type="text" name = "mail_address" value = "<?php echo $mail_address;?>" disabled="disabled">
              </div>
            </div>
        </div>
        <div class="btn-wrapper">
            <div class="btn-contents">
              <button type="submit" name="delete" >データ削除</button>
              <input type = "submit" name = "return" value='戻る'>
              <?php 
                if (isset($_POST['return'])) {
                  echo("return");
                  header("location: index.php");
                }                
              ?>
                <div class="msg-cells">
                  <?php 
                    if(!empty($text)){
                      echo $text;
                    }
                  ?>
                </div>
                <div class="warn-cells">
                  <?php                 
                    if(!empty($warn_msg)){
                      echo("<br>エラーが発生しました、クリアボタンを押してください<br>");
                      echo $warn_msg;
                    }
                  ?>
                </div>
         </div>
        </div>
      </form>
    </div>
  </body>
</html>