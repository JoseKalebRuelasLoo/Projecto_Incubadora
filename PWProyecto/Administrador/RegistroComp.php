<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../Style.css">
	<script src="RegistroComp.js"></script>
</head>

<body>
	<div class="container">
		<header class="hijos">
			<h1 id='titulo'>Registro de Compañias</h1>
		</header>
		<?php
		session_start();
		require_once('../seguridad.php');
		sanitizar($_SESSION);
		if (isset($_SESSION['auntentificado']) && $_SESSION['auntentificado'] == "Muy_bien") {
			$tipo_id = $_SESSION['tipo_id'];
			$tipoPag = 1;
			if (!Seguridad_Tipo($tipo_id, $tipoPag)) {
				$home = $_SESSION['url'];
				header("Location: ../$home/Inicio.php");
			}
		} else {
			header("Location: ../Inicio_de_sesion.html");
		}
		?>
		<?php
		require_once('menu.php');
		?>
		<section class="hijos">
			<h2>Añadir Empresa</h2>
			<br><br>
			<table class="Tabla Tabla-Responsiva Tabla-Borde Tabla-Zebra Tabla-50">
				<thead>
					<tr>
						<th class="txt-center" scope="col">Nombre</th>
						<th class="txt-center" scope="col">Descripcion</th>
						<th class="txt-center" scope="col"></th>
					</tr>
				</thead>
				<tbody id="contenedor">

				</tbody>
			</table>

		</section>
		<footer class="hijos">
			<h4 id="FootFin">ITCHII / Grupo A / ISC / 5to Semestre / ProgramaciÃ³n Web</h4>
		</footer>
		<dialog id="msg">
			<h2 id="msg_titulo">Titulo</h2>
			<p id="msg_cuerpo"></p>
			<button id="msg_cerrar" class="boton msgboton"> Cerrar</button>
		</dialog>
	</div>
</body>

</html>