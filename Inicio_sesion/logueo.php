<?php
session_start();
require_once('../ConexionBD/Conexion.php');

function sanitizar($DATOS = null)
{
    foreach ($DATOS as $llave => $valor) {
        $DATOS[$llave] = strip_tags($valor);
    }
}

$error = 1;
$mensaje = "Inicial";

$datos_request = json_decode(file_get_contents("php://input"), true);
sanitizar($datos_request);
if (isset($datos_request['usuario']) && isset($datos_request['pass'])) {

    $usuario = $datos_request['usuario'];
    $pass = $datos_request['pass'];

    $obj_conexion = new ConexionBD();

    $conn = $obj_conexion->getConexion();

    if (is_null($conn)) {
        $error = 100;
        $mensaje = $obj_conexion->getMensaje();
        $mensaje = utf8_encode($mensaje);
    } else {

        $qry_ingresar = "SELECT Usu, Pass,IdT,Activo from usuarios where Usu = :usuario and pass = :pass and Activo = 1";

        $stmt = $conn->prepare($qry_ingresar);

        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':pass', $pass);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1) {

            $registro = $stmt->fetch();
            $tipo_id = $registro['IdT'];

            $qry_tipo = "SELECT URL , Nivel  from Tipos where IdT = :tipo_id";
            $stmt = $conn->prepare($qry_tipo);
            $stmt->bindParam(':tipo_id', $tipo_id);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $registro = $stmt->fetch();

            $tipo = $registro['Nivel'];
            $url = $registro['URL'];

            if ($tipo == 2) {
                $tabla = 'admins';
            } elseif ($tipo == 1) {
                $tabla = 'clientes';
            }

            $qry_tipo = "SELECT Nombre, Apellido, Correo from $tabla where Correo = :usuario";
            $stmt = $conn->prepare($qry_tipo);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $registro = $stmt->fetch();
            $nombre = $registro['Nombre'];

            //elimira intentos fallidos
            $stmt = $conn->prepare("DELETE from IntFall where UsuF = :usuario");
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();

            $_SESSION["auntentificado"] = "Muy_bien";
            $_SESSION["tipo"] = $tipo;
            $_SESSION["url"] = $url;
            $_SESSION["tipo_id"] = $tipo_id;
            $_SESSION["nombre"] = $nombre;

            $datos['url'] = $url;

            $error = 0;
        } else {

            //destruir sesion
            $_SESSION = array();
            session_destroy();

            $stmt = $conn->prepare("SELECT UsuF , Intentos from IntFall where UsuF  = :usuario");
            $stmt->bindParam(':usuario', $usuario);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count >= 1) {
                //encontro un usuario
                $registro = $stmt->fetch();
                $intentos = $registro['Intentos'];

                if ($intentos >= 3) {

                    //desactiva la cuenta
                    $qry_desactivar_usuario = "UPDATE Usuarios set Activo = 0 where Usu = :usuario";
                    $stmt = $conn->prepare($qry_desactivar_usuario);
                    $stmt->bindParam(':usuario', $usuario);
                    $stmt->execute();

                    //Se reinician los intentos
                    $intentos = 0;
                    $qry_incrementar_intentos = "UPDATE IntFall set Intentos = $intentos where UsuF  = :usuario";
                    $stmt = $conn->prepare($qry_incrementar_intentos);
                    $stmt->bindParam(':usuario', $usuario);
                    $stmt->execute();

                } else {

                    //Se incrementan los intentos
                    $intentos++;
                    $qry_incrementar_intentos = "UPDATE IntFall set Intentos = $intentos where UsuF  = :usuario";
                    $stmt = $conn->prepare($qry_incrementar_intentos);
                    $stmt->bindParam(':usuario', $usuario);
                    $stmt->execute();

                }

                $error = 1;

            } else {

                $qry_ingresar = "SELECT Usu, Pass,IdT,Activo from Usuarios where Usu=:usuario";
                $stmt = $conn->prepare($qry_ingresar);
                $stmt->bindParam(':usuario', $usuario);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                $count = $stmt->rowCount();

                if ($count == 1) {
                    $qry_crear_registro_intentos = "INSERT into IntFall(UsuF ,Intentos) values (:usuario,1)";
                    $stmt = $conn->prepare($qry_crear_registro_intentos);
                    $stmt->bindParam(':usuario', $usuario);
                    $stmt->execute();
                    $error = 2;
                } else {
                    //no ecuentra al usuario
                    $error = 3;
                }
            }
        }
    }
} else {
    $error = 4;
    $_SESSION = array();
    session_destroy();
}
$datos['error'] = $error;
$datos['mensaje'] = $mensaje;

header('Content-Type: application/json; charset=utf8');
echo json_encode($datos);