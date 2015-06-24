<table name="fotos_index" cellmargin="0" cellpadding="0" cellspacing="0">
<tr>
  <th>fotos id</th>
<th>path</th>
<th>description</th>
<th>actions</th>
</tr>
<?php foreach($fotos as $i=>$row):?>
<tr>
<td><?php echo $fotos[$i]->fotos_id?></td>
<td><?php echo $fotos[$i]->path?></td>
<td><?php echo $fotos[$i]->description?></td>
<td>
  <ul>
    <li><a href="./fotos/edit/<?php echo $fotos[$i]->fotos_id?>">edit</a></li>
    <li><a href="./fotos/delete/<?php echo $fotos[$i]->fotos_id?>">delete</a></li>
  </ul>
</td>
</tr>
<?php endforeach?>
</table>
<a href="./fotos/add">add a new one</a>
