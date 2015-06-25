<?php
$caca = "La caca";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <title><?= $caca ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
/* css */

        </style>
    </head>
    <body>

<h1><?= $caca ?></h1>
<div>TODO write content</div>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home">cacauan</div>
    <div role="tabpanel" class="tab-pane fade" id="profile">cacatwai</div>
    <div role="tabpanel" class="tab-pane fade" id="messages">cacadrai</div>
    <div role="tabpanel" class="tab-pane fade" id="settings">cacafear</div>
  </div>

</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
/* js */
// Enable tabbable tabs via JavaScript (each tab needs to be activated individually):
$('#myTabs a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
})

//You can activate individual tabs in several ways:
$('#myTabs a[href="#profile"]').tab('show') // Select tab by name
$('#myTabs a:first').tab('show') // Select first tab
$('#myTabs a:last').tab('show') // Select last tab
$('#myTabs li:eq(2) a').tab('show') // Select third tab (0-indexed)


    </script>
    </body>
</html>