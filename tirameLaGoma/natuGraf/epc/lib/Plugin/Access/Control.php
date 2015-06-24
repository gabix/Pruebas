<?php
  class PluginAccessControl extends Plugin{
    private $session;
    private $users;

    public function enforceLoggedIn(){
      if(!$this->isLoggedIn()){
        $this->session->val('protected-page','/'.$_SERVER["REQUEST_URI"]);
        $this->forward('/users/login');
      }
      else return true;
    }

    public function logout(){
      $this->session->wipe();
      $this->forward('/');
    }
    public function __construct(){
      $this->users = new UsersModel(Config::value('app.dsn'));
      $this->session = Session::instance();
    }
    public function isLoggedIn(){
      if($this->session->val('user') !== false){
        return true;
      }
      return false;
    }
    public function do_login(){
      $user = $this->users->find(array(
          'username'=>$_POST['username'],
          'password'=>$this->users->password($_POST['password']),
          )
      );
      if(is_array($user) AND count($user) > 0){
        $this->session->val('user',(array)$user[0]);
        $this->redirect($_POST['protected-resource']);
      }
      else{
        $this->forward('/users/login');
      }
    }
  }
?>
