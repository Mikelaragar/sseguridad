<?php
require_once ("config.php");
session_start();
    if (isset($_POST['login']) && strlen($_POST['login'])>0){
        if (isset($_POST['pass']) && strlen($_POST['pass'])>0){
            if ($_POST['pass']==$_POST['pass2']){
            if (isset($_POST['nombre']) && strlen($_POST['nombre'])>0){
                if (isset($_POST['apellido1']) && strlen($_POST['apellido1'])>0) {
                    if (isset($_POST['correo']) && strlen($_POST['correo']) > 0 && filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {

                        $conexion = get_connection();
                        if ($conexion) {
                            $usuario = $_POST['login'];
                            $query = "SELECT COUNT(*) AS number FROM usuarios WHERE usuario = ?";
                            $stmt = $conexion->prepare($query);
                            $stmt->bind_param("s", $usuario);
                            $stmt->execute();
                            $resultado = $stmt->get_result();
                            $registro = $resultado->fetch_assoc();
                            $stmt->close();

                            if ($registro["number"] == 0) {
                                $correo= $_POST['correo'];
                                $query2 = "SELECT COUNT(*) AS number FROM usuarios WHERE correo = ?";
                                $stmt2 = $conexion->prepare($query2);
                                $stmt2->bind_param("s", $correo);
                                $stmt2->execute();
                                $resultado2 = $stmt2->get_result();
                                $registro2 = $resultado2->fetch_assoc();
                                $stmt2->close();

                                if ($registro2["number"] == 0) {
                                    $usuario = htmlentities($_POST['login']);
                                    $password =$_POST['pass'];
                                    $nombre = htmlentities($_POST['nombre']);
                                    $apellido1 = htmlentities($_POST['apellido1']);
                                    $apellido2 = htmlentities($_POST['apellido2']);
                                    $correo=$_POST['correo'];
                                    $rol=3;

                                    $codigos = mt_rand(10000, 99999);

                                    //salt
                                    $salt = "salt_mikel";
                                    //ciframos contraseña
                                    $passhash = password_hash($password . $salt, PASSWORD_DEFAULT);

                                    $query3 = "INSERT INTO usuarios (usuario, password, nombre, apellido1, apellido2, id_rol, codigos, correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt3 = $conexion->prepare($query3);
                                    $stmt3->bind_param("ssssssis", $usuario, $passhash, $nombre, $apellido1, $apellido2, $rol, $codigos, $correo);
                                    $stmt3->execute();
                                    $stmt3->close();

                                    if ($stmt3) {
                                        $_SESSION["men"] = "Usuario Creado";
                                        header('location:../index.php');

                                    } else {
                                        $_SESSION["mensaje"] = "Error al crear el usuario";
                                        header('location:../formulario-nuevo-usuario.php');
                                    }

                                } else {
                                    $_SESSION["mensaje"] = "Correo ya usado";
                                    header('location:../formulario-nuevo-usuario.php');
                                }
                            }
                            else{
                                $_SESSION["mensaje"] = "Nombre del login ya usado";
                                header('location:../formulario-nuevo-usuario.php');
                            }
                            }
                            else {
                            $_SESSION["mensaje"] = "Error Conexion";
                                header('location:../formulario-nuevo-usuario.php');
                        }
                    }
                    else {
                        $_SESSION["mensaje"] = "Email no valido o no definido";
                        header('location:../formulario-nuevo-usuario.php');

                    }
                }
                else{
                    $_SESSION["mensaje"]="Apellido1 no valido o no definido";
                    header('location:../formulario-nuevo-usuario.php');

                }

            }
            else{
                $_SESSION["mensaje"]="Nombre no valido o no definido";
                header('location:../formulario-nuevo-usuario.php');

            }
            }
            else{
                $_SESSION["mensaje"]="Contraseñas no coinciden";
                header('location:../formulario-nuevo-usuario.php');
            }

        }
        else{
            $_SESSION["mensaje"]="Contraseña no valido o no definido";
            header('location:../formulario-nuevo-usuario.php');

        }

    }
    else{
        $_SESSION["mensaje"]="Usuario no valido o no definido";
        header('location:../formulario-nuevo-usuario.php');

    }



?>
