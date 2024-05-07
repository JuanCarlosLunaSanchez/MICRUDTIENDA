<?php
session_start();
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS  
//VARIABLES DE USUARIO 
$idproducto = (isset($_POST['idproducto'])) ? $_POST['idproducto'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$data = [];

switch ($opcion) {
// ------------------------------------------------------------------------------------------------------------------------------------------->
    case "1": // GRAL -- ALTA GENERAL
        try {
            $consulta = "INSERT INTO productos ( nombre, descripcion, precio, cantidad ) VALUES(?,?,?,?)";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute([$nombre, $descripcion, $precio, $cantidad]);

            $consulta = "SELECT idproducto, nombre, descripcion, precio, cantidad FROM productos ORDER BY idproducto DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
        break;
// ------------------------------------------------------------------------------------------------------------------------------------------->  
    case "2": // GRAL -- MODIFICACION GENERAL
        try {
            $consulta = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio', cantidad = '$cantidad' WHERE idproducto = '$idproducto'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT idproducto, nombre, descripcion, precio, cantidad FROM productos WHERE idproducto='$idproducto' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
        break;
// ------------------------------------------------------------------------------------------------------------------------------------------->     
    case "3": // GRAL -- BAJA GENERAL
        $consulta = "DELETE FROM productos WHERE idproducto = '$idproducto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
}

//enviar el array final en formato json a JS
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
