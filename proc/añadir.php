<?php
require_once("config.php");

if (isset($_GET['fecha']) && isset($_GET['sensor']) && isset($_GET['estado'])){
    $fecha = $_GET['fecha'];
    $sensor = $_GET['sensor'];
    $estado = $_GET['estado'];

    $conexion = get_connection();

    $query = "INSERT INTO eventos (fecha, id_sensor, id_estado) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sii", $fecha, $sensor, $estado);

    if ($stmt->execute()){
        echo "Inserción exitosa";
    } else {
        echo "Error al insertar en la base de datos: " . $stmt->error;
    }

    $stmt->close();
}
echo "Error";
?>
