<?php
session_start();
require_once("config.php");

comprobar_usuario();

if (isset($_POST['id']) && strlen($_POST['id'])>0){
if (isset($_POST['newpass']) && strlen($_POST['newpass']) > 0){


    $conexion = get_connection();
    if ($conexion){
        $newpass = $_POST['newpass'];
        $id = $_POST['id'];
        $salt = "salt_mikel";
        $passhash = password_hash($newpass . $salt, PASSWORD_DEFAULT);
        $query = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";
        $stmt2 = $conexion->prepare($query);
        $stmt2->bind_param("si", $passhash, $id);

        if ($stmt2->execute()) {
            $_SESSION["mensaje"] = "Contraseña cambiada exitosamente";
            header("location:../usuarios.php");
        } else {
            $_SESSION["error"] = "Error al cambiar la contraseña";
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
