<?php
require_once('lib/Kihon/Core.php');
Config::instance()->load(ROOT_DIR.'/cfg/app.php');

$app = new ConsoleApplication(ROOT_DIR . '/cfg/app.php');

echo $app(
  $argv
);
?>
