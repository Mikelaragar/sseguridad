<?php
session_start();
require_once("config.php");

comprobar_usuario();


if (isset($_POST['id'])){
    $conexion = get_connection();
    if ($conexion){
        $id = $_POST['id'];
        $query = "DELETE FROM  usuarios WHERE id_usuario = ?";
        $stmt2 = $conexion->prepare($query);
        $stmt2->bind_param("i", $id);
        if ($stmt2->execute()) {
            $_SESSION["mensaje"] = "Cuenta eliminada";
            header("location:../usuarios.php");
        } else {
            $_SESSION["error"] = "Error al eliminar el usuario";
            header("location:../usuarios.php");
        }

    }
    else{
        $_SESSION["error"] = "Error con la base de datos";
        header("location:../usuarios.php");

    }

}
else{
    $_SESSION["error"] = "Fallo con el usuario";
    header("location:../usuarios.php");
}