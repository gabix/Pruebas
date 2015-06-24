<div id="user-info-box">
  <strong class="welcome">&iexcl;Hola <?php echo $user->nickname?>!</strong>
  <p>Tu suscripción caduca en <?php echo SubscriptionsModel::instance()->getTimeLeft($user->users_id)?></p>
  <a href="./subscriptions/add">&iexcl;Subscribite!</a>
  <a href="./users/logout">&iexcl;Subscribite!</a>
</div>