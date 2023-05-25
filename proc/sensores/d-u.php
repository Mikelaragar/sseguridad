<?php
require_once ("../config.php");
$conexion = get_connection();

if ($conexion){
    $id=2;
    $nom=2;
    $query2 = "UPDATE sensores SET est=? where id_sensor=?";
    $stmt2 = $conexion->prepare($query2);
    $stmt2->bind_param("ss", $id, $nom);
    $stmt2->execute();
    $stmt2->close();
    if ($stmt2){
        header('Location: ../../sensores.php');

    }
    else{
        header('Location: ../../sensores.php');
    }
}
else{
    header('Location: ../../sensores.php');
}


?>