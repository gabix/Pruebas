<?php

class ConsolePathLayerController extends Controller {

  public function craft() {
    var_dump(func_get_args(), __METHOD__);
    die;
  }

  public function TuVieja() {
    var_dump(func_get_args());
    die;
  }

  public function __call($k, $a) {
    var_dump(func_get_args(), __METHOD__);
    die;
  }

  public static function __callStatic($k, $a) {
    var_dump(func_get_args(), __METHOD__);
    die;
  }

}
?>
