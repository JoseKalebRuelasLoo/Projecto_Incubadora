<?php

session_start();

require_once('../ConexionBD/Conexion.php');

require_once('../seguridad.php');

sanitizar($_SESSION);

if (isset($_SESSION['auntentificado']) && $_SESSION['auntentificado'] == "Muy_bien") {
    $tipo_id = $_SESSION['tipo_id'];
    $tipoPag = 3;
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

        $nombre = $_SESSION["nombre"];

        $id = "SELECT IdC from clientes where Nombre = :Nombre";
        $stmt = $conn->prepare($id);
        $stmt->bindParam(':Nombre', $nombre);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $registro = $stmt->fetch();
        $IdC = $registro['IdC'];

        $vales = "SELECT Tipo, FechaIn, FechaFin, NumQuin, PagoQuin, Inter, PagoTot from Vales where IdC = :IdC and Pagado = 0";
        $stmt = $conn->prepare($vales);
        $stmt->bindParam(':IdC', $IdC);
        $stmt->execute();

        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($registro);
    }
} else {
    header("Location:../Inicio_de_sesion.html");
}
