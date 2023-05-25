<?php
session_start();
require_once("config.php");

comprobar_usuario();

if (isset($_POST['id']) && strlen($_POST['id'])>0){
    if (isset($_POST['rol']) && strlen($_POST['rol']) > 0){


        $conexion = get_connection();
        if ($conexion){
            $rol = $_POST['rol'];
            $id = $_POST['id'];
            $query = "UPDATE usuarios SET id_rol = ? WHERE id_usuario = ?";
            $stmt2 = $conexion->prepare($query);
            $stmt2->bind_param("si", $rol, $id);

            if ($stmt2->execute()) {
                $_SESSION["mensaje"] = "Rol cambiado exitosamente";
                header("location:../usuarios.php");
            } else {
                $_SESSION["error"] = "Error al cambiar el rol";
                header("location:../usuarios.php");
            }

        }
        else{
            $_SESSION["error"] = "Error con la base de datos";
            header("location:../usuarios.php");

        }
    }
    else{
        $_SESSION["error"] = "Contraseña nueva no definida";
        header("location:../usuarios.php");
    }
}
else{
    $_SESSION["error"] = "Fallo usuario";
    header("location:../usuarios.php");
}
