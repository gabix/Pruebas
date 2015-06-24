<?php
if (session_id() == '') {
    session_start();
}

$pagTitle = "divCajas";
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

                behavior: url(othersLib/PIE.htc);
            }
            #shadow {
                -webkit-filter: blur(10px);
                filter: blur(10px);
                
                background-color: #000000;
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
        
        <div id="shadow" class="d_bordes">
        </div>


        <script type="text/javascript"></script>
    </body>
</html>
