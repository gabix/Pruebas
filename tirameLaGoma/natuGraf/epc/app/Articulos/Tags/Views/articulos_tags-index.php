<table name="articulos_tags_index" cellmargin="0" cellpadding="0" cellspacing="0">
<tr>
  <th>articulos id</th>
<th>tags id</th>
<th>actions</th>
</tr>
<?php foreach($articulos_tags as $i=>$row):?>
<tr>
<td><?php echo $articulos_tags[$i]->articulos_id?></td>
<td><?php echo $articulos_tags[$i]->tags_id?></td>
<td>
  <ul>
    <li><a href="./articulos_tags/edit/<?php echo $articulos_tags[$i]->articulos_tags_id?>">edit</a></li>
    <li><a href="./articulos_tags/delete/<?php echo $articulos_tags[$i]->articulos_tags_id?>">delete</a></li>
  </ul>
</td>
</tr>
<?php endforeach?>
</table>
<a href="./articulos_tags/add">add a new one</a>
