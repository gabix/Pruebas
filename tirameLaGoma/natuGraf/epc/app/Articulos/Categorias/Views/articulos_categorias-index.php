<table name="articulos_categorias_index" cellmargin="0" cellpadding="0" cellspacing="0">
<tr>
  <th>articulos id</th>
<th>categorias id</th>
<th>actions</th>
</tr>
<?php foreach($articulos_categorias as $i=>$row):?>
<tr>
<td><?php echo $articulos_categorias[$i]->articulos_id?></td>
<td><?php echo $articulos_categorias[$i]->categorias_id?></td>
<td>
  <ul>
    <li><a href="./articulos_categorias/edit/<?php echo $articulos_categorias[$i]->articulos_categorias_id?>">edit</a></li>
    <li><a href="./articulos_categorias/delete/<?php echo $articulos_categorias[$i]->articulos_categorias_id?>">delete</a></li>
  </ul>
</td>
</tr>
<?php endforeach?>
</table>
<a href="./articulos_categorias/add">add a new one</a>
