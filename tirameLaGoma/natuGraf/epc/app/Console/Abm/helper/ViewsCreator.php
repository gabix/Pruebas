<?php

class ViewsCreator {

  protected $table;
  protected $tpl_root = CONSOLEABMCONTROLLER_ROOT;
  protected $structure = array();

  public function __construct($table_name) {
    $this->table = $table_name;
  }

  public function getAddPage(array $table_structure) {
    $tpl = file_get_contents($this->tpl_root . '/helper/tpl/views-add.php');
    $buf = array();
    foreach ($table_structure['fields'] as $field) {
      if ($field['name'] !== $this->table . '_id') {
        $buf[] = '<label for="' .
          $field['name'] .
          '">' .
          Inflector::humanize($field['name']) .
          '</label>' . self::getField($this->table, $field) . '<br/>';
      }
    }
    $tpl = str_replace('TABLE', $this->table, $tpl);
    return str_replace('FIELDS', implode("\n\t", $buf), $tpl);
  }

  public function getEditPage($table_structure) {
    $tpl = file_get_contents($this->tpl_root . '/helper/tpl/views-edit.php');
    $buf = array();
    foreach ($table_structure['fields'] as $field) {
      if ($field['name'] != $this->table . '_id') {
        $buf[] = '<label for="' .
          $field['name'] .
          '">' .
          Inflector::humanize($field['name']) .
          '</label>' .
          self::getField($this->table, $field, true) .
          '<br>';
      }
    }
    $tpl = str_replace('TABLE', $this->table, $tpl);
    $tpl = str_replace('FIELDS', implode("\n\t", $buf), $tpl);
    $tpl = str_replace('$_POST["' . $field['name'] . '"]', '<?php echo $' . $this->table . '[0]->' . $field['name'], $tpl);
    return $tpl;
  }

  public function getDeletePage($table_structure) {
    $tpl = file_get_contents($this->tpl_root . '/helper/tpl/views-delete.php');
    return str_replace('TABLE', $this->table, $tpl);
  }

  public function getIndexPage($table_structure) {
    $tpl = file_get_contents($this->tpl_root . '/helper/tpl/views-index.php');
    $row_tpl = file_get_contents($this->tpl_root . '/helper/tpl/views-index-action.php');
    $buf = array();
    foreach ($table_structure['fields'] as $field) {
      $theads[] = '<th>' . Inflector::humanize($field['name']) . '</th>';
      $rows[] = '<td><?php echo $' . $this->table . '[$i]->' . $field['name'] . '?></td>';
      $cols[] = '<col />';
    }
    $theads[] = '<th>actions</th>';
    $t = $this->table;
    $rows[] = str_replace('TABLE',$this->table,$row_tpl);
    $theads = implode("\n", $theads);
    $rows = implode("\n", $rows);
    $cols = implode("\n", $cols);
    $tpl = str_replace('TABLE', $this->table, $tpl);
    $tpl = str_replace('THEADS', $theads, $tpl);
    $tpl = str_replace('ROW', $rows, $tpl);
    $tpl = str_replace('COL', $cols, $tpl);
    return $tpl;
  }

  protected static function getField($table_name, array $field, $for_edit = false) {
    $orig_val_tpl = '$_POST["%s"]';
    if ($for_edit) {
      $orig_val_tpl = '$' . $table_name . '[0]->%s';
    }
    extract($field);
    $orig_val = sprintf($orig_val_tpl, $name);
    if (strpos($name, '_id') !== false OR strpos($name, 'id_') !== false) {
      $orig_val = sprintf($orig_val_tpl, $name);
      $linked_name = str_replace(array('_id', 'id_'), '', $name);
      return '<select name="' .
      $name .
      '" id="' .
      $name .
      '"><?php foreach($' .
      $linked_name .
      ' as $opt):?><option value="<?php echo $opt->id?>">' .
      '<?php echo $opt->description?></option><?php endforeach?></select><a href="./' . $linked_name . '/add">Nuevo</a>';
    }
    if (strpos($name, 'password') !== false) {
      return '<input type="password" name="' .
      $name .
      '" id="' .
      $name .
      '"/>';
    }
    if (strpos($type, 'longtext') !== false) {
      return '<textarea name="' .
      $field['name'] .
      '" id="' .
      $field['name'] .
      '"><?php echo ' .
      $orig_val .
      '?></textarea>';
    }
    if (strpos($type, 'char') !== false OR strpos($type, 'text') !== false) {
      return '<input type="text" name="' .
      $name .
      '" id="' .
      $name .
      '" value="<?php echo ' .
      $orig_val .
      '?>"/>';
    }
  }
}
?>
