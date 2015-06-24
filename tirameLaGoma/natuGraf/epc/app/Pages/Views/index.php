<?php
if(!isset($categorias))
    $categorias = array();
if(!isset($tags))
    $tags = array();
?>
<div id="page-wrap">
<div id="nav-wrap">
<?php echo View::compose('components/global/navigation')?>
</div>
<div id="content-wrap">
    <h1>El Poeta Celoso</h1>
    <h2>Bienvenidos!</h2>
    <hr>
    <?php echo View::compose('components/tag-cloud', array('tags'=>$tags))?>
</div>
</div>