<table name="articulos_index" cellmargin="0" cellpadding="0" cellspacing="0">
<tr>
  <th>articulos id</th>
<th>description</th>
<th>fotos id</th>
<th>code</th>
<th>actions</th>
</tr>
<?php foreach($articulos as $i=>$row):?>
<tr>
<td><?php echo $articulos[$i]->articulos_id?></td>
<td><?php echo $articulos[$i]->description?></td>
<td><?php echo $articulos[$i]->fotos_id?></td>
<td><?php echo $articulos[$i]->code?></td>
<td>
  <ul>
    <li><a href="./articulos/edit/<?php echo $articulos[$i]->articulos_id?>">edit</a></li>
    <li><a href="./articulos/delete/<?php echo $articulos[$i]->articulos_id?>">delete</a></li>
  </ul>
</td>
</tr>
<?php endforeach?>
</table>
<a href="./articulos/add">add a new one</a>
