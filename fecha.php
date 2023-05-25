<?php
require_once("config.php");

if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];
    $id = 1;

    $conexion = get_connection();

    if (!$conexion) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    $query = "UPDATE placas SET ufecha=? WHERE id_placa=?";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("si", $fecha, $id);

    if ($stmt->execute()) {
        echo "Inserción exitosa";
    } else {
        echo "Error al insertar en la base de datos: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "No";
}
?>
