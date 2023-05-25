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
                <a class="nav-link" href="#">Bienvenido <?php echo $usuario; ?></a>
            </div>
        </nav>
        <div class="dashboard-content  text-center">
            <h2 class="fs-4">CREAR USUARIO</h2>
        </div>
        <?php
        if (isset($_SESSION["mensaje"])) {
            echo '<section><p class="text-danger">' . $_SESSION["mensaje"] . '</p></section>';
            unset($_SESSION["mensaje"]);
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto w-80">
                    <form class="row g-3" method="post" action="proc/u-agregar-usuario.php">
                        <div class="col-md-6">
                            <label for="usu" class="form-label">Usuario<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="usu" name="usu" placeholder="Introduce el usuario" required title="Debes rellenar el Usuario">
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce el nombre" required title="Debes rellenar el nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="ape1" class="form-label">Apellido1<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="ape1" name="ape1" placeholder="Introduce el apellido1" required title="Debes rellenar el apellido1">
                        </div>
                        <div class="col-md-6">
                            <label for="ape2" class="form-label">Apellido2</label>
                            <input type="text" class="form-control" id="ape2" name="ape2" placeholder="Introduce el apellido2"  title="Debes rellenar el apellido2">
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Introduce el correo"  title="Debes rellenar el correo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pass" class="form-label">Contraseña<span style="color:red">*</span></label>
                            <input type="password" class="form-control" minlength="5" maxlength="20" id="pass" name="pass" required placeholder="Introduce la nueva contraseña">
                        </div>
                        <div class="text-center">
                            <label for="rol" class="form-label">Rol usuario:</label>
                            <select name="rol" id="rol" required>
                                <?php
                                $mysqli = get_connection();
                                $sql = "SELECT id_rol, nombre FROM roles";
                                $resultado = $mysqli->query($sql);
                                if ($resultado) {
                                    while ($fila = $resultado->fetch_assoc()) {
                                        $id_rol = $fila["id_rol"];
                                        $nombre = $fila["nombre"];
                                        echo "<option value='$id_rol'>$nombre</option>";
                                    }
                                } else {
                                    echo "Error en la consulta";
                                }
                                $mysqli->close();
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>