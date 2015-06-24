<?php
function get_lang($lang = "en") {
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $_SESSION['usu']['lang'] = $lang;
        //TODO: preguntar si cambio en la db o no
    } else {
        if (isset($_SESSION['usu']['lang'])) {
            $lang = $_SESSION['usu']['lang'];
        }
    }
    return $lang;
}

function l_errMsg($lang, $errMsg) {
    include '/lang/l_errMsg.' . $lang . '.php';
    return $l_errMsg[$errMsg];
}

function l_msg($msg) {
    $msg = explode("-", $msg);
    switch ($msg[0]) {
        case "l_errMsg" : return l_errMsg(get_lang(), $msg[1]); break;
        default : return ""; break;
    }
}