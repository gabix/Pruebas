<?php
function show_as_list($array){
  $buf = '<ul>';
  foreach($array as $node){
    $children = '';
    if(count($node['children'])>0){
      $children = show_as_list($node['children']);
    }
    $a_model = '<a href="./articulos/por_categoria/%s">%s</a>';
    $li_model = '<li>%s %s</li>';
    $anchor = sprintf($a_model,$node['categorias_id'],$node['description']);
    $buf.=sprintf($li_model, $anchor,$children);
  }
  $buf .='</ul>';
  return $buf;
}
echo show_as_list($tree);
?>