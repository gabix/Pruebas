<h2><a href="/">Index</a></h2>
<form action="categorias/do_add" method="post">
  <label for="description">description</label>
  <input type="text" name="description" id="description" value="<?php echo $_POST["description"]?>"/><br/>
  <label for="parent_id">parent</label>
  <select name="parent_id" id="parent_id">
  <option value="-1">Pick one:</option>
  <option value="-1">------------------</option>
  <?php foreach($categorias as $categoria):?>
    <option value="<?php echo $categoria->id?>"><?php echo $categoria->description?></option>
  <?php endforeach?>
  </select>
  <button type="submit">Add</button>
</form>