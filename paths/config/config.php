<?php


if (session_id() === '') {
    session_start();
}

function echoConP($s) {
    echo "<p>" . htmlspecialchars($s) . "</p>";
}




