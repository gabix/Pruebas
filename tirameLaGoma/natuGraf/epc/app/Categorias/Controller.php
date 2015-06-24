<?php
class CategoriasController extends Controller{
  protected $layout = 'html';

  public function __construct() {

    $this->Categorias = new CategoriasModel("mysql://root:@localhost/epc_db");

  }
  public function add(){
    $this->view = 'categorias-add';
    $this->categorias = $this->Categorias->asList();
    $this->preview = $this->Categorias->getFullTree();
  }
  public function edit($id){
    $id = (int)$id;
    $this->view = 'categorias-edit';
    $this->categorias = $this->Categorias->get($id);

  }
  public function delete($id){
    $this->view = 'categorias-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'categorias-index';
    $this->categorias = $this->Categorias->find();
    $this->preview = $this->Categorias->getFullTree();
  }
  public function view($id){
    $this->view = 'categorias-index';
    $this->categorias = $this->Categorias->get($id);
  }
  public function do_add(){
    if($_POST['parent_id'] != -1){
      $could = $this->Categorias->addNested(array(
        'parent'=>$_POST['parent_id'],
        'description'=>$_POST['description']
      ));
    }
    else{
      $could = $this->Categorias->add(array(
        'description'=>$_POST['description'],
        'parent'=>null,
        'lft'=>1,
        'rgt'=>2
      ));
    }
    if(!$could){
      $this->errors = $this->Categorias->getErrors();
    }
    else{
      $this->forward('/categorias/index');
    }
  }
  public function do_edit($id){
    $could = $this->Categorias->update((int)$id,array(
      'description'=>$_POST['description']
    ));
    if(!$could){
      $this->errors = $this->Categorias->getErrors();
    }
    else{
      $this->forward('/categorias/index');
    }
  }
  public function do_delete($id){
    $could = $this->Categorias->delete((int)$id);
    if(!$could){
      $this->errors = $this->Categorias->getErrors();
    }
    else{
      $this->forward('/categorias/index');
    }
  }
}

?>
