<?php
require_once("config.php");
session_start();

if (isset($_POST['usu']) && strlen($_POST['usu']) > 0) {
    if (isset($_POST['correo']) && strlen($_POST['correo']) > 0 && filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        if (isset($_POST['codigo']) && strlen($_POST['codigo']) > 0) {
            if (isset($_POST['pass']) && strlen($_POST['pass']) > 0) {
                $conexion = get_connection();
                if ($conexion) {
                    $usu = htmlentities($_POST['usu']);
                    $correo = $_POST['correo'];
                    $codigo = $_POST['codigo'];

                    $query = "SELECT COUNT(*) AS number FROM usuarios WHERE usuario=? AND correo=? AND codigos=?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("ssi", $usu, $correo, $codigo);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    $registro = $resultado->fetch_assoc();

                    if ($registro["number"] == 1) {
                       $usuario=$_POST['usu'];
                        $password=$_POST['pass'];
                        $salt = "salt_mikel";
                        //ciframos contraseña
                        $passhash = password_hash($password .$salt, PASSWORD_DEFAULT);
                        $query2 = "UPDATE usuarios SET password=? WHERE usuario=?";
                        $stmt2 = $conexion->prepare($query2);
                        $stmt2->bind_param("ss", $passhash, $usuario);
                        $stmt2->execute();
                        $stmt2->close();
                        if ($stmt2){
                            $_SESSION["men"] = "Contraseña Cambiada";
                            header('Location: ../index.php');

                        }
                        else{
                            $_SESSION["mensaje2"] = "Error al cambiar la contraseña";
                            header('Location: ../olvidar-contraseña.php');
                        }

                    }
                    else {
                        $_SESSION["mensaje2"] = "Datos incorrectos";
                        header('Location: ../olvidar-contraseña.php');
                    }

                    $stmt->close();
                } else {
                    $_SESSION["mensaje2"] = "Fallo en la conexión con la base de datos";
                    header('Location: ../olvidar-contraseña.php');
                }
            } else {
                $_SESSION["mensaje2"] = "Contraseña invalida";
                header('Location: ../olvidar-contraseña.php');
            }
        } else {
            $_SESSION["mensaje2"] = "Codigo invalido";
            header('Location: ../olvidar-contraseña.php');
        }
    } else {
        $_SESSION["mensaje2"] = "Correo invalido";
        header('Location: ../olvidar-contraseña.php');
    }
} else {
    $_SESSION["mensaje2"] = "Usuario invalido";
    header('Location: ../olvidar-contraseña.php');
}
?>
