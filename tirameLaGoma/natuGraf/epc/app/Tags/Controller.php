<?php
class TagsController extends Controller{
  protected $layout = 'html';
  
  public function __construct() {

    $this->Tags = new TagsModel("mysql://root:@localhost/epc_db");
    
  }
  public function add(){
    $this->view = 'tags-add';

    
}
  public function edit($id){
    $id = (int)$id;
    $this->view = 'tags-edit';

    

    $this->tags = $this->Tags->get($id);
    
  }
  public function delete($id){
    $this->view = 'tags-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'tags-index';

    
    
    $this->tags = $this->Tags->find();
    
  }
  public function view($id){
    $this->view = 'tags-index';

    

    $this->tags = $this->Tags->get($id);
    
  }
  public function do_add(){
    $could = $this->Tags->add(array(
      'description'=>$_POST['description']
    ));
    if(!$could){
      $this->errors = $this->Tags->getErrors();
    }
    else{
      $this->forward('/tags/index');
    }
  }
  public function do_edit($id){
    $could = $this->Tags->update((int)$id,array(
      'description'=>$_POST['description']
    ));
    if(!$could){
      $this->errors = $this->Tags->getErrors();
    }
    else{
      $this->forward('/tags/index');
    }
  }
  public function do_delete($id){
    $could = $this->Tags->delete((int)$id);
    if(!$could){
      $this->errors = $this->Tags->getErrors();
    }
    else{
      $this->forward('/tags/index');
    }    
  }
}

?>
