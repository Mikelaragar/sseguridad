<?php
session_start();
require_once("config.php");

comprobar_usuario();


if (isset($_POST['id'])){
    $conexion = get_connection();
    if ($conexion){
        $id = $_POST['id'];
        $query = "DELETE FROM  eventos WHERE id_evento = ?";
        $stmt2 = $conexion->prepare($query);
        $stmt2->bind_param("i", $id);
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