<?php

//PARAMETROS PARA CONECTARME A LA BASE DE DATOS

function get_connection() {
    $host = 'localhost';
    $db = 'sseguridad';
    $user = 'mikel';
    $pass = 'mikel';
    $conn = new mysqli($host, $user, $pass, $db);

    // PRUEBAS SI ESTABLEZCO CONEXION CON LA BD
    if (!$conn->connect_errno) {
        return $conn;
    } else {
        $n_error = $conn->connect_errno;
        $mensaje = $conn->connect_error;
        echo "No se ha podido conectar con éxito<br>";
        printf("Error %d: %s", $n_error, $mensaje);
        exit;
    }
}


function disconnect($conn) {
    if ($conn){
        $conn->close();
    }
}

function comprobar_usuario()
{
    $mysqli = get_connection();
    $id_usuario = $_SESSION['id'];
    $usuario =$_SESSION['usuario'];
    $rol =$_SESSION['rol'];
    $sql = "SELECT count(*) as num from usuarios WHERE usuario='$usuario' and id_usuario='$id_usuario' and id_rol='$rol'";
    $resultado = $mysqli->query($sql);
    $registro = mysqli_fetch_assoc($resultado);
    if (!$registro["num"]==1 || $rol==3) {
        $_SESSION["mensaje"]="Inicia sesion para entrar";
        header('location:index.php');
    }
}
function borrar_sesiones(){
unset($_SESSION["inicio"]);
unset($_SESSION["fin"]);
unset($_SESSION["sensores"]);
unset($_SESSION["estado"]);

}