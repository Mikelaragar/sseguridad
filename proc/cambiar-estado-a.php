<?php
session_start();
require_once("config.php");

comprobar_usuario();

if (isset($_POST['id']) && strlen($_POST['id'])>0){
    if (isset($_POST['estado']) && strlen($_POST['estado']) > 0){


        $conexion = get_connection();
        if ($conexion){
            $estado= $_POST['estado'];
            $id = $_POST['id'];
            $query = "UPDATE eventos SET id_estado = ? WHERE id_evento = ?";
            $stmt2 = $conexion->prepare($query);
            $stmt2->bind_param("si", $estado, $id);

            if ($stmt2->execute()) {
                header("location:../actvidad.php");
            } else {
                header("location:../actvidad.php");
            }

        }
        else{
            header("location:../actvidad.php");

        }
    }
    else{
        header("location:../actvidad.php");
    }
}
else{
    header("location:../eventos.php");
}
