<table name="tags_index" cellmargin="0" cellpadding="0" cellspacing="0">
<tr>
  <th>tags id</th>
<th>description</th>
<th>actions</th>
</tr>
<?php foreach($tags as $i=>$row):?>
<tr>
<td><?php echo $tags[$i]->tags_id?></td>
<td><?php echo $tags[$i]->description?></td>
<td>
  <ul>
    <li><a href="./tags/edit/<?php echo $tags[$i]->tags_id?>">edit</a></li>
    <li><a href="./tags/delete/<?php echo $tags[$i]->tags_id?>">delete</a></li>
  </ul>
</td>
</tr>
<?php endforeach?>
</table>
<a href="./tags/add">add a new one</a>
