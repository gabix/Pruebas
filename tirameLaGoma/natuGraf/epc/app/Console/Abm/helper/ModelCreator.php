<?php

class ModelCreator {

  protected $table_name;
  protected $fields = array();
  protected $validations = array();

  public function __construct($table_name) {
    $this->table_name = $table_name;
  }

  public function addField(array $field) {
    if($field['name'] !== $this->table_name.'_id'){
      if ($field['mandatory']) {
        $this->addValidation($field['name'], 'mandatory');
      }
      if ($field['type'] == 'int') {
        $this->addValidation($field['name'], 'int');
      }
      if ($field['type'] == 'float') {
        $this->addValidation($field['name'], 'float');
      }
      if ($field['type'] == 'timestamp' OR strpos($field['type'], 'date') !== false) {
        $this->addValidation($field['name'], 'date');
      }
    }
    $this->fields[$field['name']] = $field;
  }

  public function addValidation($field, $type) {
    $this->validations[] = array('field' => $field, 'type' => $type);
  }

  public function compile() {
    $skeleton = file_get_contents(CONSOLEABMCONTROLLER_ROOT . '/helper/tpl/model.php');
    $skeleton = str_replace('TABLENAME', $this->table_name, $skeleton);
    $skeleton = str_replace('MDN', Inflector::capitalize($this->table_name), $skeleton);
    $buffer = array();
    foreach($this->validations as $validation){
      switch ($validation['type']){
        case 'int':
          $val_skeleton = file_get_contents(CONSOLEABMCONTROLLER_ROOT.'/helper/tpl/model-val-int.php');
          $validation = str_replace('FNAME', $validation['field'], $val_skeleton);
        break;
        case 'float':
          $val_skeleton= file_get_contents(CONSOLEABMCONTROLLER_ROOT.'/helper/tpl/model-val-float.php');
          $validation = str_replace('FNAME', $validation['field'], $val_skeleton);
        break;
        case 'date':
          $val_skeleton = file_get_contents(CONSOLEABMCONTROLLER_ROOT.'/helper/tpl/model-val-date.php');
          $validation = str_replace('FNAME', $validation['field'], $val_skeleton);
        break;
        case 'mandatory':
          $val_skeleton = file_get_contents(CONSOLEABMCONTROLLER_ROOT.'/helper/tpl/model-val-full.php');          
          $validation = str_replace('FNAME', $validation['field'], $val_skeleton);
        break;
      }
      $buffer []= $validation;
    }
    return str_replace('//FIELD_VALIDATIONS',
        implode("\n",
          $buffer
          ), 
      $skeleton
      );
  }
}
?>
