<?php
require_once("config.php");

$conexion = get_connection();

if ($conexion) {
    $query = "SELECT est FROM placas WHERE id_placa = 1";
    $st = $conexion->prepare($query);
    $st->execute();
    $result = $st->get_result();
    $registro = $result->fetch_assoc();

    $estPlaca = $registro["est"];
}

$conexion->close();

echo $estPlaca;
?>
