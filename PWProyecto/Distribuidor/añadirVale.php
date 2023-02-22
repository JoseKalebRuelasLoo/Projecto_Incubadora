<?php

session_start();

require_once('../ConexionBD/Conexion.php');

require_once('../seguridad.php');

sanitizar($_SESSION);

$datos_request = json_decode(file_get_contents("php://input"), true);
sanitizar($datos_request);

if (isset($_SESSION['auntentificado']) && $_SESSION['auntentificado'] == "Muy_bien") {
    $tipo_id = $_SESSION['tipo_id'];
    $tipoPag = 2;
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

        $id = "SELECT IdD from distribuidores where Nombre = :Nombre";
        $stmt = $conn->prepare($id);
        $stmt->bindParam(':Nombre', $nombre);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $registro = $stmt->fetch();
        $IdD = $registro['IdD'];

        $Nombre = $datos_request["Nombre"];
        $Apellido = $datos_request["Apellido"];

        $id2 = "SELECT IdC from clientes where Nombre = :Nombre and Apellido = :Apellido";
        $stmt = $conn->prepare($id2);
        $stmt->bindParam(':Nombre', $Nombre);
        $stmt->bindParam(':Apellido', $Apellido);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $registro = $stmt->fetch();
        $IdC = $registro['IdC'];

        $Tipo = $datos_request["Tipo"];
        $FechaFin = $datos_request["FechaFin"];
        $MontoSol = $datos_request["MontoSol"];
        $NumQuin = $datos_request["NumQuin"];
        $PagoQuin = $datos_request["PagoQuin"];
        $Inter = $datos_request["Inter"];
        $PagoTot = $datos_request["PagoTot"];

        $id3 = "SELECT max(IdV)+1 as 'IdV' from vales";
        $stmt = $conn->prepare($id3);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $registro = $stmt->fetch();
        $IdV = $registro['IdV'];

        $qryAñadirVale = "INSERT INTO vales (IdV, Tipo, FechaIn, FechaFin, MontoSol, NumQuin, PagoQuin, Inter, PagoTot, IdC, IdD, Pagado) 
        VALUES (:IdV, :Tipo, now(), :FechaFin, :MontoSol, :NumQuin, :PagoQuin, :Inter, :PagoTot, :IdC, :IdD, 0)";
        $stmt = $conn->prepare($qryAñadirVale);
        $stmt->bindParam(':Tipo', $Tipo);
        $stmt->bindParam(':FechaFin', $FechaFin);
        $stmt->bindParam(':MontoSol', $MontoSol);
        $stmt->bindParam(':NumQuin', $NumQuin);
        $stmt->bindParam(':PagoQuin', $PagoQuin);
        $stmt->bindParam(':Inter', $Inter);
        $stmt->bindParam(':PagoTot', $PagoTot);
        $stmt->bindParam(':IdC', $IdC);
        $stmt->bindParam(':IdD', $IdD);
        $stmt->bindParam(':IdV', $IdV);
        $stmt->execute();

        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($registro);
    }
} else {
    header("Location:../Inicio_de_sesion.html");
}
