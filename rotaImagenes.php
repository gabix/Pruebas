<?php
$p = "rotaImagenes.php";
$title = "rota imágenes";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/nuevajome.css" rel="stylesheet" />
    <style type="text/css">
        .site-wrapper {
            display: table;
            position: relative;
            width: 100%;
            height: 100%; /* For at least Firefox */
            min-height: 100%;
            -webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);
            box-shadow: inset 0 0 100px rgba(0,0,0,.5);
        }

        #bg {
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
        }
        #bg img {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            min-width: 50%;
            min-height: 50%;
        }


    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div id="bg">
    <img id="im_fondo" src="img/fondos/alFiruleteo.jpg" />
</div>

<div class="site-wrapper">
    <div class="site-wrapper-inner">

        <div class="cover-container">

            <!-- aca la navbar!! -->
            <div class="masthead clearfix">
                <div class="inner">
                    <nav>
                        <h3 class="masthead-brand"><?= $title ?></h3>
                        <ul class="nav masthead-nav">
                            <li class="active" id="li_home">
                                <a href="#d_home" data-toggle="tab">Inicio</a>
                            </li>
                            <li id="li_cursos">
                                <a href="#d_cursos" data-toggle="tab">Cursos</a>
                            </li>
                            <li id="li_profe">
                                <a href="#d_profe" data-toggle="tab">La Profe</a>
                            </li>
                            <li id="li_contacto">
                                <a href="#d_contacto" data-toggle="tab">Contacto</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div id="d_tabsContenido" class="inner cover tab-content">
                <div id="d_home" class="tab-pane fade in active" role="tabpanel">
                    <h1><?= $title ?></h1>
                    <hr />
                    <div class="contenido">
                        contenido de inicio
                    </div>
                </div>

                <div id="d_cursos" class="tab-pane fade" role="tabpanel">
                    <h1><?= $title ?></h1>
                    <hr />
                    <div class="contenido">
                        contenido de cursos
                    </div>
                </div>

                <div id="d_profe" class="tab-pane fade" role="tabpanel">
                    <h1><?= $title ?></h1>
                    <hr />
                    <div class="contenido">
                        contenido de profe
                    </div>
                </div>

                <div id="d_contacto" class="tab-pane fade" role="tabpanel">
                    <h1><?= $title ?></h1>
                    <hr />
                    <div class="contenido">
                        contenido de contacto
                    </div>
                </div>
            </div>

            <!-- aca el footer con las banderitas -->
            <div class="mastfoot">
                <div class="inner">
                    <p>
                        Lenguaje:&nbsp;&nbsp;
                        <a href="<?= $p ?>?l=es"><img class="im_banderitas" src="img/flags/flags-spain.png" alt="espa&ntilde;ol" /></a>
                        &middot;
                        <a href="<?= $p ?>?l=en"><img class="im_banderitas" src="img/flags/flags-united_kingdom.png" alt="english" /></a>
                        &middot;
                        <a href="<?= $p ?>?l=nl"><img class="im_banderitas" src="img/flags/flags-netherlands.png" alt="nederlands" /></a>
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
        //para las tabs
        $(document).on('click.bs.tab.data-api', '[data-toggle="tab"], [data-toggle="tab"]', function (e) {
            e.preventDefault()
            $('ul.nav li a[href="' + $(this).attr('href') + '"]').tab('show');
        })

        //el rota imgs
        var fondos = [
            'img/fondos/alFiruleteo.jpg',
            'img/fondos/avatar.jpg',
            'img/fondos/boc.filtro.jpg',
            'img/fondos/buHubuHu.v1.jpg',
            'img/fondos/carAzulia.jpg',
            'img/fondos/eGato.jpg',
            'img/fondos/tortugo.jpg',
            'img/fondos/unaRaveRural.jpg',
            'img/fondos/buHubuHu.v1.jpg'
        ];

        var img = $('#im_fondo');
        var cadaSegs = 3 * 1000;
        var fadeSpeed = "slow";
        var i = 0;

        setInterval( function() {
            CambiaFondo();
        }, cadaSegs);

        function CambiaFondo() {
            i = nextI(i, fondos.length);
            var nuevoSrc = fondos[i];
            console.log(nuevoSrc);

            // Fade the image out, then when done...
            img.fadeOut(fadeSpeed, function () {
                // Replace the src, then fade back in
                img.attr('src', nuevoSrc);
                img.fadeIn(fadeSpeed);
            });
        }

        function nextI(actI, arrLength) {
            if (actI === (arrLength - 1)) {
                actI = -1;
            }
            return (actI + 1)
        }

        function CambiaCSSbackground(nuevoSrc){
            $('body').css('background', 'url("'+nuevoSrc+'") no-repeat');
            $('body').css('background-size', 'cover');
            $('body').fadeIn();
        }
    });
</script>
</body>
</html>