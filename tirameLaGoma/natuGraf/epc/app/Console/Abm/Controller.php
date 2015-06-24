<?php

require_once(CONSOLEABMCONTROLLER_ROOT . '/helper/ControllerCreator.php');
require_once(CONSOLEABMCONTROLLER_ROOT . '/helper/ModelCreator.php');
require_once(CONSOLEABMCONTROLLER_ROOT . '/helper/ViewsCreator.php');
class ConsoleAbmController extends ConsoleController {

  /**
   * Generates all files needed to create/update/delete/view records from a table
   */
  public function generate($table = false, $dsn = false) {
    if(!$dsn){
      $dsn = Config::value('app.dsn');
    }
    var_dump($dsn);
    try {
      $this->db = DB::instance($dsn);
    }
    catch (InvalidDSNException $e) {
      $this->say("Can't connect to the db specified in '$dsn'");
      die;
    }

    if(!$table){
      $table = $this->ask("Which table do you want me to create scaffolds for?");
    }

    $structure = $this->sniffTableStructure($table);
    $controller = $this->generateController($table, $structure);
    $model = $this->generateModel($table, $structure);
    $views = $this->generateViews($table, $structure);
    $this->generateDirectoryStructure($table);

    $table_dir = implode(DIRECTORY_SEPARATOR, Inflector::splitByCase(Inflector::capitalize($table)));
    $place = CONSOLEABMCONTROLLER_ROOT . '/generated';
    $business_place = $place . $table_dir;
    $views_place = $place . '/Views';

    file_put_contents($business_place . '/Controller.php', $controller);
    $this->say("Saved the controller in $place/Controller.php");

    file_put_contents($business_place . '/Model.php', $model);
    $this->say("Saved the model in $place/Model.php");

    foreach ($views as $name => $view_contents) {
      $view_place = $business_place . '/Views/' . $table . '-' . $name . '.php';
      file_put_contents($view_place, $view_contents);
      $this->say("Saved the view $name in $view_place");
    }
    foreach($structure['linked_tables'] as $name=>$linked){
      exec('php /var/www/epc/console.php Abm generate '.$name.' '.$dsn);
    }
    die;
  }

  public function generateViews($table, $structure) {
    $views = array();
    $helper = new ViewsCreator($table);
    $views['add'] = $helper->getAddPage($structure);
    $views['edit'] = $helper->getEditPage($structure);
    $views['delete'] = $helper->getDeletePage($structure);
    $views['index'] = $helper->getIndexPage($structure);
    return $views;
  }

  protected function generateModel($table, $table_structure) {
    $helper = new ModelCreator($table);
    foreach ($table_structure['fields'] as $field) {
      $helper->addField($field);
    }
    return $helper->compile();
  }

  /**
   * Generates a controller from a table and its structure
   * @param string $table
   * @param array $table_structure
   * @return string
   */
  protected function generateController($table, array $table_structure) {
    $helper = new ControllerCreator($table);
    $helper->addModel(Inflector::capitalize($table));
    foreach ($table_structure['linked_tables'] as $linked_table => $fields) {
      $helper->addModel(Inflector::capitalize($linked_table));
    }
    $helper->setTableFields($table_structure['fields']);
    return $helper->compile();
  }

  /**
   * Retrieves a useful summary of a table's data
   * @param string $table
   * @return array
   */
  protected function sniffTableStructure($table) {
    $structure = $this->db->query(
      'DESCRIBE ' . $table
    );
    $collected = array();
    foreach ($structure as $field_info) {
      $collected[$field_info->Field] = array(
        'name' => $field_info->Field,
        'type' => preg_replace('/[^a-zA-Z\s]/', '', $field_info->Type),
        'size' => preg_replace('/[^0-9\s]/', '', $field_info->Type),
        'mandatory' => $field_info->Null == 'No' ? true : false,
      );
    }
    $linked = array();
    foreach ($collected as $field => $data) {
      if (strpos($field, '_id') !== false OR strpos($field, 'id_') !== false) {
        $table_name = str_replace(array('_id', 'id_'), '', $field);
        if ($table_name != $table) {
          $linked[$table_name] = $this->sniffTableStructure($table_name);
        }
      }
    }
    return array(
      'fields' => $collected,
      'linked_tables' => $linked,
    );
  }

  /**
   * Tries to build the initial directory structure for the CRUD Module
   * @param string $table
   */
  protected function generateDirectoryStructure($table) {
    $place = CONSOLEABMCONTROLLER_ROOT . '/generated/';
    $table = Inflector::splitByCase(Inflector::capitalize($table));
    $table_path = implode(DIRECTORY_SEPARATOR, $table);
    exec('mkdir -p ' . $place . $table_path);
    exec('mkdir -p ' . $place . $table_path.'/Views');
  }
}
?>
