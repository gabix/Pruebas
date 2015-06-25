<?php


function cacaHTML($dameCaca){
    $miramira = <<<MIRAMIRA
    <div class="pingorcha">#contenido</div>
MIRAMIRA;

    return str_replace("#contenido", $dameCaca, $miramira);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>dameCaca</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
<h1>DAME CACA!</h1>
<p></p>

<form>
    <input type="text" name="dameCaca">
</form>

    </body>
</html>