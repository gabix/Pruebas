
<h2>Listado</h2>
<a href="./categorias/add">Agregar nuevo</a>
<table name="categorias_index" cellmargin="0" cellpadding="0" cellspacing="0">
<tr>
  <th>categorias id</th>
<th>description</th>
<th>actions</th>
</tr>
<?php foreach($categorias as $i=>$row):?>
<tr>
<td><?php echo $categorias[$i]->categorias_id?></td>
<td><?php echo $categorias[$i]->description?></td>
<td>
  <ul>
    <li><a href="./categorias/edit/<?php echo $categorias[$i]->categorias_id?>">edit</a></li>
    <li><a href="./categorias/delete/<?php echo $categorias[$i]->categorias_id?>">delete</a></li>
  </ul>
</td>
</tr>
<?php endforeach?>
</table>
<h2>Preview</h2>
<?php echo View::compose('components/menu/categoria',array('tree'=>$preview))?>