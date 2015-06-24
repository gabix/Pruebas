<h2><a href="./">Index</a></h2>
<form action="./articulos/do_edit/<?php echo $articulos[0]->articulos_id?>" method="post">
  <input type="hidden" name="articulos_id" id="articulos_id" value="<?php echo $articulos[0]->articulos_id?>"/>
  <label for="description">description</label><input type="text" name="description" id="description" value="<?php echo $articulos[0]->description?>"/><br>
	<label for="fotos_id">fotos id</label><select name="fotos_id" id="fotos_id"><?php foreach($fotos as $opt):?><option value="<?php echo $opt->id?>"><?php echo $opt->description?></option><?php endforeach?></select><a href="./fotos/add">Nuevo</a><br>
	<label for="code">code</label><input type="text" name="code" id="code" value="<?php echo $articulos[0]->code?>"/><br>
  <button type="submit">Edit</button>
</form>