<?php
if (session_id() == '') {
    session_start();
}

$pagTitle = "divCajas2";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?= "<title>$pagTitle</title>\n" ?>
        <style>
            body {
                background-color: #EAEAEA;
            }
            h1, h2, h3 {
                color: #149bdf;
                text-align: center;
                margin: 0px;
                padding: 0px;
            }
            p {
                margin: 0px;
                padding: 0px;
            }

            #img_flecha {
                position: relative;
                width: 18px;
                margin-top: 50px;
                z-index: 1;
            }
            .d_bordes_flecha {
                float: left;
            }
            .d_bordes {
                position: relative;
                float: left;
                z-index: -1;

                width: 500px;
                height: 250px;

                background-color: white;

                -webkit-border-radius: 20px;
                border-radius: 20px;

                -webkit-box-shadow:  0px 0px 5px 2px rgba(0, 0, 0, 0.3);
                box-shadow:  0px 0px 5px 2px rgba(0, 0, 0, 0.3);
                
                behavior: url(othersLib/PIE.htc);
            }
            .d_bordes_contiene {
                padding: 10px;

                /*background-color: #b7d68e;*/
            }
        </style>
    </head>
    <body>
        <h1><?= $pagTitle ?></h1>
        <hr />

        <div class="d_bordes_flecha"><img id="img_flecha" src="flecha.png" alt="flecha" /></div>
        <div class="d_bordes">
            <div class="d_bordes_contiene">
                <h3>Mirá como hago un h3!</h3>
                <p>Acá tengo un contenido loco</p>
            </div>
        </div>
        
        <script type="text/javascript"></script>
    </body>
</html>
