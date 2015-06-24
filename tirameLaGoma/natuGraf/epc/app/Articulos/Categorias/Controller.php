<?php
class ArticulosCategoriasController extends Controller{
  protected $layout = 'html';
  
  public function __construct() {

    $this->ArticulosCategorias = new ArticulosCategoriasModel("mysql://root:@localhost/epc_db");
    $this->Articulos = new ArticulosModel("mysql://root:@localhost/epc_db");
    $this->Categorias = new CategoriasModel("mysql://root:@localhost/epc_db");
    
  }
  public function add(){
    $this->view = 'articulos_categorias-add';

    $this->articulos = $this->Articulos->asList();
    $this->categorias = $this->Categorias->asList();
    
}
  public function edit($id){
    $id = (int)$id;
    $this->view = 'articulos_categorias-edit';

    $this->articulos = $this->Articulos->asList();
    $this->categorias = $this->Categorias->asList();
    

    $this->articulos_categorias = $this->ArticulosCategorias->get($id);
    
  }
  public function delete($id){
    $this->view = 'articulos_categorias-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'articulos_categorias-index';

    $this->articulos = $this->Articulos->asList();
    $this->categorias = $this->Categorias->asList();
    
    
    $this->articulos_categorias = $this->ArticulosCategorias->find();
    
  }
  public function view($id){
    $this->view = 'articulos_categorias-index';

    $this->articulos = $this->Articulos->asList();
    $this->categorias = $this->Categorias->asList();
    

    $this->articulos_categorias = $this->ArticulosCategorias->get($id);
    
  }
  public function do_add(){
    $could = $this->ArticulosCategorias->add(array(
      'articulos_id'=>$_POST['articulos_id'],
      'categorias_id'=>$_POST['categorias_id']
    ));
    if(!$could){
      $this->errors = $this->ArticulosCategorias->getErrors();
    }
    else{
      $this->forward('/articulos_categorias/index');
    }
  }
  public function do_edit($id){
    $could = $this->ArticulosCategorias->update((int)$id,array(
      'articulos_id'=>$_POST['articulos_id'],
      'categorias_id'=>$_POST['categorias_id']
    ));
    if(!$could){
      $this->errors = $this->ArticulosCategorias->getErrors();
    }
    else{
      $this->forward('/articulos_categorias/index');
    }
  }
  public function do_delete($id){
    $could = $this->ArticulosCategorias->delete((int)$id);
    if(!$could){
      $this->errors = $this->ArticulosCategorias->getErrors();
    }
    else{
      $this->forward('/articulos_categorias/index');
    }    
  }
}

?>
