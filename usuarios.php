<?php
session_start();
require_once("proc/config.php");

comprobar_usuario();
borrar_sesiones();
$usuario=$_SESSION['usuario'];
if ($_SESSION["rol"] > 1) {
    header('Location: muro.php');
    exit();
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
                <a class="nav-link" href="#">Bienvenido <?php echo $usuario; ?> </a>
            </div>
        </nav>
        <div class="dashboard-content text-center">
            <h2 class="fs-4">USUARIOS</h2>
            <div class="container">
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
                <div class="text-end">
                    <a href="crear-usuario.php" class="btn btn-warning ms-auto"><img src='img/plus-square.svg'> Crear usuario</a>
                </div><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="bg-primary usuarios">Usuario</th>
                            <th scope="col" class="bg-primary usuarios">Nombre</th>
                            <th scope="col" class="bg-primary usuarios">Apellido1</th>
                            <th scope="col" class="bg-primary usuarios">Email</th>
                            <th scope="col" class="bg-primary usuarios">Rol</th>
                            <th scope="col" class="bg-primary usuarios">Contraseña</th>
                            <th scope="col" class="bg-primary usuarios">Editar</th>
                            <th scope="col" class="bg-primary usuarios">Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            $mysqli=get_connection();
                            $sql = "SELECT roles.nombre AS nombre_rol,usuarios.id_usuario,usuarios.usuario,usuarios.nombre, usuarios.apellido1, usuarios.correo
                            FROM usuarios
                            JOIN roles ON usuarios.id_rol = roles.id_rol
                            order by nombre_rol;";
                            $resultado = $mysqli->query($sql);
                            if($resultado){
                                $fila = $resultado->fetch_assoc();
                                while ($fila){
                                    $usuariof=$fila["usuario"];
                                    $nombre=$fila["nombre"];
                                    $apellido1=$fila["apellido1"];
                                    $correo=$fila["correo"];
                                    $rol=$fila["nombre_rol"];
                                    $id=$fila["id_usuario"];

                                    echo "<tr>";
                                    echo "<td class='usuarios'>$usuariof</td>";
                                    echo "<td>$nombre</td>";
                                    echo "<td>$apellido1</td>";
                                    echo "<td>$correo</td>";
                                    echo "<td><a class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#cambiarrol' data-bs-id='$id'>$rol</a></td>";
                                    echo "<td><a class='btn btn-sm btn-white' data-bs-toggle='modal' data-bs-target='#cambiarpass' data-bs-id='$id'><img src='img/pass.svg' alt=''></a></td>";
                                    echo "<td><form method='post' action='editar-usuario.php'>
                                        <input type='hidden' name='id' value='$id'>
                                        <button type='submit' class='btn btn-sm btn-white'><img src='img/editar.png' alt=''></button></form></td>";

                                    echo "<td><a class='btn btn-sm btn-white' data-bs-toggle='modal' data-bs-target='#eliminaModal'  data-bs-id='$id'><img src='img/borrar.png' alt=''> </a></td>";
                                    echo "</tr>";
                                    $fila=$resultado->fetch_assoc();
                                }
                            }
                            else{
                                echo "Error en la consulta";
                            }
                            $mysqli->close();

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <!-- MODAL ELIMINAR -->
        <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="eliminaModalLabel">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Desea eliminar el usuario?
                    </div>

                    <div class="modal-footer">
                        <form action="proc/u-eliminar-usuario.php" method="post">

                            <input type="hidden" name="id" id="id">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <!-- MODAL CONTRASEÑA -->
        <div class="modal fade" id="cambiarpass" tabindex="-1" aria-labelledby="cambiarpassLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarpassLabel1">Cambiar Contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="proc/u-cambio-contraseña.php" method="post">
                            <label for="newpass" class="form-label">Nueva contraseña</label>
                            <input type="password" name="newpass" class="form-control" required id="newpass" minlength="5"  maxlength="20" placeholder="Introduce la nueva contraseña">
                            <input type="hidden" name="id" id="id">
                    </div>

                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Cambiar Contraseña</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <!-- MODAL EDITAR -->
        <div class="modal fade" id="cambiarrol" tabindex="-1" aria-labelledby="cambiarrolLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarrolLabel1">Cambiar ROL</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="proc/u-cambiar-rol.php" method="post">
                            <div class="form-group">
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
                                <input type="hidden" name="id" id="id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Cambiar rol</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>