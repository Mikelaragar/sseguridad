<?php
require_once("config.php");

$conexion = get_connection();

if ($conexion) {
    $query2 = "SELECT est FROM sensores ORDER BY id_sensor ASC";
    $st2 = $conexion->prepare($query2);
    $st2->execute();
    $result2 = $st2->get_result();

    while ($registro2 = $result2->fetch_assoc()) {
        $sensores2[] = $registro2["est"]; // Agregar el valor de "est" al arreglo
    }
}

$conexion->close();

// Imprimir los valores de los sensores
foreach ($sensores2 as $sensor) {
    echo $sensor . " ";
}
?>
