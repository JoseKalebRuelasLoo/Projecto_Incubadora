<?php
Class ConexionBD{

    private $dsn;
    private $username;
    private $password;
    private $conexion;
    private $mensaje;

    public function __construct() {

        $this->dsn="mysql:host=127.0.0.1:3306; dbname=proyecto";
        $this->username="Kaleb";
        $this->password= "/KzhjoVDO[LWqV-I";

        try {

            $this->conexion = new PDO($this->dsn,$this->username,$this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

        } catch (PDOException $e) {
            
           $msg = "Error en la conexion en la linea: ". $e->getLine()." <br>";
           $msg .= "Mensaje de error: " .$e->getMessage(). " <br>" ;
           $msg .= "Codigo de la excepcion: ".$e->getCode();
           $this->mensaje = $msg;

        }
    }

    public function __destruct(){
        $this->conexion=null;
    }

    public function getConexion(){
        return $this->conexion;
    }

    public function getMensaje(){
        return $this->mensaje;
    }

    private function convertirUTF8($arreglo){

        array_walk_recursive($arreglo,function(&$elemento,$llave){
            if(!mb_detect_encoding($elemento,'utf-8',true)){
                $elemento= utf8_decode($elemento);
            }
        });

    }

}
