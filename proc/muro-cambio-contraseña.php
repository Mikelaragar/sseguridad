<?php
require_once("config.php");
session_start();
comprobar_usuario();

if (isset($_POST['pass']) && strlen($_POST['pass']) > 0) {
    if (isset($_POST['newpass']) && strlen($_POST['newpass']) > 0) {
        if (isset($_POST['newpass2']) && strlen($_POST['newpass2']) > 0) {
            $pass = $_POST['pass'];
            $newpass = $_POST['newpass'];
            $newpass2 = $_POST['newpass2'];

            if ($newpass != $newpass2) {
                $_SESSION["error"] = "Las contraseñas nuevas no coinciden";
                header("location:../ajustes.php");
                exit;
            }

            $conexion = get_connection();

            $id = $_SESSION["id"];
            $salt = "salt_mikel";
            $query = "SELECT COUNT(*) AS number, password FROM usuarios WHERE id_usuario = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $registro = $resultado->fetch_assoc();

            if ($registro["number"] == 1 &&  password_verify($pass.$salt, $registro["password"])) {
                $passhash2 = password_hash($newpass . $salt, PASSWORD_DEFAULT);
                $query = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";
                $stmt2 = $conexion->prepare($query);
                $stmt2->bind_param("si", $passhash2, $id);

                if ($stmt2->execute()) {
                    $_SESSION["mensaje"] = "Contraseña cambiada exitosamente";
                    header("location:../ajustes.php");
                } else {
                    $_SESSION["error"] = "Error al cambiar la contraseña";
                    header("location:../ajustes.php");
                }

            } else {
                $_SESSION["error"] = "Contraseña actual incorrecta";
                header("location:../ajustes.php");
            }

            $conexion->close();
            header("location:../ajustes.php");
        } else {
            $_SESSION["error"] = "Contraseña repetida nueva no válida o no introducida";
            header("location:../ajustes.php");
        }
    } else {
        $_SESSION["error"] = "Contraseña nueva no válida o no introducida";
        header("location:../ajustes.php");
    }
} else {
    $_SESSION["error"] = "Contraseña actual no válida o no introducida";
    header("location:../ajustes.php");
}
?>
