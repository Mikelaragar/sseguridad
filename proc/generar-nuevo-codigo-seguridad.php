<?php
require_once ("config.php");
session_start();
comprobar_usuario();

    $mysqli=get_connection();
    $id=$_SESSION["id"];
    $codigos = mt_rand(10000, 99999);
    $sql = "UPDATE usuarios SET codigos = ? WHERE id_usuario = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $codigos, $id);
    if ($stmt->execute()){
        header("location:../ajustes.php");
    }
    else{
        $_SESSION["error"]="Error al cambiar el numero de seguridad";
        header("location:../ajustes.php");
    }


?>
