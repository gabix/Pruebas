<ul>
<?php foreach($tags as $tag):?>
  <li>
    <a href="<?php echo '/articulos/por-categoria/'.Inflector::dehumanize($tag->description)?>"><?php echo $tag->description?></a>
  </li>
<?php endforeach?>
</ul>