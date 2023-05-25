<?php
require_once("config.php");

session_start();

if (isset($_POST['distancia']) && is_numeric($_POST['distancia'])) {
    if ($_POST['distancia'] > 0 && $_POST['distancia'] < 200){
        $conexion = get_connection();

        if ($conexion) {
            $id = $_POST['distancia'];
            $nom = 2;
            $query2 = "UPDATE sensores SET descripcion=? WHERE id_sensor=?";
            $stmt2 = $conexion->prepare($query2);
            $stmt2->bind_param("ss", $id, $nom);
            $stmt2->execute();

            if ($stmt2) {
                $_SESSION["mensaje"] = "Distancia cambiada";
                $stmt2->close();
                header('Location: ../sensores.php');
            } else {
                $_SESSION["error"] = "Error al cambiar la distancia";
                $stmt2->close();
                header('Location: ../sensores.php');
            }
        } else {
            $_SESSION["error"] = "Error con la base de datos";
            header('Location: ../sensores.php');
        }
    }
    else{
        $_SESSION["error"] = "Rango 1 a 200";
        header('Location: ../sensores.php');

    }
} else {
    $_SESSION["error"] = "Tipo de dato mal introducido o no definido";
    header('Location: ../sensores.php');
}
?>
