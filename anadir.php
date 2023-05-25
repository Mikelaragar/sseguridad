<?php
require_once("config.php");

if (isset($_POST['fecha']) && isset($_POST['sensor']) && isset($_POST['estado'])){
    $fecha = $_POST['fecha'];
    $sensor = $_POST['sensor'];
    $estado = $_POST['estado'];

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
echo "nope";
?>
