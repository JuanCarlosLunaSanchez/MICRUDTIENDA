<?php
// Declaracion de variables para nuestra conexion con la BD  
define('servidor', 'localhost');
define('nombre_bd', 'tienda');
define('usuario', 'root');
define('password', '');

// Archivo en el lenguaje php que servira para la conexion del sistemas con nuestra base de datos en mysql
class Conexion {
    public static function Conectar(){  

        // Variable que servira para acceder a los parametros de las conexiones PD0
        $opciones = [ 
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // Funcion try catch para detectar y controlar una excepción generada por el codigo
        try{
            $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);
            return $conexion;
        } catch (Exception $e){
            // die("El error de Conexión es: ". $e->getMessage());
            print json_encode(["error"=>TRUE, "message"=>"error al ejecutar sql causa: ". $e->getMessage()]);
           die();
       }
   }
}
?>