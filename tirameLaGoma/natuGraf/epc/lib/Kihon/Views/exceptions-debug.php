<html>
  <head>

  </head>
  <body>
    <h1>Holy cow! something terrible happened.</h1>
    <h2>It was a <?php echo $exception_type?> </h2>
    <p>It said:
    <quote><?php echo $exception->getMessage()?></quote></p>
    <h2>Here is how it came to happen:</h2>
    <ol>
      <?php $steps = array_reverse($exception->getTrace());
      foreach($steps as $step):?>
      <li><pre><?php var_dump($step)?></pre></li>
      <?php endforeach?>
    </ol>
  </body>
</html>