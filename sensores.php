<?php
session_start();
require_once("proc/config.php");

comprobar_usuario();
borrar_sesiones();
$usuario=$_SESSION['usuario'];



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
                <a class="nav-link" href="#">Bienvenido <?php echo $usuario; ?> </a>
            </div>
        </nav>
        <div class="dashboard-content  text-center">
            <h2 class="fs-5">SENSORES</h2>
        </div>
        <?php
        if (isset($_SESSION["error"])) {
            echo '<section class="container"><p class="p-1 mb-1 bg-danger text-white">' . $_SESSION["error"] . '</p></section>';
            unset($_SESSION["error"]);
        }
        ?>
        <?php
        if (isset($_SESSION["mensaje"])) {
            echo '<section class="container"><p class="p-1 mb-1 bg-success text-white">' . $_SESSION["mensaje"] . '</p></section>';
            unset($_SESSION["mensaje"]);
        }
        ?>
        <div class="col-md-11 mx-auto">
            <div class="card mb-3">
                <div class="card-body">
                    <?php
                    $conexion = get_connection();
                    if ($conexion) {
                        $query = "SELECT est FROM sensores WHERE id_sensor = 1";
                        $st = $conexion->prepare($query);
                        if ($st->execute()) {
                            $result = mysqli_stmt_get_result($st);
                            $registro = mysqli_fetch_assoc($result);
                            $numero = $registro["est"];
                            if ($numero == 1) {
                                echo "<h5 class='card-title'>Estado Sensor Pir: <span style='color: green'>Encendido</span></h5>";
                            } else {
                                echo "<h5 class='card-title'>Estado Sensor Pir: <span style='color: red'>Apagado</span></h5>";
                            }
                            $st->close();
                        }
                    }
                    ?>
                    <a href="proc/sensores/a-pir.php" class="btn btn-success <?php if ($numero == 1) echo 'disabled'; ?>">Activar</a>
                    <a href="proc/sensores/d-pir.php" class="btn btn-danger <?php if ($numero == 2) echo 'disabled'; ?>">Desactivar</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <?php
                    $conexion = get_connection();
                    if ($conexion) {
                        $query = "SELECT est,descripcion FROM sensores WHERE id_sensor = 2";
                        $st = $conexion->prepare($query);
                        if ($st->execute()) {
                            $result = $st->get_result();
                            $registro = $result->fetch_assoc();
                            $numero2 = $registro["est"];
                            $des = $registro["descripcion"];
                            if ($numero2 == 1) {
                                echo "<h5 class='card-title'>Estado Sensor Ultrasonico: <span style='color: green'>Encendido</span></h5>";
                                ?>
                                <form action="proc/distancia.php" method="post">
                                    <label for="distancia">Distancia CM:</label>
                                    <input type="text" name="distancia" id="distancia" value="<?php echo $des; ?>">
                                    <button class="btn btn-dark">Cambiar</button>
                                </form><br>
                                <?php
                            } else {
                                echo "<h5 class='card-title'>Estado Sensor Ultrasonico: <span style='color: red'>Apagado</span></h5>";
                            }
                            $st->close();
                        }
                    }
                    ?>


                    <a href="proc/sensores/a-u.php" class="btn btn-success <?php if ($numero2 == 1) echo 'disabled'; ?>">Activar</a>
                    <a href="proc/sensores/d-u.php" class="btn btn-danger <?php if ($numero2 == 2) echo 'disabled'; ?>">Desactivar</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <?php
                    $conexion = get_connection();
                    if ($conexion) {
                        $query = "SELECT est FROM sensores WHERE id_sensor = 3";
                        $st = $conexion->prepare($query);
                        if ($st->execute()) {
                            $result = mysqli_stmt_get_result($st);
                            $registro = mysqli_fetch_assoc($result);
                            $numero3 = $registro["est"];
                            if ($numero3 == 1) {
                                echo "<h5 class='card-title'>Estado Sensor Microfono: <span style='color: green'>Encendido</span></h5>";
                            } else {
                                echo "<h5 class='card-title'>Estado Sensor Microfono: <span style='color: red'>Apagado</span></h5>";
                            }
                            $st->close();
                        }
                    }
                    ?>
                    <a href="proc/sensores/a-m.php" class="btn btn-success <?php if ($numero3 == 1) echo 'disabled'; ?>">Activar</a>
                    <a href="proc/sensores/d-m.php" class="btn btn-danger <?php if ($numero3 == 2) echo 'disabled'; ?>">Desactivar</a>
                </div>
            </div>
        </div>


    </div>
</div>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>