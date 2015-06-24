<?php
class ArticulosTagsController extends Controller{
  protected $layout = 'html';
  
  public function __construct() {

    $this->ArticulosTags = new ArticulosTagsModel("mysql://root:@localhost/epc_db");
    $this->Articulos = new ArticulosModel("mysql://root:@localhost/epc_db");
    $this->Tags = new TagsModel("mysql://root:@localhost/epc_db");
    
  }
  public function add(){
    $this->view = 'articulos_tags-add';

    $this->articulos = $this->Articulos->asList();
    $this->tags = $this->Tags->asList();
    
}
  public function edit($id){
    $id = (int)$id;
    $this->view = 'articulos_tags-edit';

    $this->articulos = $this->Articulos->asList();
    $this->tags = $this->Tags->asList();
    

    $this->articulos_tags = $this->ArticulosTags->get($id);
    
  }
  public function delete($id){
    $this->view = 'articulos_tags-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'articulos_tags-index';

    $this->articulos = $this->Articulos->asList();
    $this->tags = $this->Tags->asList();
    
    
    $this->articulos_tags = $this->ArticulosTags->find();
    
  }
  public function view($id){
    $this->view = 'articulos_tags-index';

    $this->articulos = $this->Articulos->asList();
    $this->tags = $this->Tags->asList();
    

    $this->articulos_tags = $this->ArticulosTags->get($id);
    
  }
  public function do_add(){
    $could = $this->ArticulosTags->add(array(
      'articulos_id'=>$_POST['articulos_id'],
      'tags_id'=>$_POST['tags_id']
    ));
    if(!$could){
      $this->errors = $this->ArticulosTags->getErrors();
    }
    else{
      $this->forward('/articulos_tags/index');
    }
  }
  public function do_edit($id){
    $could = $this->ArticulosTags->update((int)$id,array(
      'articulos_id'=>$_POST['articulos_id'],
      'tags_id'=>$_POST['tags_id']
    ));
    if(!$could){
      $this->errors = $this->ArticulosTags->getErrors();
    }
    else{
      $this->forward('/articulos_tags/index');
    }
  }
  public function do_delete($id){
    $could = $this->ArticulosTags->delete((int)$id);
    if(!$could){
      $this->errors = $this->ArticulosTags->getErrors();
    }
    else{
      $this->forward('/articulos_tags/index');
    }    
  }
}

?>
