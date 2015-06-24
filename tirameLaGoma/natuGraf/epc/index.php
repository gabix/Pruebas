<?php
require_once('lib/Kihon/Core.php');
Config::instance()->load(ROOT_DIR.'/cfg/app.php');

$start_baking = microtime(true);
$app = new WebApplication(ROOT_DIR . '/cfg/app.php');
echo $app(
  array(
    'method'=>$_SERVER['REQUEST_METHOD'],
    'uri'=>$_SERVER['REQUEST_URI'],
  )
);
$end_baking = microtime(true);
echo '<!-- baked in: '.(($end_baking - $start_baking)).' seconds-->'
?>