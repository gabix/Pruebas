<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>formulario de ingreso a DB</title>
<style type="text/css">
    .item {
        border: 0.5em solid #dddddd;
        padding: 0.5em;
    }
    table {
        width: 100%;
        background-color: #dddddd;
    }
    table td {
        border: 0.2em solid #ffffff;
        padding: 0.2em;
    }
</style>
</head>

<body>
<form action=="formEnt.php" method="post" name="f" id="f">

<div class="item">
    <table>
        <tr>
            <td>
                c&oacute;digo&#58<input type="text" name="codigo" id="codigo" />
            </td>
            <td>
                nrProd&#58<input type="text" name="ContProd" id="ContProd" size="2" />
            </td>
        </tr>
        <tr>
            <td>
                nombre&#58<input type="text" name="nombre" id="nombre" /><br />
            </td>
            <td>
                pic&#58<input type="file" name="userfile" id="userfile" value="none" /><br />
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
        </tr>
    </table>
    
    
    <div>tags&#58&nbsp;1<input type="text" name="tag1" id="tag1" size="2" /></div>
    <div>2<input type="text" name="tag2" id="tag2" size="2" /></div>
    <div>3<input type="text" name="tag3" id="tag3" size="2" /></div>
    <p style="clear: both;" />
    
    tiendas&#58&nbsp;1<input type="text" name="tienda1" id="tienda1" size="2" />&nbsp;&nbsp;&nbsp;
    2<input type="text" name="tienda2" id="tienda2" size="2" />&nbsp;&nbsp;&nbsp;
    3<input type="text" name="tienda3" id="tienda3" size="2" />&nbsp;&nbsp;&nbsp;
    4<input type="text" name="tienda4" id="tienda4" size="2" /><br />
    
    cats&#58&nbsp;1<input type="text" name="cat1" id="cat1" size="2" />&nbsp;&nbsp;&nbsp;
    2<input type="text" name="cat2" id="cat2" size="2" />&nbsp;&nbsp;&nbsp;
    3<input type="text" name="cat3" id="cat3" size="2" /><br />
</div>

