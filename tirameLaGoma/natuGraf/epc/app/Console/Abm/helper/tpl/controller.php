<?php
class MDNController extends Controller{
  protected $layout = 'html';
  
  public function __construct() {
MODEL_INITS
  }
  public function add(){
    $this->view = 'TABLE-add';
MODELPASSES_NO_SELF
}
  public function edit($id){
    $id = (int)$id;
    $this->view = 'TABLE-edit';
MODELPASSES_NO_SELF
MODEL_SINGLE_ELEMENT
  }
  public function delete($id){
    $this->view = 'TABLE-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'TABLE-index';
MODELPASSES_NO_SELF
    MODELGET_ALL
  }
  public function view($id){
    $this->view = 'TABLE-index';
MODELPASSES_NO_SELF
MODEL_SINGLE_ELEMENT
  }
  public function do_add(){
    $could = $this->MDN->add(array(
TBLFIELDS_NO_ID
    ));
    if(!$could){
      $this->errors = $this->MDN->getErrors();
    }
    else{
      $this->forward('/TABLE/index');
    }
  }
  public function do_edit($id){
    $could = $this->MDN->update((int)$id,array(
TBLFIELDS_NO_ID
    ));
    if(!$could){
      $this->errors = $this->MDN->getErrors();
    }
    else{
      $this->forward('/TABLE/index');
    }
  }
  public function do_delete($id){
    $could = $this->MDN->delete((int)$id);
    if(!$could){
      $this->errors = $this->MDN->getErrors();
    }
    else{
      $this->forward('/TABLE/index');
    }    
  }
}

?>
