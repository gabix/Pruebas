<h2><a href="./">Index</a></h2>
<form action="./articulos_categorias/do_edit/<?php echo $articulos_categorias[0]->articulos_categorias_id?>" method="post">
  <input type="hidden" name="articulos_categorias_id" id="articulos_categorias_id" value="<?php echo $articulos_categorias[0]->articulos_categorias_id?>"/>
  <label for="articulos_id">articulos id</label><select name="articulos_id" id="articulos_id"><?php foreach($articulos as $opt):?><option value="<?php echo $opt->id?>"><?php echo $opt->description?></option><?php endforeach?></select><a href="./articulos/add">Nuevo</a><br>
	<label for="categorias_id">categorias id</label><select name="categorias_id" id="categorias_id"><?php foreach($categorias as $opt):?><option value="<?php echo $opt->id?>"><?php echo $opt->description?></option><?php endforeach?></select><a href="./categorias/add">Nuevo</a><br>
  <button type="submit">Edit</button>
</form>