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
        $id3 = "SELECT max(IdA)+1 as 'IdA' from admins";
        $stmt = $conn->prepare($id3);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $registro = $stmt->fetch();
        $IdA = $registro['IdA'];

        $Nombre = $datos_request['Nombre'];
        $Apellido = $datos_request['Apellido'];
        $Correo = $datos_request['Correo'];
        $Pass = $datos_request['Pass'];

        $qryAñadirUA = "INSERT INTO usuarios values (:Usu,:Pass,1,1)";
        $stmt = $conn->prepare($qryAñadirUA);
        $stmt->bindParam(':Usu', $Correo);
        $stmt->bindParam(':Pass', $Pass);
        $stmt->execute();

        $qryAñadirA = "INSERT INTO admins values (:IdA,:Nombre,:Apellido,:Correo)";
        $stmt = $conn->prepare($qryAñadirA);
        $stmt->bindParam(':IdA', $IdA);
        $stmt->bindParam(':Nombre', $Nombre);
        $stmt->bindParam(':Apellido', $Apellido);
        $stmt->bindParam(':Correo', $Correo);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($datos_request);
    }
} else {
    header("Location: ../Inicio_de_sesion.html");
}
