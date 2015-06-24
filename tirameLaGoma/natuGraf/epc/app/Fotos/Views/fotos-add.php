<h2><a href="./">Index</a></h2>
<form action="./fotos/do_add" method="post">
  <label for="path">path</label><input type="text" name="path" id="path" value="<?php echo $_POST["path"]?>"/><br/>
	<label for="description">description</label><input type="text" name="description" id="description" value="<?php echo $_POST["description"]?>"/><br/>
  <button type="submit">Add</button>
</form>