<?php
	session_start();

	include_once("inc/MenuXMLdata.php");
	include_once("inc/Funquis.php");

	$func = new Funquis();

	$menuxml = $func->LoadMenu_xml();
	$xml = simplexml_load_file('inc/menu.xml');

	if ($_GET["reset"] == "reset") {
		$_GET["selectedTipo"] == 0;
		$_GET["selectedModelo"] == 0;
	}

?>

<html>

<head>
	<link rel="StyleSheet" type="text/css" href="Img/MenuXML.css" />
	<link rel="StyleSheet" type="text/css" href="Img/bordes.css" />
	<meta name="description" content="<?php echo($htmlDescripcion); ?>" />
	<meta name="keywords" content="<?php echo($htmlKeys); ?>" />
	<title><?php echo($htmlTitulo); ?></title>
</head>


<body><center>

	<!-- aca va el header
	<div id="cabeza">
		<?php
			include("inc/cabeza.php");
		?>
	</div> -->

	<?php
		// $func->TablaConSombra("miPhpTitu", "miPhpContenido<br />\n otra linea");
	?>

	<form style="text-align: center;" action="MenuXML.php" method="get">
		<h1>Formulario de edici&oacute;n del menu</h1>

		<table cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td>Tipos</td>
			</tr>
			<?php
				foreach ($menuxml->tipo as $tipo) {
					?>
			<tr><td>
					<?php
						echo('<input type="submit" name="selectedTipo" value="' . $tipo->tipoId . '"/>');
						echo("&nbsp; $tipo->tipoNombre \n");

						if ($_GET["selectedTipo"] == $tipo->tipoId) {
							?>
							<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td>Modelos</td>
							</tr>
							<?php
								foreach ($tipo->tipoModelos->modelo as $modelo) {
									?>
									<tr><td>
									<?php
										echo("&nbsp;&nbsp;&nbsp;&nbsp; $modelo->modeloNombre");
										echo('<input type="submit" name="selectedModelo" value="' . $tipo->tipoId . '-' . $modelo->modeloId . '"/>');
									?>
									</td></tr>
								<?php }
							?>
							<tr>
								<td>
									<input type="submit" name="selectedModelo" value="n"/>
				  					<input type="text" name="nuevoModelo" value="(nuevo)" size="30" maxlength="30"/>
								</td>
							</tr>
							</table>
						<?php }
					?>
			</td></tr>
				<?php }
			?>
			<tr>
				<td>
					<input type="submit" name="selectedTipo" value="n"/>
  					<input type="text" name="nuevoTipo" value="(nuevo)" size="30" maxlength="30"/>
				</td>
			</tr>
		</table>





	<input type="reset"/>
	</form>
	<!-- fin del header -->



</center></body>

</html>