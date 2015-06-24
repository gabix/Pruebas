<?php
class ArticulosCategoriasModel extends Model {
  protected $table_name = 'articulos_categorias';
  public function __construct($dsn){
    $this->init($dsn);
  }
  public function add(array $fields){
    if(filter_var($fields['articulos_id'],FILTER_VALIDATE_INT) != $fields['articulos_id']){
      $this->addError('articulos_id',"articulos_id is not a number");
    }
    if(filter_var($fields['categorias_id'],FILTER_VALIDATE_INT) != $fields['categorias_id']){
      $this->addError('categorias_id',"categorias_id is not a number");
    }
    if(count($this->getErrors())==0)
    return $this->query(parent::add($fields));
  }
  public function update($id, array $fields){
    if(filter_var($fields['articulos_id'],FILTER_VALIDATE_INT) != $fields['articulos_id']){
      $this->addError('articulos_id',"articulos_id is not a number");
    }
    if(filter_var($fields['categorias_id'],FILTER_VALIDATE_INT) != $fields['categorias_id']){
      $this->addError('categorias_id',"categorias_id is not a number");
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
