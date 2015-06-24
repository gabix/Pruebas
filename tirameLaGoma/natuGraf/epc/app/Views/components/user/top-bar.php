<?php
$user_box = 'components/users/info-box';
if (!isset($user)) {
  $user_box = 'components/users/login-stripe';
}
?>
<div id="top-container">
  <h1>ZCTNG</h1>
  <div id="forward-actions-container">
    <ul class="horz-nav">
      <li><a href="./users/search">Búsqueda</a>
      <li><a href="./users/messages/<?php echo $user->users_id?>">Mensajes</a>
    </ul>
  </div>
  <div id="core-actions-container">
    <ul class="horz-nav">
      <li><a href="./users/contacts">Contactos</a></li>
      <li><a href="./profiles/edit/<?php echo $user->users_id?>">Mi perfil</a></li>
      <li><a href="./lists/favorites/<?php echo $user->users_id?>">Preferidos</a></li>
      <li><a href="#rofl">Comunidad</a></li>
    </ul>
  </div>
  <div id="core-actions-auth-block">
    <?php echo self::compose('components/users/info-box',array('user'=>$user))?>
  </div>
</div>