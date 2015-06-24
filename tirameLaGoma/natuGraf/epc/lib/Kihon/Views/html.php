<!DOCTYPE html>
<html>
  <head>
    <title><?php echo LayoutBus::getTitle()?></title>
    <base href="<?php echo dirname(Config::value('app.mvc.front_controller'))?>/" target="_self"/>
<?php foreach(LayoutBus::getJS() as $js){?>
    <script type="text/javascript" src="<?php echo $js?>"></script>
<?php }?>
<?php foreach(LayoutBus::getCSS() as $style){?>
    <link rel="stylesheet" type="text/css" href="<?php echo $style?>"/>
<?php }?>
<?php foreach(LayoutBus::getCSSBlocks() as $block){?>
    <style>
<?php echo str_replace(array("\n","\r","\t",'  '),'',$block)?>
    </style>
<?php }?>
<?php foreach(LayoutBus::getJSBlocks() as $block){?>
    <script>
<?php echo str_replace(array("\n","\r","\t",'  '),'',$block)?>
    </script>
<?php }?>
  </head>
  <body>
  <?php echo $output?>
  </body>
</html>
