<h2><a href="./">Index</a></h2>
<form action="./articulos_tags/do_add" method="post">
  <label for="articulos_id">articulos id</label><select name="articulos_id" id="articulos_id"><?php foreach($articulos as $opt):?><option value="<?php echo $opt->id?>"><?php echo $opt->description?></option><?php endforeach?></select><a href="./articulos/add">Nuevo</a><br/>
	<label for="tags_id">tags id</label><select name="tags_id" id="tags_id"><?php foreach($tags as $opt):?><option value="<?php echo $opt->id?>"><?php echo $opt->description?></option><?php endforeach?></select><a href="./tags/add">Nuevo</a><br/>
  <button type="submit">Add</button>
</form>