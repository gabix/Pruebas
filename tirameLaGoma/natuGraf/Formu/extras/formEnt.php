<?php
mysql_connect("localhost", "root", "");
	mysql_select_db("elpoetaceloso");

	mysql_query ("");
	echo(mysql_error());


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="grabar.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="800" border="0" align="center">
    <tr>
      <td width="374">&nbsp;</td>
      <td width="31">&nbsp;</td>
      <td width="381">&nbsp;</td>
    </tr>
    <tr>
      <td>CODIGO</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="text" name="ContProd" id="ContProd" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>NOMBRE</td>
      <td>&nbsp;</td>
      <td><input type="text" name="nombre" id="nombre" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>TAG1</td>
      <td>&nbsp;</td>
      <td><input type="text" name="tag1" id="tag1" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>TAG2</td>
      <td>&nbsp;</td>
      <td><input type="text" name="tag2" id="tag2" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>TAG3</td>
      <td>&nbsp;</td>
      <td><input type="text" name="tag3" id="tag3" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>FOTO</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="file" name="userfile" id="userfile" />
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="GRABAR" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>
