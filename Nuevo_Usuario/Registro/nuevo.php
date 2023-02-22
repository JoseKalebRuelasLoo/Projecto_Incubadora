<?php
session_start();
require_once('../../ConexionBD/Conexion.php');

function sanitizar($DATOS = null)
{
    foreach ($DATOS as $llave => $valor) {
        $DATOS[$llave] = strip_tags($valor);
    }
}

$error = 1;
$mensaje = "Inicial";

$datos_request = json_decode(file_get_contents("php://input"), true);

function validar($nombre, $apellido, $telefono, $domicilio, $ocupacion, $genero, $correo, $contraseña1)
{
    global $error;
    global $mensaje;
    $error = 0;
    if ($nombre == "") {
        $error = 1;
        $mensaje .= "<li>Nombre vacio";
    }
    if ($apellido == "") {
        $error = 1;
        $mensaje .= "<li>Apellido vacio";
    }
    if ($telefono == "") {
        $error = 1;
        $mensaje .= "<li>Telefono vacio";
    }
    if ($domicilio == "") {
        $error = 1;
        $mensaje .= "<li>Domicilio vacio";
    }
    if ($ocupacion == "") {
        $error = 1;
        $mensaje .= "<li>Ocupacion vacio";
    }
    if ($genero == "") {
        $error = 1;
        $mensaje .= "<li>Genero vacio";
    }
    if ($correo == "") {
        $error = 1;
        $mensaje .= "<li>Correo vacio";
    }
    if ($contraseña1 == "") {
        $error = 1;
        $mensaje .= "<li>Contraseña vacio";
    }
}

if (isset($datos_request['pass']) && isset($datos_request['correo'])) {

    sanitizar($datos_request);
    $nombre = $datos_request['nombre'];
    $apellido = $datos_request['apellido'];
    $telefono = $datos_request['telefono'];
    $domicilio = $datos_request['domicilio'];
    $ocupacion = $datos_request['ocupacion'];
    $genero = $datos_request['genero'];
    $correo = $datos_request['correo'];
    $contraseña1 = $datos_request['pass'];

    validar($nombre, $apellido, $telefono, $domicilio, $ocupacion, $genero, $correo, $contraseña1);

    if ($error == 0) {

        $obj_conexion = new ConexionBD();
        $conn = $obj_conexion->getConexion();

        if (is_null($conn)) {
            $error = 100;
            $mensaje = $obj_conexion->getMensaje();
            $mensaje = utf8_encode($mensaje);
        } else {

            $stmt = $conn->prepare("SELECT * from clientes where Correo = :Correo");
            $stmt->bindParam(':Correo', $correo);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $count1 = $stmt->rowCount();

            $stmt = $conn->prepare("SELECT * from usuarios where Usu = :usuario");
            $stmt->bindParam(':usuario', $correo);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $count2 = $stmt->rowCount();

            if (($count1 == 0) && ($count2 == 0)) {
                try {

                    $conn->beginTransaction();
                    $Re_usuario = "INSERT into usuarios (Usu,Pass,IdT,Activo) 
                    values(:usuario,:pass,2,0)";
                    $stmt = $conn->prepare($Re_usuario);

                    $stmt->bindParam(':usuario', $correo);
                    $stmt->bindParam(':pass', $contraseña1);
                    $stmt->execute();

                    $stmt = $conn->prepare("SELECT * from clientes");
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();
                    $count = $stmt->rowCount();

                    $count++;

                    $Re_cliente = "INSERT INTO `clientes` (`IdC`, `Nombre`, `Apellido`, `Correo`, `Tel`, `Dom`, `Ocupacion`, `Gen`, `Activo`) 
                    VALUES (:Id, :Nombre, :Apellido, :Correo, :Tel, :Dom, :Ocupacion, :Genero, '0')";
                    $stmt = $conn->prepare($Re_cliente);

                    $stmt->bindParam(':Id', $count);
                    $stmt->bindParam(':Nombre', $nombre);
                    $stmt->bindParam(':Apellido', $apellido);
                    $stmt->bindParam(':Correo', $correo);
                    $stmt->bindParam(':Tel', $telefono);
                    $stmt->bindParam(':Dom', $domicilio);
                    $stmt->bindParam(':Ocupacion', $ocupacion);
                    $stmt->bindParam(':Genero', $genero);

                    $stmt->execute();

                    $error = 0;
                    $mensaje = "Registro completo";
                    $conn->commit();
                } catch (PDOException $e) {
                    $msg = "<li>Error en la conexion, linea: " . $e->getLine() . " </li>";
                    $msg .= "<li>Script causante: " . $e->getFile() . "</li>";
                    $msg .= "<li>" . $e->getMessage() . "</li>";
                    $error = 3;
                    $mensaje = $msg;
                    $conn->rollBack();
                }
            } else {
                $error = 4;
                $mensaje = "Correo ocupado";
            }
        }
    }
} else {
    $error = 2;
    $mensaje = "No llegaron los datos";
    $_SESSION = array();
    session_destroy();
}

$datos['error'] = $error;
$datos['mensaje'] = $mensaje;

header('Content-Type: application/json; charset=utf8');
echo json_encode($datos);