<?php
class FotosController extends Controller{
  protected $layout = 'html';
  
  public function __construct() {

    $this->Fotos = new FotosModel("mysql://root:@localhost/epc_db");
    
  }
  public function add(){
    $this->view = 'fotos-add';

    
}
  public function edit($id){
    $id = (int)$id;
    $this->view = 'fotos-edit';

    

    $this->fotos = $this->Fotos->get($id);
    
  }
  public function delete($id){
    $this->view = 'fotos-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'fotos-index';

    
    
    $this->fotos = $this->Fotos->find();
    
  }
  public function view($id){
    $this->view = 'fotos-index';

    

    $this->fotos = $this->Fotos->get($id);
    
  }
  public function do_add(){
    $could = $this->Fotos->add(array(
      'path'=>$_POST['path'],
      'description'=>$_POST['description']
    ));
    if(!$could){
      $this->errors = $this->Fotos->getErrors();
    }
    else{
      $this->forward('/fotos/index');
    }
  }
  public function do_edit($id){
    $could = $this->Fotos->update((int)$id,array(
      'path'=>$_POST['path'],
      'description'=>$_POST['description']
    ));
    if(!$could){
      $this->errors = $this->Fotos->getErrors();
    }
    else{
      $this->forward('/fotos/index');
    }
  }
  public function do_delete($id){
    $could = $this->Fotos->delete((int)$id);
    if(!$could){
      $this->errors = $this->Fotos->getErrors();
    }
    else{
      $this->forward('/fotos/index');
    }    
  }
}

?>
