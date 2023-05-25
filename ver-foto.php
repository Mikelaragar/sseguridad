<?php
session_start();
require_once("proc/config.php");

comprobar_usuario();
borrar_sesiones();

//CONSULTA DATOS
if (isset($_POST['id']) && strlen($_POST['id']) > 0) {
    $conexion= get_connection();

    if ($conexion){           //la conexion ha sido establecida con exito
        $query="SELECT f.fecha as fecha, f.url as url, s.nombre AS nombre_sensor, es.nombre AS nombre_estado,p.nombre as nombre_placa
        FROM eventos e
         JOIN estados es USING (id_estado)
         LEFT JOIN fotos f USING (id_evento)
         JOIN sensores s USING (id_sensor)
         JOIN placas p USING (id_placa) WHERE id_foto=?";
        $id=$_POST['id'];
        //ejecutar consulta
        $st=$conexion->prepare($query);
        $st->bind_param("s",$id);
        if ($st->execute()){
            $result = mysqli_stmt_get_result($st);
            //permitir leer un registro actual
            $registro = mysqli_fetch_assoc($result);
            $st->close();
            $fecha = $registro['fecha'];
            $url = $registro["url"];
            $nombre_sensor = $registro["nombre_sensor"];
            $nombre_estado = $registro["nombre_estado"];
            $nombre_placa = $registro["nombre_placa"];


        }
        else{
            $_SESSION["error"]="Error en la consulta";
            header('location:fotos.php');
        }

    }
    else{
        $_SESSION["error"]="Error con la base de datos";
        header('location:fotos.php');
    }

}
else{
    $_SESSION["error"]="Error con la base de datos";
    header('location:fotos.php');

}






?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISTEMA DE SEGURIDAD</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<div class="main-container d-flex">
    <div class="sidebar ocultar-movil" id="side_nav">
        <div class="header-box px-3 pt-3 pb-3 d-flex justify-content-between">
            <h1 class="fs-6"><span class="bg-white text-dark rounded shadow px-2 me-2">SISTEMA DE SEGURIDAD</span></h1>
        </div>
        <ul class="list-unstyled px-2">
            <li class="my-2"><a href="muro.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/dashboard.svg" class="me-2">Dashboard</a></li>
            <li class="my-2"><a href="eventos.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/eventos.svg" class="me-2">Eventos</a></li>
            <li class="my-2"><a href="sensores.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/sensores.svg" class="me-2">Sensores</a></li>
            <li class="my-2"><a href="estadisticas.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/estadisticas.svg" class="me-2">Estadísticas</a></li>
            <li class="my-2"><a href="actvidad.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/actividad.svg" class="me-2">Actividad</a></li>
            <li class="my-2"><a href="fotos.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/imagen.svg" class="me-2">Imagenes</a></li>
        </ul>

        <hr>
        <ul class="list-unstyled px-2">
            <li class=""><a href="ajustes.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/ajustes.svg" class="me-2"></i>  Ajustes</a></li>
            <?php
            if ($_SESSION['rol']==1){
                echo '<li class=""><a href="usuarios.php" class="text-decoration-none d-flex px-3 py-2"><img src="img/usuarios.svg" class="me-2"></i> Usuarios</a></li>';
            }
            ?>
            <li class=""><a href="proc/cerrar-sesion.php" class="text-decoration-none d-flex px-3 py-2 "><img src="img/cerrarsesion.svg" class="me-2">  Cerrar Sesión</a></li>
        </ul>
    </div>
    <div class="content">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <button id="btnsidevar" class="btn px-1 py-0 open-btn "><img src="img/menu.svg"></i></button>
                <a class="nav-link" href="#">Bienvenido <?php echo $_SESSION['usuario']; ?> </a>
            </div>
        </nav>
        <div class="dashboard-content  text-center">
            <h2 class="fs-4">VER FOTO <?php echo $fecha; ?></h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h4>Imagen</h4>
                   <img src="<?php echo $url; ?>"><br>
                    <h5>Fecha: <?php echo $fecha; ?></h5>
                    <h5>Placa: <?php echo $nombre_placa; ?></h5>
                    <h5>Sensor: <?php echo $nombre_sensor; ?></h5>
                    <h5>Estado: <?php echo $nombre_estado; ?></h5>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>