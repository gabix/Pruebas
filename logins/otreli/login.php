<?php
/*
 * from http://woork.blogspot.com.ar/2007/10/login-using-ajax-and-php.html
 */
?>

<!-- Include AJAX Framework -->
<script src="ajax_framework.js" language="javascript"></script>

<!-- Show Message for AJAX response -->
<div id="login_response"></div>

<!-- Form: the action="javascript:login()"call the javascript function "login" into ajax_framework.js -->
<form action="javascript:login()" method="post">
<input name="emailLogin" type="text" id="emailLogin" value="emailLogin"/>
<input name="pswLogin" type="password" id="pswLogin" value="pswLogin"/>
<input type="submit" name="Submit" value="Login"/>
</form>
