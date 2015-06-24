<h2><a href="./">Index</a></h2>
<form action="./fotos/do_edit/<?php echo $fotos[0]->fotos_id?>" method="post">
  <input type="hidden" name="fotos_id" id="fotos_id" value="<?php echo $fotos[0]->fotos_id?>"/>
  <label for="path">path</label><input type="text" name="path" id="path" value="<?php echo $fotos[0]->path?>"/><br>
	<label for="description">description</label><input type="text" name="description" id="description" value="<?php echo $fotos[0]->description?>"/><br>
  <button type="submit">Edit</button>
</form>