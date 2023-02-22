<?php
session_start();
require_once('../../ConexionBD/Conexion.php');
require_once('../../seguridad.php');
sanitizar($_SESSION);

$datos_request = json_decode(file_get_contents("php://input"), true);
sanitizar($datos_request);

if (isset($_SESSION['auntentificado']) && $_SESSION['auntentificado'] == "Muy_bien") {
	$tipo_id = $_SESSION['tipo_id'];
	$tipoPag = 1;
	if (!Seguridad_Tipo($tipo_id, $tipoPag)) {
		$home = $_SESSION['url'];
		header("Location: ../../$home/Inicio.php");
	}

	$obj_conexion = new ConexionBD();
	$conn = $obj_conexion->getConexion();
	if (is_null($conn)) {

		$error = 100;
		$mensaje = $obj_conexion->getMensaje();
		$mensaje = utf8_encode($mensaje);
		$error = 1;
		$mensaje = "inicial";
		$datos['error'] = '01';
		$datos['mensaje'] = 'Error en la conexion';
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($datos);
	} else {
		if (isset($datos_request['tipo'])) {

			$tipo = $datos_request['tipo'];
			sanitizar($tipo);
			$Alta_usuarios = "SELECT Usu from usuarios where Activo=0 and IdT= 1";
			$stmt = $conn->prepare($Alta_usuarios);
			$stmt->bindParam(':tipo', $tipo);
			$stmt->execute();

			$resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);

			header('Content-Type: application/json; charset=utf8');
			echo json_encode($resultset);
		} else {
			$error = 2;
			$mensaje = "No llegaron los datos";
			echo json_encode($datos_request);
		}
	}
} else {
	header("Location: ../../Inicio_de_sesion.html");
}
