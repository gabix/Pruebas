<h2><a href="./">Index</a></h2>
<form action="./categorias/do_edit/<?php echo $categorias[0]->categorias_id?>" method="post">
  <input type="hidden" name="categorias_id" id="categorias_id" value="<?php echo $categorias[0]->categorias_id?>"/>
  <label for="description">description</label><input type="text" name="description" id="description" value="<?php echo $categorias[0]->description?>"/><br>
  <button type="submit">Edit</button>
</form>