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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a class="nav-link" href="#">Bienvenido <?php echo $usuario; ?>  </a>
            </div>
        </nav>
        <div class="dashboard-content">
            <div class="container d-flex align-items-center">
                <h2 class="fs-5 text-center flex-grow-1">DASHBOARD</h2>
                <button id="reloadButton" class="btn btn-info"><img src="img/reset.svg"></button>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="fs-5">ESTADOS</h2>
                        <?php
                        $mysqli = get_connection();
                        $sql = "SELECT nombre, ufecha FROM placas";
                        $resultado = $mysqli->query($sql);

                        if ($resultado) {
                            while ($fila = $resultado->fetch_assoc()) {
                                $nombre = $fila["nombre"];
                                $ufecha = $fila["ufecha"];

                                echo "<div class='card mb-3'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>Estado Placa: $nombre</h5>";

                                if (strtotime($ufecha) < strtotime('-1 minute')) {
                                    echo "<p class='card-text' style='color: red'>Desconocido. Ultima vez conectado $ufecha</p>";
                                } else {
                                    echo "<p class='card-text' style='color: green'>Activo</p>";
                                }

                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "Error en la consulta";
                        }

                        $mysqli->close();

                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <?php
                                $conexion = get_connection();
                                if ($conexion) {
                                    $query = "SELECT est  from placas where id_placa=1";
                                    $st = $conexion->prepare($query);
                                    if ($st->execute()) {
                                        $result = mysqli_stmt_get_result($st);
                                        $registro = mysqli_fetch_assoc($result);
                                        $numero = $registro["est"];
                                        if ($numero == 1) {
                                            echo "<h5 class='card-title'>Estado Alarma:<span style='color: green'> Encendido</span></h5>";
                                        } else {
                                            echo "<h5 class='card-title'>Estado Alarma: <span style='color: red'>Apagado</span></h5>";
                                        }
                                        $st->close();
                                    }
                                }

                                ?>
                                <a href="proc/a-alarma.php" class="btn btn-success <?php if ($numero == 1) echo 'disabled'; ?>" >Activar</a>
                                <a href="proc/d-alarma.php" class="btn btn-danger <?php if ($numero == 2) echo 'disabled'; ?>"  >Desactivar</a>
                            </div>
                        </div>
                        <h2 class="fs-5">ESTADÍSTICA SENSORES</h2>
                        <canvas id="sensores"></canvas><br>
                        <h2 class="fs-5">ESTADÍSTICA EVENTOS DIAS DE ESTA SEMANA</h2>
                        <canvas id="grafico1"></canvas>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="card-title"><img src="img/eventos.svg"> EVENTOS</h4>
                                <?php
                                $conexion = get_connection();
                                if ($conexion) {
                                    $query = "SELECT COUNT(*) AS numRegistro from eventos";
                                    $st = $conexion->prepare($query);
                                    if ($st->execute()) {
                                        $result = mysqli_stmt_get_result($st);
                                        $registro = mysqli_fetch_assoc($result);
                                        $numero = $registro["numRegistro"];
                                        echo "<h5 class='card-title'>$numero</h5>";
                                        $st->close();
                                    }
                                }
                                ?>
                                <hr>
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $mysqli = get_connection();
                                    $sql = "SELECT COUNT(*) AS cantidad, nombre,es.id_estado
                                        FROM eventos e
                                        JOIN estados es USING (id_estado)
                                        GROUP BY 3;";
                                    $resultado = $mysqli->query($sql);
                                    if ($resultado) {
                                        while ($fila = $resultado->fetch_assoc()) {
                                            $cantidad = $fila["cantidad"];
                                            $nombre = $fila["nombre"];
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
                                            echo "<th>$nombre</th>";
                                            echo "<td>$cantidad</td>";
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
                        <div class="card">
                            <div class="card-body">
                                <h2 class="fs-5">TABLA DE ÚLTIMOS 5 EVENTOS</h2>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-primary">
                                        <tr>
                                            <th scope="col" class="bg-primary usuarios">Fecha</th>
                                            <th scope="col" class="bg-primary usuarios">Sensor</th>
                                            <th scope="col" class="bg-primary usuarios">Estado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $mysqli = get_connection();
                                        $sql = "SELECT e.id_evento, e.fecha, s.nombre AS nombre_sensor, es.nombre AS nombre_estado, f.id_foto as foto,es.id_estado
                                            FROM eventos e
                                            JOIN estados es USING (id_estado)
                                            LEFT JOIN fotos f USING (id_evento)
                                            JOIN sensores s USING (id_sensor)
                                            ORDER BY e.fecha desc;";
                                        $resultado = $mysqli->query($sql);
                                        if ($resultado) {
                                            $contador = 0;
                                            while ($fila = $resultado->fetch_assoc()) {
                                                $contador++;
                                                $id = $fila["id_evento"];
                                                $fecha = $fila["fecha"];
                                                $sensor = $fila["nombre_sensor"];
                                                $estado = $fila["nombre_estado"];
                                                $foto = $fila["foto"];
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
                                                echo "<td>$estado</td>";
                                                echo "</tr>";

                                                if ($contador >= 5) {
                                                    break;
                                                }
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
                    </div>
                </div><br><br>
        </div>
        <script>
            <?php
            //GRAFICA 1
            $mysqli = get_connection();
            $sql = "SELECT s.nombre, COUNT(e.id_sensor) AS cantidad
                FROM sensores s
                LEFT JOIN eventos e using(id_sensor)
                GROUP BY s.nombre";
            $resultado = $mysqli->query($sql);
            $data = array();
            if ($resultado) {
                while ($fila = $resultado->fetch_assoc()) {
                    $data[] = $fila;
                }
            }

            // GRAFICA 2
            $sql1 = "SELECT DATE(e.fecha) AS fecha, COUNT(*) AS cantidad_eventos
                 FROM eventos e
                 WHERE e.fecha >= SYSDATE() - INTERVAL 7 DAY
                 GROUP BY DATE(e.fecha) ASC";
            $resultado1 = $mysqli->query($sql1);
            $data1 = array();
            if ($resultado1) {
                while ($fila1 = $resultado1->fetch_assoc()) {
                    $data1[] = $fila1;
                }
            }

            // Convertir a formato JSON
            $json_data = json_encode($data);
            $json_data1 = json_encode($data1);
            ?>

            // Obtener los datos
            let jsonData = <?php echo $json_data; ?>;
            let labels = jsonData.map(item => item.nombre);
            let values = jsonData.map(item => item.cantidad);

            // Colores
            const colors = [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#AAA',
                '#3ddc00',
                '#ffff00',
                '#808080',
                '#007665',

            ];

            // Crear el gráfico 1
            const ctx = document.getElementById('sensores').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors.slice(0, labels.length),
                        borderColor: 'black',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            let jsonData1 = <?php echo $json_data1; ?>;
            let labels1 = jsonData1.map(item => item.fecha);
            let values1 = jsonData1.map(item => item.cantidad_eventos);

            // Crear el gráfico 2
            const ctx1 = document.getElementById('grafico1').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels1,
                    datasets: [{
                        data: values1,
                        backgroundColor: colors.slice(0, labels1.length),
                        borderColor: 'black',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

        </script>
            <script>
                setInterval(function() {
                    location.reload();
                }, 20000);
            </script>
        <script src="js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

