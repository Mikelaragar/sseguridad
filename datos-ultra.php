<?php
require_once("config.php");

$conexion = get_connection();

if ($conexion) {
    $query = "SELECT descripcion FROM sensores WHERE id_sensor=2";
    $st = $conexion->prepare($query);
    $st->execute();
    $result = $st->get_result();
    $registro = $result->fetch_assoc();

    $des = $registro["descripcion"];
}

$conexion->close();

echo $des;
?>
