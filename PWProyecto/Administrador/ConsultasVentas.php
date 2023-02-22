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
        $qryUsuariosC = "SELECT Ventas.IdVE, Distribuidores.Nombre, Usuarios.Usu, Ventas.Pago FROM Ventas 
        INNER JOIN Distribuidores ON Distribuidores.IdD = Ventas.IdD INNER JOIN Usuarios ON Usuarios.Usu = Distribuidores.Correo WHERE Pago = 0";
        $stmt = $conn->prepare($qryUsuariosC);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($datos);
    }
} else {
    header("Location: ../Inicio_de_sesion.html");
}