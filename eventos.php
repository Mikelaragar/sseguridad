<?php
session_start();
require_once("proc/config.php");
borrar_sesiones();
comprobar_usuario();

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
        <div class="dashboard-content">
            <div class="container d-flex align-items-center">
                <h2 class="fs-5 text-center flex-grow-1">EVENTOS</h2>
                <button id="reloadButton" class="btn btn-info"><img src="img/reset.svg"></button>
            </div>
        </div>

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
            <div class="col-md-8 mx-auto">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-primary">
                <tr>
                    <th scope="col" class="bg-primary usuarios">Fecha</th>
                    <th scope="col" class="bg-primary usuarios">Sensor</th>
                    <th scope="col" class="bg-primary usuarios">Estado</th>
                    <th scope="col" class="bg-primary usuarios">Foto</th>
                    <th scope="col" class="bg-primary usuarios">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $mysqli = get_connection();
                $sql = "SELECT e.id_evento, e.fecha, s.nombre AS nombre_sensor, es.nombre AS nombre_estado, f.id_foto, f.url AS foto,f.id_foto as id_foto,es.id_estado
        FROM eventos e
        JOIN estados es USING (id_estado)
        LEFT JOIN fotos f USING (id_evento)
        JOIN sensores s USING (id_sensor)
        ORDER BY e.fecha desc ;";
                $resultado = $mysqli->query($sql);
                if ($resultado) {
                    while ($fila = $resultado->fetch_assoc()) {
                        $id = $fila["id_evento"];
                        $fecha = $fila["fecha"];
                        $sensor = $fila["nombre_sensor"];
                        $estado = $fila["nombre_estado"];
                        $foto = $fila["foto"];
                        $id_foto = $fila["id_foto"];

                        $id_estado = $fila["id_estado"];
                        if ($id_estado==2){
                            echo '<tr class="tamarillo" ">';
                        }
                        else if ($id_estado==3){
                            echo '<tr class="trojo"">';
                        }
                        else{
                            echo "<tr>";
                        }
                        echo "<td class='usuarios'>$fecha</td>";
                        echo "<td>$sensor</td>";
                        echo "<td><a class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#cambiarrol' data-bs-id='$id'>$estado</a></td>";
                        if ($foto) {
                echo "<td>";
                    echo "<form action='ver-foto.php' method='post'>";
                        echo "<input type='hidden' id='id' name='id' value='" . $id_foto . "'>";
                        echo "<button class='btn btn-success'>Ver</button>";
                        echo "</form>";
                    echo "</td>";

                } else {
                            echo "<td>No disponible</td>";
                        }
                        echo "<td><a class='btn btn-sm btn-white' data-bs-toggle='modal' data-bs-target='#eliminaModal' data-bs-id='$id'><img src='img/borrar.png' alt=''></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Error en la consulta";
                }
                $mysqli->close();
                ?>


                </tbody>
            </table>
        </div>
        </div>
        </div>
            <!-- MODAL EDITAR -->
            <div class="modal fade" id="cambiarrol" tabindex="-1" aria-labelledby="cambiarrolLabel1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cambiarrolLabel1">Cambiar Estado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="proc/cambiar-estado.php" method="post">
                                <div class="form-group">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" required>
                                        <?php
                                        $mysqli = get_connection();
                                        $sql = "SELECT id_estado, nombre FROM estados";
                                        $resultado = $mysqli->query($sql);
                                        if ($resultado) {
                                            while ($fila = $resultado->fetch_assoc()) {
                                                $id_estado = $fila["id_estado"];
                                                $nombre = $fila["nombre"];
                                                echo "<option value='$id_estado'>$nombre</option>";
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
                                    <button type="submit" class="btn btn-success">Cambiar estado</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL ELIMINAR -->
            <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fs-5" id="eliminaModalLabel">Eliminar evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Desea eliminar el evento?
                        </div>

                        <div class="modal-footer">
                            <form action="proc/eliminar-evento.php" method="post">

                                <input type="hidden" name="id" id="id">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>
    <script>
        setInterval(function() {
            location.reload();
        }, 20000);
    </script>
<script src="js/script3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
