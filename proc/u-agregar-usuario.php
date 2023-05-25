<?php
require_once("config.php");
session_start();
comprobar_usuario();

if (isset($_POST['usu']) && strlen($_POST['usu']) > 0) {
    if (isset($_POST['pass']) && strlen($_POST['pass']) > 0) {
        if (isset($_POST['rol']) && strlen($_POST['rol']) > 0) {
            if (isset($_POST['nombre']) && strlen($_POST['nombre']) > 0) {
                if (isset($_POST['ape1']) && strlen($_POST['ape1']) > 0) {
                    if (isset($_POST['correo']) && strlen($_POST['correo']) > 0 && filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
                        $conexion = get_connection();
                        if ($conexion) {
                            $usuario = $_POST['usu'];
                            $query = "SELECT COUNT(*) AS number FROM usuarios WHERE usuario = ?";
                            $stmt = $conexion->prepare($query);
                            $stmt->bind_param("s", $usuario);
                            $stmt->execute();
                            $resultado = $stmt->get_result();
                            $registro = $resultado->fetch_assoc();
                            $stmt->close();

                            if ($registro["number"] == 0) {
                                $correo = $_POST['correo'];
                                $query2 = "SELECT COUNT(*) AS number FROM usuarios WHERE correo = ?";
                                $stmt2 = $conexion->prepare($query2);
                                $stmt2->bind_param("s", $correo);
                                $stmt2->execute();
                                $resultado2 = $stmt2->get_result();
                                $registro2 = $resultado2->fetch_assoc();
                                $stmt2->close();

                                if ($registro2["number"] == 0) {
                                    $usuario = htmlentities($_POST['usu']);
                                    $password = $_POST['pass'];
                                    $nombre = htmlentities($_POST['nombre']);
                                    $apellido1 = htmlentities($_POST['ape1']);
                                    $apellido2 = htmlentities($_POST['ape2']);
                                    $correo = $_POST['correo'];
                                    $rol = $_POST['rol'];

                                    $codigos = mt_rand(10000, 99999);

                                    // Salt
                                    $salt = "salt_mikel";
                                    // Ciframos la contraseña
                                    $passhash = password_hash($password . $salt, PASSWORD_DEFAULT);

                                    $query3 = "INSERT INTO usuarios (usuario, password, nombre, apellido1, apellido2, id_rol, codigos, correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt3 = $conexion->prepare($query3);
                                    $stmt3->bind_param("ssssssis", $usuario, $passhash, $nombre, $apellido1, $apellido2, $rol, $codigos, $correo);
                                    $stmt3->execute();
                                    $stmt3->close();

                                    if ($stmt3) {
                                        $_SESSION["mensaje"] = "Usuario Creado";
                                        header('location:../crear-usuario.php');
                                    } else {
                                        $_SESSION["mensaje"] = "Error al crear el usuario";
                                        header('location:../crear-usuario.php');
                                    }
                                } else {
                                    $_SESSION["mensaje"] = "Correo ya usado";
                                    header('location:../crear-usuario.php');
                                }
                            } else {
                                $_SESSION["mensaje"] = "Nombre del login ya usado";
                                header('location:../crear-usuario.php');
                            }
                        } else {
                            $_SESSION["mensaje"] = "Error Conexion";
                            header('location:../crear-usuario.php');
                        }
                    } else {
                        $_SESSION["mensaje"] = "Email no valido o no definido";
                        header('location:../crear-usuario.php');
                    }
                } else {
                    $_SESSION["mensaje"] = "Apellido1 no valido o no definido";
                    header('location:../crear-usuario.php');
                }
            } else {
                $_SESSION["mensaje"] = "Nombre no valido o no definido";
                header('location:../crear-usuario.php');
            }
        } else {
            $_SESSION["mensaje"] = "Rol no valido o no definido";
            header('location:../crear-usuario.php');
        }
    } else {
        $_SESSION["mensaje"] = "Contraseña no valido o no definido";
        header('location:../crear-usuario.php');
    }
} else {
    $_SESSION["mensaje"] = "Usuario no valido o no definido";
    header('location:../crear-usuario.php');
}
?>
