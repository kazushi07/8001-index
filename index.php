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
//入力された社員番号の確保
if (isset($_POST['employee_id'])) {
  $employee_id = $_POST["employee_id"];
}

//表示ボタン押下＋社員番号のemptyチェック、数値チェック
if (isset($_POST['show']) && (!empty($employee_id)) && (is_numeric($employee_id))) {
  //レコード存在チェック
  try {
    $result = $connect_controller->recChk();
    if ($result > 0) {
      //データ取得
      $result = $connect_controller->selectEmployee();
      foreach ($result as $val) {
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
    } else {
      $text = '<br>' . $employee_id . 'は存在しない社員番号です。<br>お手数ですがもう一度4桁の半角数字でご入力ください';
    }
  } catch (PDOException $e) {
    $warn_msg = $e->getMessage();
    echo ($warn_msg);
  }
}

//updateとinsertで処理を分岐する
if (isset($_POST['register'])) {
  //先にレコードチェック
  $result = $connect_controller->recChk();
  if ($result > 0) {
    //update処理
    $connect_controller->updateEmployee();
    $result = $connect_controller->selectEmployee();
    $text = "更新しました";
    foreach ($result as $val) {
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
  } else {
    //insert処理
    try {
      $connect_controller->insertEmployee();
      $result = $connect_controller->selectEmployee();
      $text = "登録しました";
      foreach ($result as $val) {
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
    } catch (PDOException $e) {
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
    <form action="index.php" method="POST">
      <div class="info-wrapper">
        <div class="info-contents">
          <div class="info-content">
            <label for="" class="lbl-memberInfo">社員番号</label>
            <input type="text" id = "employee_id" name="employee_id" placeholder="4桁の社員番号を入力" value="<?php echo $employee_id; ?>">
            <input type="submit" id="btn_show" value="表示" name="show">
          </div>
          <div class="info-content">
            <label for="" class="lbl-memberInfo">氏名</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <label for="">フリガナ</label>
            <input type="text" name="furigana" value="<?php echo $furigana; ?>">
          </div>
          <div class="info-content">
            <label for="" class="lbl-memberInfo">生年月日</label>
            <input type="text" name="birthday" value=<?php echo $birthday; ?>>
          </div>
          <div class="info-content">
            <label for="" class="lbl-memberInfo">部署CD</label>
            <input type="text" name="department_cd" value=<?php echo $department_cd; ?>>
            <!-- <?php
                  //部署名取得
                  if (!empty($department_cd)) {
                    try {
                      $result = $connect_controller->showdpt();
                      foreach ($result as $val) {
                        $department_name = $val['department_name'];
                      }
                    } catch (PDOException $e) {
                      $warn_msg = $e->getMessage();
                      echo ($warn_msg);
                    }
                  }
                  ?> -->
            <label for="" id="lbl-busyo">部署:</label><?php echo $department_name; ?>
          </div>
          <div class="info-content">
            <label for="" class="lbl-memberInfo">住 所</label>
            <input type="text" name="address" value=<?php echo $address; ?>>
          </div>
          <div class="info-content">
            <label for="" class="lbl-memberInfo">電話番号</label>
            <input type="text" name="phone_num" value=<?php echo $phone_num; ?>>
          </div>
          <div class="info-content">
            <label for="" class="lbl-memberInfo">メールアドレス</label>
            <input type="text" name="mail_address" value=<?php echo $mail_address; ?>>
          </div>
        </div>
      </div>
      <div class="btn-wrapper">
        <div class="btn-contents">
          <button type="submit" name="register">登録</button>
          <a href="delete.php?employee_id=<?php echo $employee_id; ?>">削除</a>
          <input type=submit name="clear" class="clear_button" value='クリア' onClick="jClear();">
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
          <div class="msg-cells">
            <?php
            if (!empty($text)) {
              echo $text;
            }
            ?>
          </div>
          <div class="warn-cells">
            <?php
            if (!empty($warn_msg)) {
              echo ("<br>エラーが発生しました、クリアボタンを押してください<br>");
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