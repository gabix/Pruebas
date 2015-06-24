<?php
// Funquis.php - Funciones útiles
class Funquis {

	// TablaConSombra($titu, $contenido)
	//	recibe un tutulo y un contenido y crea una tabla con sombritas en los bordes
	public function TablaConSombra($titu, $contenido) {
			echo('
				<table cellpadding="0" cellspacing="0" border="0">

						<!-- Bordes sombreados de arriba -->
					<tr>
						<td><img src="img/Bordes/BordeSom_ArrIzq_paRep.png" /></td>
						<td class="td_bordeArribaCentro"></td>
						<td><img src="img/Bordes/BordeSom_ArrDer_paRep.png" /></td>
					</tr>

						<!-- Bordes sombreados del medio -->
					<tr>
						<td class="td_bordeMedioIzq"></td>

						<!-- TITULO -->
						<td class="td_centYcolfondo">
							<p class="p_tituloPri">'
							. $titu . '</p>
						</td>
						<!-- Fin del TITULO -->

						<td class="td_bordeMedioDer"></td>
					</tr>

					<tr>
						<td class="td_bordeMedioIzq"></td>

						<!-- CONTENIDO -->
						<td class="td_centYcolfondo">
									<center>
									<br />
									' . $contenido . '
									<br />
									<br />
									<br />
									</center>
						</td>
						<!-- Fin del CONTENIDO -->
						<td class="td_bordeMedioDer"></td>
					</tr>

					<!-- Bordes sombreados de abajo -->
					<tr>
						<td><img src="img/Bordes/BordeSom_AbaIzq_paRep.png" /></td>
						<td class="td_bordeAbajoCentro" valign="top"></td>
						<td><img src="img/Bordes/BordeSom_AbaDer_paRep.png" /></td>
					</tr>
				</table>
			');
		}

	// Carga menu.xml
	public function LoadMenu_xml() {
		if (file_exists('inc/menu.xml')) {
			return simplexml_load_file('inc/menu.xml');
		} else {
			exit('Error al abrir menu.xml');
		}
	}


}
?>