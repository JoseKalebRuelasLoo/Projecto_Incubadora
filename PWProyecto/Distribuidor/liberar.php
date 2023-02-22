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

        $IdV = $datos_request["IdV"];
        $qryUpdate = "UPDATE Vales set Pagado = 1 where IdV = :IdV";
        $stmt = $conn->prepare($qryUpdate);
        $stmt->bindParam(':IdV', $IdV);
        $stmt->execute();

        $nombre = $_SESSION["nombre"];

        $id = "SELECT IdD from distribuidores where Nombre = :Nombre";
        $stmt = $conn->prepare($id);
        $stmt->bindParam(':Nombre', $nombre);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $registro = $stmt->fetch();
        $IdD = $registro['IdD'];

        $vales = "SELECT Vales.IdV, Vales.Tipo, Vales.FechaIn, Vales.FechaFin, Vales.MontoSol, Vales.NumQuin, Vales.PagoQuin, Vales.Inter, Vales.PagoTot, concat(Clientes.Nombre,' ' ,Clientes.Apellido) as 'Nombres', Vales.PagoTot 
        FROM Vales inner join clientes on clientes.IdC = vales.IdC WHERE IdD = :IdD and Pagado = 0;";
        $stmt = $conn->prepare($vales);
        $stmt->bindParam(':IdD', $IdD);
        $stmt->execute();

        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($registro);
    }
} else {
    header("Location:../Inicio_de_sesion.html");
}
