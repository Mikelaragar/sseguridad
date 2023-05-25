<?php
require_once("config.php");
session_start();

comprobar_usuario();

if (isset($_POST['usu']) && strlen($_POST['usu']) > 0) {
    if (isset($_POST['rol'])) {
        if (isset($_POST['nombre']) && strlen($_POST['nombre']) > 0) {
            if (isset($_POST['ape1']) && strlen($_POST['ape1']) > 0) {
                if (isset($_POST['correo']) && strlen($_POST['correo']) > 0 && filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
                    $conexion = get_connection();
                    if ($conexion) {
                        $usuariof = htmlentities($_POST['usu']);
                        $nombre = htmlentities($_POST['nombre']);
                        $apellido1 = htmlentities($_POST['ape1']);
                        $apellido2 = htmlentities($_POST['ape2']);
                        $correo = $_POST['correo'];
                        $rol = $_POST['rol'];
                        if ($usuariof !== $_POST['ousu']) {
                            $query = "SELECT COUNT(*) AS number FROM usuarios WHERE usuario = ?";
                            $stmt = $conexion->prepare($query);
                            $stmt->bind_param("s", $usuario);
                            $stmt->execute();
                            $resultado = $stmt->get_result();
                            $registro = $resultado->fetch_assoc();
                            $stmt->close();

                            if ($registro["number"] > 0) {
                                $_SESSION["error"] = "El nombre de usuario ya está en uso";
                                header('Location: ../ajustes.php');
                            }
                        } else if ($correo !== $_POST['ocorreo']) {
                            $query = "SELECT COUNT(*) AS number FROM usuarios WHERE correo = ?";
                            $stmt = $conexion->prepare($query);
                            $stmt->bind_param("s", $correo);
                            $stmt->execute();
                            $resultado = $stmt->get_result();
                            $registro = $resultado->fetch_assoc();
                            $stmt->close();

                            if ($registro["number"] > 0) {
                                $_SESSION["error"] = "El correo electrónico ya está en uso";
                                header('Location: ../ajustes.php');
                            }
                        }

                        $query = "UPDATE usuarios SET ";
                        $campos = array();

                        if ($usuariof !== $_POST['ousu']) {
                            $campos[] = "usuario = '$usuariof'";
                        }

                        if ($nombre !== $_POST['onombre']) {
                            $campos[] = "nombre = '$nombre'";
                        }

                        if ($correo !== $_POST['ocorreo']) {
                            $campos[] = "correo = '$correo'";
                        }

                        if ($apellido1 !== $_POST['oape1']) {
                            $campos[] = "apellido1 = '$apellido1'";
                        }

                        if ($apellido2 !== $_POST['oape2']) {
                            $campos[] = "apellido2 = '$apellido2'";
                        }

                        if ($rol) {
                            $campos[] = "id_rol = '$rol'";
                        }

                        if (!empty($campos)) {
                            $query .= implode(", ", $campos);
                            $query .= " WHERE usuario = ?";
                            $stmt = $conexion->prepare($query);
                            $stmt->bind_param("s", $_POST['ousu']);
                            $stmt->execute();
                            $stmt->close();
                            if ($_POST['ousu']==$_SESSION['usuario']){
                                $_SESSION['usuario']=$_POST['usu'];
                            }
                            $_SESSION["mensaje"] = "Datos del usuario actualizados";
                            header('Location: ../usuarios.php');
                        } else {
                            $_SESSION["error"] = "Error: datos del usuario no actualizados";
                            header('Location: ../editar-usuario.php');
                        }
                    } else {
                        $_SESSION["error"] = "Error con la conexión";
                        header('Location: ../editar-usuario.php');
                    }
                } else {
                    $_SESSION["mensaje"] = "Email no válido o no definido";
                    header('Location: ../editar-usuario.php');
                }
            } else {
                $_SESSION["mensaje"] = "Apellido1 no válido o no definido";
                header('Location: ../editar-usuario.php');
            }
        } else {
            $_SESSION["mensaje"] = "Nombre no válido o no definido";
            header('Location: ../editar-usuario.php');
        }
    } else {
        $_SESSION["mensaje"] = "Rol no válido o no definido";
        header('Location: ../editar-usuario.php');
    }
} else {
    $_SESSION["mensaje"] = "Usuario no válido o no definido";
    header('Location: ../editar-usuario.php');
}
?>
