<?php
session_start();
require_once("config.php");

comprobar_usuario();


if (isset($_POST['id'])){
    $conexion = get_connection();
    if ($conexion){
        $id = $_POST['id'];
        $query = "DELETE FROM  eventos WHERE id_evento = ?";
        $stmt2 = $conexion->prepare($query);
        $stmt2->bind_param("i", $id);
        if ($stmt2->execute()) {
            $_SESSION["mensaje"] = "Evento eliminado";
            header("location:../eventos.php");
        } else {
            $_SESSION["error"] = "Error al eliminar el evento";
            header("location:../eventos.php");
        }

    }
    else{
        $_SESSION["error"] = "Error con la base de datos";
        header("location:../eventos.php");

    }

}
else{
    $_SESSION["error"] = "Fallo con el usuario";
    header("location:../usuarios.php");
}