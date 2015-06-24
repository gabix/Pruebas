<?php

class ControllerCreator {

  protected $models = array();
  protected $fields = array();

  public function __construct($table_name) {
    $this->table_name = $table_name;
  }

  public function addModel($model_name) {
    $this->models[] = $model_name;
  }

  public function setTableFields($fields) {
    $this->fields = $fields;
  }

  public function compile() {
    $buf = '';
    $indenter = ";\n    ";
    $block_mark = substr($indenter, 1);
    $lexer = array(
      'MODEL_INIT' => '$this->%s = new %sModel("%s")',
      'MODEL_PASS' => '$this->%s = $this->%s->asList()',
      'MODEL_GET_ALL' => '$this->%s = $this->%s->find()',
      'MODEL_SINGLE_ELEMENT' => '$this->%s = $this->%s->get($id)',
      'TBLFIELD' => '\'%s\'=>$_POST[\'%s\']',
    );
    $skeleton = file_get_contents(CONSOLEABMCONTROLLER_ROOT . '/helper/tpl/controller.php');
    $skeleton = str_replace('TABLE', $this->table_name, $skeleton);
    $skeleton = str_replace('MDN', Inflector::capitalize($this->table_name), $skeleton);

    $this->models = array_filter($this->models);
    $skeleton = self::parseModelInit($this->models, $lexer, $skeleton, $block_mark, $indenter);
    $skeleton = self::parseModelPass($this->models, $lexer, $skeleton, $block_mark, $indenter);
    $skeleton = self::parseSingleElement($this->table_name, $lexer, $skeleton, $block_mark, $indenter);
    $skeleton = self::parseModelPassExcluding($this->models, $this->table_name, $lexer, $skeleton, $block_mark, $indenter);
    $skeleton = self::parseModelGetAll($this->models, $this->table_name, $lexer, $skeleton, $block_mark, $indenter);
    $skeleton = self::parseTableFields($this->table_name,$this->fields, $lexer, $skeleton, $block_mark, $indenter);
    return $skeleton;
  }

  protected static function parseModelGetAll($models, $table_name, $lexer, $skeleton, $block_mark, $indenter) {
    $buf = '';
      $buf .= sprintf($lexer['MODEL_GET_ALL'], Inflector::dehumanize($table_name), Inflector::capitalize($table_name)
        ) . $indenter;
    return str_replace('MODELGET_ALL', $block_mark . $buf, $skeleton);
  }

  protected static function parseModelPassExcluding($models, $table_name, $lexer, $skeleton, $block_mark, $indenter) {
    $buf = '';
    foreach ($models as $model) {
      if ($model !== Inflector::capitalize($table_name)) {
        $buf .= sprintf($lexer['MODEL_PASS'], Inflector::dehumanize($model), Inflector::capitalize($model)
          ) . $indenter;
      }
    }
    return str_replace('MODELPASSES_NO_SELF', $block_mark . $buf, $skeleton);
  }

  protected static function parseTableFields($table_name,$fields, $lexer, $skeleton, $block_mark, $indenter) {
    $buf = array();
    foreach ($fields as $field => $data) {
      if ($field != $table_name."_id" AND $field != "id_$table_name") {
        $buf [] = "      " . sprintf($lexer['TBLFIELD'], $field, $field);
      }
    }
    return str_replace('TBLFIELDS_NO_ID', implode(",\n", $buf), $skeleton);
  }

  protected static function parseSingleElement($table_name, $lexer, $skeleton, $block_mark, $indenter) {
    return str_replace('MODEL_SINGLE_ELEMENT', 
      $block_mark . sprintf($lexer['MODEL_SINGLE_ELEMENT'], 
        Inflector::dehumanize($table_name), 
        Inflector::capitalize($table_name)
      ) . $indenter, $skeleton
    );
  }

  protected static function parseModelPass($models, $lexer, $skeleton, $block_mark, $indenter) {
    $buf = '';
    foreach ($models as $model) {
      $buf .= sprintf($lexer['MODEL_PASS'], Inflector::dehumanize($model), Inflector::capitalize($model)
        ) . $indenter;
    }
    return str_replace('MODEL_PASSES', $block_mark . $buf, $skeleton);
  }

  protected static function parseModelInit($models, $lexer, $skeleton, $block_mark, $indenter) {
    $buf = '';
    foreach ($models as $model) {
      $buf .= sprintf($lexer['MODEL_INIT'], Inflector::capitalize($model), Inflector::capitalize($model), Config::value('app.dsn')
        ) . $indenter;
    }
    return str_replace('MODEL_INITS', $block_mark . $buf, $skeleton);
  }
}
?>
