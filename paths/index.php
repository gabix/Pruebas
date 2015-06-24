<?php
require_once 'config/config.php';
require_once 'lang/lang.php';

require_once 'cls/c_cacota.php';
//require_once 'lang/l_errMsg.es.php';


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1>Path</h1>
        <hr />
<?php
$ca = new c_cacota();
$ca->setCaca("mi caca es dulce", "es");
$ech = $ca->getCaca();
echoConP($ech);
?>
        <hr />
<?php
$ech = $ca->traerMierdaDelInodoro();
$ech = l_msg($ech['msg']);
echoConP($ech);
?>
    </body>
</html>
