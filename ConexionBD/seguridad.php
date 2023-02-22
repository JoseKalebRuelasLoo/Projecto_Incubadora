<?php
require_once('Conexion.php');

function sanitizar($DATOS = null)
{
    foreach ($DATOS as $llave => $valor) {
        $DATOS[$llave] = strip_tags($valor);
    }
}

function Seguridad_Tipo($tipo, $tipoPag)
{
    if (isset($tipo) && isset($tipoPag)) {

        $datos['tipo'] = $tipo;
        $datos['tipoPag'] = $tipoPag;

        sanitizar($datos);

        $tipo = $datos['tipo'];
        $tipoPag = $datos['tipoPag'];

        if ($tipo == $tipoPag) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
