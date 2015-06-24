<?php
class ArticulosModel extends Model {
  protected $table_name = 'articulos';
  public function __construct($dsn){
    $this->init($dsn);
  }
  public function add(array $fields){
    if(filter_var($fields['fotos_id'],FILTER_VALIDATE_INT) != $fields['fotos_id']){
      $this->addError('fotos_id',"fotos_id is not a number");
    }
    if(count($this->getErrors())==0)
    return $this->query(parent::add($fields));
  }
  public function update($id, array $fields){
    if(filter_var($fields['fotos_id'],FILTER_VALIDATE_INT) != $fields['fotos_id']){
      $this->addError('fotos_id',"fotos_id is not a number");
    }
    if(count($this->getErrors())==0)
    return $this->query(parent::update($id, $fields));
  }
  public function delete($id) {
    return $this->query(parent::delete($id));
  }
  public function find(array $criteria = array()) {
    return $this->query(parent::find($criteria));
  }
  public function asList($desc_field = 'description', array $criteria = array()){
    return $this->query(parent::asList($desc_field, $criteria));
  }
}
?>
