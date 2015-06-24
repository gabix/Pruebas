<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Controller
 *
 * @author root
 */
class ConsolePopulatorController extends ConsoleController {
  protected static $db;
  public function __construct() {
    self::$db = DB::instance(Config::value('app.dsn'));
  }

  public function populate($table = false) {
    if ( ! $table) {
      $table = $this->ask("What table should I populate?");
    }
    $structure = $this->sniffTableStructure($table);
    $model_class = Inflector::capitalize($table).'Model';
    $model = new $model_class(Config::value('app.dsn'));
    $inserted = array();
    for ($i = 0; $i < 1000; $i ++ ) {
      $row = array();
      foreach ($structure as $name => $field) {
        $value = self::getRandomOfType($field['type']);
        if(strpos($name,'email') !== false){
          $value = substr($value,0,30).'@hotmail.com';
        }
          $row[$name] = $value;
      }
      $this->say("INSERTING: ".var_export($row, true));
      $could = $model->add($row);
      if(!$could){
        $this->say("NO INSERTE ".var_export($row,true).' PORQUE '.var_export($model->getErrors(),true));
      }
    }
    $this->output = "Finished";
  }

  /**
   * Retrieves all the meaningful information it can from a database table
   * @param string $table_name 
   * @return array
   * @throws InvalidArgumentException
   */
  protected static function sniffTableStructure($table_name) {
    $table = self::$db->query("DESCRIBE $table_name");
    if ( ! $table) {
      throw new InvalidArgumentException("$table_name is not in database");
    }
    $fields = array();
    foreach ($table as $tuple) {
      if($tuple->Null !== 'YES' AND $tuple->Field !== $table_name.'_id'){
        $fields[$tuple->Field] = array(
          'name' => $tuple->Field,
          'type' => $tuple->Type,
        );
      }
    }
    return $fields;
  }

  public function getRandomOfType($type) {
    $raw_type = strtolower($type);
    $type = preg_replace ( '/[\)\(0-9]/' , '' , $raw_type);
    $strings = 'char varchar text longtext';
    $numbers = 'int float long';
    $dates = 'datetime date';
    $ids = '_id id_';
    $parts = explode('(', $raw_type);
    if(isset($parts[1]))
    $parts = array(
      'type'=>$parts[0],
      'length'=>trim($parts[1],') '),
    );
    else
      $parts = array(
        'type'=>$parts,
        'length'=>10
      );
    if (strpos($strings, $type) !== false) {
      return self::getRandomString('abcdefghijklmnopqrstuvwxyz0123456789',$parts['length']);
    }
    elseif (strpos($numbers, $type) !== false AND strpos($ids, $type) === false) {
      return self::getRandomNumber();      
    }
    elseif(strpos($dates, $type) !== false) {
      return self::getRandomDate();
    }
    return false;
  }
  protected static function getRandomString($dictionary, $length = 10){
    $length = (int)$length;
    $buf = '';
    mt_srand();
    for($i = 0; $i < $length;$i++){
      $buf .= substr($dictionary,mt_rand(0,$length-1),1);
    }
    return $buf;
  }
  protected static function getRandomNumber(){
    mt_srand();
    return mt_rand(1,1000);
  }
  protected static function getRandomDate(){
    mt_srand();
    $days = mt_rand(-1000,1000);
    if($days>0){
      $days = "+".abs($days);
    }
    else{
      $days = '-'.abs($days);
    }
    return date('Y-m-d h:i:s',strtotime("$days days"));
  }
}
?>
