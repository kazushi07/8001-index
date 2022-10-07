<?php

class InputChkFunction
{
  //社員番号の数値、桁数のチェックをしてreturnする
  public function num_check($employee_id)
  {
    if (preg_match("/^[0-9]{4}$/", $employee_id)) { //0-9 4文字 単語頭から単語末
      return true;
    } else {
      return false;
    };
  }
}
