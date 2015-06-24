<?php
class ArticulosController extends Controller{
  protected $layout = 'html';

  public function __construct() {
    $this->Articulos = new ArticulosModel("mysql://root:@localhost/epc_db");
    $this->Fotos = new FotosModel("mysql://root:@localhost/epc_db");
  }
  public function por_categoria($category_id=-1){
    var_dump($category_id);die;
  }
  public function add(){
    $this->view = 'articulos-add';

    $this->fotos = $this->Fotos->asList();
  }
  public function edit($id){
    $id = (int)$id;
    $this->view = 'articulos-edit';

    $this->fotos = $this->Fotos->asList();


    $this->articulos = $this->Articulos->get($id);

  }
  public function delete($id){
    $this->view = 'articulos-delete';
    $this->id = (int)$id;
  }
  public function index(){
    $this->view = 'articulos-index';

    $this->fotos = $this->Fotos->asList();


    $this->articulos = $this->Articulos->find();

  }
  public function view($id){
    $this->view = 'articulos-index';

    $this->fotos = $this->Fotos->asList();


    $this->articulos = $this->Articulos->get($id);

  }
  public function do_add(){
    $could = $this->Articulos->add(array(
      'description'=>$_POST['description'],
      'fotos_id'=>$_POST['fotos_id'],
      'code'=>$_POST['code']
    ));
    if(!$could){
      $this->errors = $this->Articulos->getErrors();
    }
    else{
      $this->forward('/articulos/index');
    }
  }
  public function do_edit($id){
    $could = $this->Articulos->update((int)$id,array(
      'description'=>$_POST['description'],
      'fotos_id'=>$_POST['fotos_id'],
      'code'=>$_POST['code']
    ));
    if(!$could){
      $this->errors = $this->Articulos->getErrors();
    }
    else{
      $this->forward('/articulos/index');
    }
  }
  public function do_delete($id){
    $could = $this->Articulos->delete((int)$id);
    if(!$could){
      $this->errors = $this->Articulos->getErrors();
    }
    else{
      $this->forward('/articulos/index');
    }
  }
}

?>
