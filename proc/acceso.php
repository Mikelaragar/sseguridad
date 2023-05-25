<?php

require_once ("config.php");
session_start();


if(isset($_POST['usu']) &&  isset($_POST['pass'])){
    $usuario=htmlentities($_POST['usu']);
    $password =htmlentities($_POST['pass']) ;



//conexion
    $conexion= get_connection();


    if ($conexion){           //la conexion ha sido establecida con exito
        $query="SELECT COUNT(*) AS numRegistro,usuario,password,id_rol,id_usuario from usuarios WHERE usuario=?";

        //ejecutar consulta
        $st=$conexion->prepare($query);
        $st->bind_param("s",$usuario);
        $st->execute();
        $result = mysqli_stmt_get_result($st);
        //permitir leer un registro actual
        $registro = mysqli_fetch_assoc($result);
        $st->close();



        $salt = "salt_mikel";
        if ($registro["numRegistro"]==1 &&  password_verify($password.$salt, $registro["password"])){

            //$_SESSION["pass"]=$password;
            $_SESSION["auth"]=session_id();

            $usuario=$registro["usuario"];
            $_SESSION["usuario"]=$usuario;
            $rol=$registro["id_rol"];
            $_SESSION["rol"]=$rol;
            $id=$registro["id_usuario"];
            $_SESSION["id"]=$id;

            if ($registro["id_rol"]!=3){
                if ($_SESSION["visitas"]<3) {
                    $_SESSION["visitas"] = 0;
                    header('location:../muro.php');
                }

                else{
                    if(isset($_POST['numbers']) && isset($_POST['number'])){

                        if ($_POST['numbers']!=$_POST['number']){
                            $_SESSION["mensaje"]="Error codigo seguridad no iguales";
                            header('location:../index.php');
                        }
                        else{
                            $_SESSION["visitas"] = 0;
                            header('location:../muro.php');
                        }
                    }
                    else{
                        $_SESSION["mensaje"]="Error codigo seguridad";
                        header('location:../index.php');

                    }

                }
            }
            else{
                $_SESSION["mensaje"]="Cuenta Deshabilitada";
                header('location:../index.php');

            }
        }
        else{
            if (isset($_SESSION["visitas"])){
                $visitas=$_SESSION["visitas"];
                $visitas++;
                $_SESSION["visitas"]=$visitas;
            }
            else{
                $_SESSION["visitas"]=1;
            }
            $_SESSION["mensaje"]="Usuario o contraseñas incorrecto";
            header('location:../index.php');
        }

    }
    else{
        $_SESSION["mensaje"]="Error con la base de datos";
        header('location:../index.php');
    }


}

?>