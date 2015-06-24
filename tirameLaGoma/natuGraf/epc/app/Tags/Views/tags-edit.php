<h2><a href="./">Index</a></h2>
<form action="./tags/do_edit/<?php echo $tags[0]->tags_id?>" method="post">
  <input type="hidden" name="tags_id" id="tags_id" value="<?php echo $tags[0]->tags_id?>"/>
  <label for="description">description</label><input type="text" name="description" id="description" value="<?php echo $tags[0]->description?>"/><br>
  <button type="submit">Edit</button>
</form>