<?php

session_start();
require_once('../seguridad.php');
sanitizar($_SESSION);

$datos_request = json_decode(file_get_contents("php://input"), true);
sanitizar($datos_request);


if (isset($_SESSION['auntentificado']) && $_SESSION['auntentificado'] == "Muy_bien") {
    $tipo_id = $_SESSION['tipo_id'];
    $tipoPag = 1;
    if (!Seguridad_Tipo($tipo_id, $tipoPag)) {
        $home = $_SESSION['url'];
        header("Location: ../$home/Inicio.php");
    }

    $obj_conexion = new ConexionBD();

    $conn = $obj_conexion->getConexion();
    if (is_null($conn)) {
        $error = 100;
        $mensaje = $obj_conexion->getMensaje();
        $mensaje = utf8_encode($mensaje);
        $error = 1;
        $mensaje = "Inicial";
        $datos['error'] = '01';
        $datos['mensaje'] = 'Error en la conexion';
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($datos);
    } else {

        $Usu = $datos_request['Usu'];
        $qryActivarClienteU = "UPDATE usuarios set Activo = 1 where Usu = :Usu";
        $stmt = $conn->prepare($qryActivarClienteU);
        $stmt->bindParam(':Usu', $Usu);
        $stmt->execute();

        $qryActivarCliente = "UPDATE clientes set Activo = 1 where Correo = :Usu";
        $stmt = $conn->prepare($qryActivarCliente);
        $stmt->bindParam(':Usu', $Usu);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($datos_request);
    }
} else {
    header("Location: ../Inicio_de_sesion.html");
}
