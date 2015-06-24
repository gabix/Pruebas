<?php
if (session_id() == '') {
    session_start();
}

$pagTit = "Debug sess y cookie";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?= sprintf('%s<title>%s</title>%s', "\t\t", $pagTit, "\n") ?>
        <style>
            h1 {text-align: center; color: #0081c2;}
            h3 {color: green;}
        </style>
    </head>
    <body>
        <script type="text/javascript"></script>
    </body>
</html>