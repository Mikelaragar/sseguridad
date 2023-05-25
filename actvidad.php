<?php
session_start();
require_once("proc/config.php");

comprobar_usuario();

$usuario = $_SESSION['usuario'];

if (isset($_SESSION['inicio'])) {
    $inicio = $_SESSION['inicio'];
}

if (isset($_SESSION['fin'])) {
    $fin = $_SESSION['fin'];
}

if (isset($_SESSION['sensores'])) {
    $sensores = $_SESSION['sensores'];
}

if (isset($_SESSION['estado'])) {
    $estado = $_SESSION['estado'];
}

if (isset($_GET['inicio'])) {
    $inicio = $_GET['inicio'];
    $_SESSION['inicio'] = $inicio;
}

if (isset($_GET['fin'])) {
    $fin = $_GET['fin'];
    $_SESSION['fin'] = $fin;
}

if (isset($_GET['sensores'])) {
    $sensores = $_GET['sensores'];
    $_SESSION['sensores'] = $sensores;
}

if (isset($_GET['estado'])) {
    $estado = $_GET['estado'];
    $_SESSION['estado'] = $estado;
}

if (isset($_GET['inicio']) && isset($_GET['fin'])) {
    if ($_GET['inicio'] > $_GET['fin']) {
        echo "Comprueba que ambas fechas estén introducidas. La fecha de inicio no puede ser mayor que la fecha de fin.";
        exit;
    }
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
                <a class="nav-link" href="#">Bienvenido <?php echo $usuario; ?></a>
            </div>
        </nav>
        <div class="dashboard-content  text-center">
            <h2 class="fs-5">ACTIVIDAD</h2>
        </div>
        <div class="col-md-8 mx-auto">
            <form action="actvidad.php" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inicio">Fecha Inicio:</label>
                        <input type="datetime-local" id="inicio" name="inicio" class="form-control" value="<?php echo $inicio; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="fin">Fecha Fin:</label>
                        <input type="datetime-local" id="fin" name="fin" class="form-control" value="<?php echo $fin; ?>">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <label class="text-light bg-dark">Sensores:</label>
                        <?php
                        $mysqli = get_connection();
                        $sql = "SELECT id_sensor, nombre FROM sensores ORDER BY id_sensor;";
                        $resultado = $mysqli->query($sql);

                        if ($resultado) {
                            while ($fila = $resultado->fetch_assoc()) {
                                $id_sensor = $fila["id_sensor"];
                                $nombre = $fila["nombre"];

                                if (isset($_SESSION['sensores']) && !empty($_SESSION['sensores'])) {
                                    $sensores = $_SESSION['sensores'];
                                    $checked = in_array($id_sensor, $sensores) ? 'checked' : '';
                                    echo "<input type='checkbox' id='$nombre' name='sensores[]' value='$id_sensor' class='form-check-input' $checked>";
                                } else {
                                    echo "<input type='checkbox' id='$nombre' name='sensores[]' value='$id_sensor' class='form-check-input'>";
                                }

                                echo "<label for='$nombre' class='form-check-label'> $nombre </label>";
                            }
                            $resultado->free(); // Liberar los resultados de la consulta
                        } else {
                            echo "Error en la consulta: " . $mysqli->error;
                        }

                        ?>
                        <br><br>
                        <label for="estado" class="form-label">Estado:</label>
                        <select name="estado" id="estado">
                            <option value="">Elige el estado</option>
                            <?php
                            $mysqli = get_connection();
                            $sql = "SELECT id_estado, nombre FROM estados";
                            $resultado = $mysqli->query($sql);
                            if ($resultado) {
                                while ($fila = $resultado->fetch_assoc()) {
                                    $id_estado = $fila["id_estado"];
                                    $nombre = $fila["nombre"];
                                    $selected = $id_estado == $estado ? 'selected' : '';
                                    echo "<option value='$id_estado' $selected>$nombre</option>";
                                }
                            } else {
                                echo "Error en la consulta";
                            }
                            $mysqli->close();
                            ?>
                        </select>
                        </select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button id="btn-formulario" class="btn btn-success">BUSCAR</button>
                    </div>
                </div>
            </form><br>
            <?php

            $mysqli = get_connection();


            if (isset($inicio) && strlen($inicio)>0 && isset($fin) || isset($sensores) || isset($estado)) {
                if (isset($_GET['inicio'])) {
                    $inicio = $_GET['inicio'];
                    $_SESSION['inicio'] = $inicio;
                }

                if (isset($_GET['fin'])) {
                    $fin = $_GET['fin'];
                    $_SESSION['fin'] = $fin;
                }

                if (isset($_GET['checkbox'])) {
                    $sensores = $_GET['checkbox'];
                    $_SESSION['sensores'] = $sensores;
                }

                if (isset($_GET['estado'])) {
                    $estado = $_GET['estado'];
                    $_SESSION['estado'] = $estado;
                }

                $sql = "SELECT e.id_evento, e.fecha, s.nombre AS nombre_sensor, es.nombre AS nombre_estado, f.id_foto, f.url AS foto,f.id_foto as id_foto,es.id_estado
        FROM eventos e
        JOIN estados es USING (id_estado)
        LEFT JOIN fotos f USING (id_evento)
        JOIN sensores s USING (id_sensor) WHERE 1=1";

                if (!empty($inicio)) {
                    $sql .= " and e.fecha >= '$inicio'";
                }

                if (!empty($fin)) {
                    $sql .= " and e.fecha <= '$fin'";
                }

                if (!empty($sensores)) {
                    $placeholders = implode(',', array_fill(0, count($sensores), '?'));
                    $sql .= " and s.id_sensor IN ($placeholders)";
                }

                if (!empty($estado)) {
                    $sql .= " and es.id_estado = '$estado'";
                }

                $sql .= " order by 1";

                $stmt = $mysqli->prepare($sql);

                if ($stmt) {
                    if (!empty($sensores)) {
                        $stmt->bind_param(str_repeat("s", count($sensores)), ...$sensores);
                    }

                    $stmt->execute();

                    $resultado = $stmt->get_result();

                    if ($resultado->num_rows > 0) {
                        echo '<div class="col-md-8 mx-auto">';
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="col" class="bg-primary usuarios">Fecha</th>';
                        echo '<th scope="col" class="bg-primary usuarios">Sensor</th>';
                        echo '<th scope="col" class="bg-primary usuarios">Estado</th>';
                        echo '<th scope="col" class="bg-primary usuarios">Foto</th>';
                        echo '<th scope="col" class="bg-primary usuarios">Eliminar</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

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
                            echo "<th>$fecha</th>";
                            echo "<td>$sensor</td>";
                            echo "<td><a class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#cambiarrol' data-bs-id='$id'>$estado</a></td>";
                            if ($foto) {
                                echo "<td>";
                                echo "<form action='ver-foto.php' method='post'>";
                                echo "<input type='hidden' id='id' name='id' value='" . $id_foto . "'>";
                                echo "<button class='btn btn-warning'>Ver</button>";
                                echo "</form>";
                                echo "</td>";

                            }  else {
                                echo "<td>No disponible</td>";
                            }
                            echo "<td><a class='btn btn-sm btn-white' data-bs-toggle='modal' data-bs-target='#eliminaModal'  data-bs-id='$id'><img src='img/borrar.png' alt=''> </a></td>";
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo 'No se encontraron resultados.';
                    }

                    $stmt->close();

                } else {
                    echo 'Error en la consulta.';
                }

                $mysqli->close();
            }
            else{
                echo "Selecciona los párametros de busqueda.";
            }
            ?>


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
                        <form action="proc/cambiar-estado-a.php" method="post">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado:</label>
                                <select name="estado" id="estado">
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
                        <form action="proc/eliminar-evento-a.php" method="post">

                            <input type="hidden" name="id" id="id">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

<script src="js/script3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
