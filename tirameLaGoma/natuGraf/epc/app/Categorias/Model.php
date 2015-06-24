<?php
class CategoriasModel extends Model {
  protected $table_name = 'categorias';
  public function __construct($dsn){
    $this->init($dsn);
  }
  public function addNested(array $fields){
    if(!$fields['parent'] OR $fields['parent'] == '-1'){
      $this->addError('parent_id','Parent category has to exist');
      return false;
    }
    if(!$fields['description']){
      $this->addError('description',"You really are inserting something, are you?");
      return false;
    }
    $parent_id = $fields['parent'];
    $desc = $this->db->prepareValue($fields['description']);
    return $this->query("
      START TRANSACTION;
      SELECT @myLeft := lft FROM categorias WHERE categorias_id = $parent_id;
      UPDATE categorias SET rgt = rgt + 2 WHERE rgt > @myLeft;
      UPDATE categorias SET lft = lft + 2 WHERE lft > @myLeft;
      INSERT INTO categorias(description, lft, rgt,parent) VALUES($desc, @myLeft + 1, @myLeft + 2, $parent_id);
      COMMIT;
    ");

  }
  public function add(array $fields){
    if(count($this->getErrors())==0)
    return $this->query(parent::add($fields));
  }
  public function update($id, array $fields){
    if(count($this->getErrors())==0)
    return $this->query(parent::update($id, $fields));
  }
  public function delete($id) {
    return $this->query("
      START TRANSACTION;
      SELECT
      @myLeft := lft,
      @myRight := rgt,
      @myWidth := rgt- lft + 1
      FROM categorias WHERE categorias_id=$id;
      DELETE FROM categorias WHERE lft BETWEEN @myLeft AND @myRight;
      UPDATE categorias SET rgt = rgt - @myWidth WHERE rgt > @myRight;
      UPDATE categorias SET lft = lft - @myWidth WHERE lft > @myRight;
      COMMIT;
    ");
  }

  public function find(array $criteria = array()) {
    return $this->query(parent::find($criteria));
  }
  public function getFullTree(){
    $first_nodes = $this->query("SELECT * FROM categorias WHERE parent IS NULL");
    $buf = array();
    foreach($first_nodes as $node){
      $buf[] = $this->getTree($node->categorias_id);
    }
    if(!isset($buf[1])){
      return array_pop($buf);
    }
    return $buf;
  }
  public function asList($desc_field = 'description', array $criteria = array()){
    return $this->query(parent::asList($desc_field, $criteria));
  }
  public function getTree($id){
    $root = array_shift($this->query("SELECT * FROM categorias WHERE categorias_id = $id"));
    $found = $this->query("SELECT * FROM categorias WHERE lft BETWEEN ".$root->lft." AND ".$root->rgt);
    return self::formatNested($found);
  }
  protected static function formatNested(array $tree){
    $menu = array(); $ref = array();
    foreach( $tree as $d ) {
      $d = object_to_array($d);
      $d['children'] = array();
      if( isset($ref[$d['parent']])) { // we have a reference on its parent
        $ref[$d['parent']]['children'][ $d['categorias_id']] = $d;
        $ref[$d['categorias_id']] =& $ref[ $d['parent']]['children'][$d['categorias_id']];
      }
      else { // we don't have a reference on its parent => put it a root level
        $menu[ $d['categorias_id']] = $d;
        $ref[ $d['categorias_id']] =& $menu[$d['categorias_id']];
      }
    }

    $menu = array_pop($menu);
    return $menu['children'];
  }
}

?>
