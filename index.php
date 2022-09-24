<?php
  //selectクラスを呼び出し
  require_once('Controller\Connect.php');
  $connect_controller = new ConnectController();

  //表示用変数初期化
  $employee_id = "";
  $name = "";
  $furigana = "";
  $birthday = "";
  $department_cd = "";
  $address = "";
  $phone_num = "";
  $mail_address = "";

  $warn_msg = "";

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
      <form action="index.php" method="POST">
        <div class="info-wrapper">
            <div class="info-contents">
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">社員番号</label>                  
                    <?php
                      //初回読み込み時のundefined error回避
                      if(isset($_POST['employee_id'])){
                        //エラーメッセージに表示するために社員番号を取得
                        $employee_id = $_POST["employee_id"];
                      }

                      //primary key　employee_id　で取得する
                      if(!empty($employee_id)){
                        //レコード存在チェック
                        try{$result = $connect_controller->recChk();                          
                          if($result > 0){
                            try{
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

                              } catch (PDOException $e){
                              $warn_msg = $e->getMessage();
                              echo($warn_msg);
                          }
                          }else{
                            $text = $employee_id . '<br> は存在しない社員番号です。<br> お手数ですがもう一度ご入力ください';
                            echo($text);
                          }
                        } catch (PDOException $e){
                          $warn_msg = $e->getMessage();
                          echo($warn_msg);
                        }
                      }
                    ?>
                  <input type="text" name = "employee_id" placeholder = "4桁の社員番号を入力" value = "<?php echo $employee_id;?>">
                  <input type="submit" value="表示">
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">氏名</label>
                  <input type="text" name = "name" value = "<?php echo $name;?>">
                  <label for="">フリガナ</label>
                  <input type="text" name = "furigana" value = "<?php echo $furigana;?>">
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">生年月日</label>
                  <input type="text" name = "birthday" value = <?php echo $birthday; ?>>
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">部署CD</label>
                  <input type="text" name = "department_cd" value = <?php echo $department_cd;?>>
                  
                  <!-- <label for="" id="lbl-busyo">部署名表示</label> -->
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">住 所</label>
                  <input type="text" name = "address" value = <?php echo $address;?>>
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">電話番号</label>
                  <input type="text" name = "phone_num" value = <?php echo $phone_num;?>>
              </div>
              <div class="info-content">
                  <label for="" class="lbl-memberInfo">メールアドレス</label>
                  <input type="text" name = "mail_address" value = <?php echo $mail_address;?>>
              </div>
              <div class="warn-cells"><label for="" id="lbl-warn"></label>
              </div>
            </div>
        </div>
        <div class="btn-wrapper">
            <div class="btn-contents">
              <button type="submit" name="insert">登録</button>
              <?php 
              //insert処理  
                if (isset($_POST['insert'])) {
                    try{
                      $connect_controller->insertEmployee();
                      $result = "登録しました";
                    } catch (PDOException $e){
                      $warn_msg = $e->getMessage();
                      echo("エラーが発生しました、クリアボタンを押してください");
                      echo($warn_msg);
                    }
                }
              ?>

              <button type="submit" name="update">更新</button>
              <?php
              //update処理
              if (isset($_POST['update'])) {
                  try{
                    $connect_controller->updateEmployee();
                    $result = "更新しました";
                  } catch (PDOException $e){
                    echo $e->getMessage();
                    echo("エラーが発生しました、クリアボタンを押してください");
                  }
                }
              ?>
              <button type="submit" name="delete">データ削除</button>
              <?php 
              //削除ボタン 
                if (isset($_POST['delete'])) {
                  if(!empty($_POST["employee_id"])){
                    try{
                      $connect_controller->deleteEmployee();
                      echo("データを削除しました、クリアボタンを押してください");
                    } catch (PDOException $e){
                      echo $e->getMessage();
                    }
                  }
                }                
              ?>
              <input type = submit name = "clear" class = "clear_button" value='クリア' onClick="jClear();">
                <?php 
                  //クリアボタン押下時にechoメッセージを消去
                  if (isset($_POST['clear'])) {
                        echo("");
                  }
                ?>      
              <script>
                //クリアして初期値に戻す
                function jClear() {
                  document.forms[0].employee_id.value = "";
                  document.forms[0].name.value = "";
                  document.forms[0].furigana.value = "";
                  document.forms[0].birthday.value = "";
                  document.forms[0].department_cd.value = "";
                  document.forms[0].address.value = "";
                  document.forms[0].phone_num.value = "";
                  document.forms[0].mail_address.value = "";
                }
               </script>
         </div>
        </div>
      </form>
    </div>
  </body>
</html>