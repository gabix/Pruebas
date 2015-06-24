<?php
class MDNModel extends Model {
  protected $table_name = 'TABLENAME';
  public function __construct($dsn){
    $this->init($dsn);
  }
  public function add(array $fields){
//FIELD_VALIDATIONS
    if(count($this->getErrors())==0)
    return $this->query(parent::add($fields));
  }
  public function update($id, array $fields){
//FIELD_VALIDATIONS
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
