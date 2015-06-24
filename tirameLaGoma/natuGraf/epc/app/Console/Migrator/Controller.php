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
class ConsoleMigratorController extends ConsoleController {
  protected static $db;

  public function migrate() {
    $dsn_old = 'mysql://root:@localhost/araoz390_epc';
    $dsn_new = 'mysql://root:@localhost/epc_db';
    $table_old = 'Articulos';
    $table_new = 'articulos';
    $sql_all_pics = "SELECT Nombre,Foto FROM Articulos";
    $sql_insert_pics = "INSERT INTO fotos(description,path) VALUES('%s','%s')";
    $db_old = DB::factory($dsn_old);
    $all_pics = $db_old->query($sql_all_pics);
    $db_new = DB::factory($dsn_new);
    foreach($all_pics as $pic){
      $db_new->query(sprintf($sql_insert_pics,$pic->Nombre,$pic->Foto));
      $this->say("Inserted picture with name ".$pic->Nombre);
    }
    return true;
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
