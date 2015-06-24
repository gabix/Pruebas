<?php
class PagesController extends Controller {
  protected $layout = 'html';
  public function __construct(){
    $this->init();
    $this->Tags = new TagsModel(Config::value('app.dsn'));
  }
  public function index(){
    $this->tags = $this->Tags->find();
    return $this->show('index');
  }
  public function show($page) {
    $this->appendCommon();
    $this->view = $page;
  }

  protected static function loadStatic($page) {
    ob_start();
    if (is_readable(APP_DIR . "/static/$page.html")) {
      require APP_DIR . "/static/$page.html";
    }
    else {
      return false;
    }
    return ob_get_clean();
  }
  protected function appendCommon(){
    LayoutBus::addTitle("El Poeta Celoso");
    LayoutBus::addCSSBlock(file_get_contents(PAGESCONTROLLER_ROOT.'/styles/global.css'));
    LayoutBus::addJS('http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
  }
}
?>
