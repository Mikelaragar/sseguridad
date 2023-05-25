<?php
require_once ("config.php");
$conexion = get_connection();

if ($conexion){
    $id=1;
    $nom=1;
    $query2 = "UPDATE placas SET est=? where id_placa=?";
    $stmt2 = $conexion->prepare($query2);
    $stmt2->bind_param("ss", $id, $nom);
    $stmt2->execute();
    $stmt2->close();
    if ($stmt2){
        header('Location: ../muro.php');

    }
    else{
        header('Location: ../muro.php');
    }
}
else{
    header('Location: ../muro.php');
}


?>