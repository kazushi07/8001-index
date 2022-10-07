<?php

require_once('function\input_check_function.php');

class FunctionController {

  public function inputCheck(){
    $id = $_POST["employee_id"];
    $function = new InputChkFunction;
    $items = $function->num_check($id);
    return $items;
  }

}

?>