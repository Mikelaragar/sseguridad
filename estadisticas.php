<?php
session_start();
require_once("proc/config.php");

comprobar_usuario();
borrar_sesiones();
$usuario=$_SESSION['usuario'];
borrar_sesiones();


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <h2 class="fs-5">ESTADÍSTICAS</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6 mb-4">
                    <h2 class="fs-6">ESTADÍSTICA EVENTOS ESTA SEMANA</h2>
                    <div class="chart-container" style="max-width: 350px; margin: 0 auto;">
                        <canvas id="grafico1"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-4">
                    <h2 class="fs-6">ESTADÍSTICA EVENTOS ESTE MES</h2>
                    <div class="chart-container" style="max-width: 350px; margin: 0 auto;">
                        <canvas id="grafico2"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-4">
                    <h2 class="fs-6">ESTADÍSTICA CANTIDAD DE EVENTOS SENSORES</h2>
                    <div class="chart-container" style="max-width: 350px; margin: 0 auto;">
                        <canvas id="sensores"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-4">
                    <h2 class="fs-6">ESTADÍSTICA CANTIDAD DE EVENTOS ESTADO</h2>
                    <div class="chart-container" style="max-width: 350px; margin: 0 auto;">
                        <canvas id="grafico4"></canvas>
                    </div>
                </div>
            </div>
        </div>





        <script>
    <?php
    $mysqli = get_connection();
    //GRAFICA 3
    $sql = "SELECT s.nombre,count(*) as cantidad
            FROM eventos e
            left join sensores s USING (id_sensor)
            group by 1";
    $resultado = $mysqli->query($sql);
    $data = array();
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $data[] = $fila;
        }
    }
    // GRAFICA 4
    $sql1 = "SELECT s.nombre, COUNT(*) AS cantidad_eventos
            FROM eventos e
            LEFT JOIN estados s USING (id_estado)
            GROUP BY s.nombre";
    $resultado1 = $mysqli->query($sql1);
    $data1 = array();
    if ($resultado1) {
        while ($fila1 = $resultado1->fetch_assoc()) {
            $data1[] = $fila1;
        }
    }
    // GRAFICA 1
    $sql2 = "SELECT s.nombre, COUNT(e.id_sensor) AS cantidad
                FROM sensores s
                LEFT JOIN eventos e using(id_sensor)
                WHERE e.fecha >= SYSDATE() - INTERVAL 7 DAY
                GROUP BY s.nombre";
    $resultado2 = $mysqli->query($sql2);
    $data2 = array();
    if ($resultado2) {
        while ($fila2 = $resultado2->fetch_assoc()) {
            $data2[] = $fila2;
        }
    }
    // GRAFICA 2
    $sql3 = "SELECT s.nombre, COUNT(e.id_sensor) AS cantidad
                FROM sensores s
                LEFT JOIN eventos e using(id_sensor)
                WHERE e.fecha >= SYSDATE() - INTERVAL 30 DAY
                GROUP BY s.nombre";
    $resultado3 = $mysqli->query($sql3);
    $data3 = array();
    if ($resultado3) {
        while ($fila3 = $resultado3->fetch_assoc()) {
            $data3[] = $fila3;
        }
    }

    // Convertir a formato JSON
    $json_data = json_encode($data);
    $json_data1 = json_encode($data1);
    $json_data2 = json_encode($data2);
    $json_data3 = json_encode($data3);
    ?>

    // Obtener los datos del servidor
    const jsonData = <?php echo $json_data; ?>;
    const labels = jsonData.map(item => item.nombre);
    const values = jsonData.map(item => item.cantidad);

    // Colores
    const colors = [
        '#FF6384',
        '#36A2EB',
        '#FFCE56',
        '#AAA',
    ];
    const colors2 = [
        '#3ddc00',
        '#808080',
        '#007665',
        '#ffff00',
    ];

    // GRAFICA 3
    const ctx = document.getElementById('sensores').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad de Eventos',
                data: values,
                backgroundColor: colors.slice(0, labels.length),
                borderColor: 'black',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });


    //GRAFICA 4
    const jsonData1 = <?php echo $json_data1; ?>;
    const labels1 = jsonData1.map(item => item.nombre);
    const values1 = jsonData1.map(item => item.cantidad_eventos);

    const ctx1 = document.getElementById('grafico4').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: labels1,
            datasets: [{
                label: 'Cantidad de Eventos',
                data: values1,
                backgroundColor: colors2.slice(0, labels1.length),
                borderColor: 'black',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    //GRAFICA 1
    const jsonData2 = <?php echo $json_data2; ?>;
    const labels2 = jsonData2.map(item => item.nombre);
    const values2 = jsonData2.map(item => item.cantidad);



    const ctx2 = document.getElementById('grafico1').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: labels2,
            datasets: [{
                label: 'Cantidad de Eventos',
                data: values2,
                backgroundColor: colors2.slice(0, labels2.length),
                borderColor: 'black',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    //GRAFICA 2
    const jsonData3 = <?php echo $json_data3; ?>;
    const labels3 = jsonData3.map(item => item.nombre);
    const values3 = jsonData3.map(item => item.cantidad);

    const ctx3 = document.getElementById('grafico2').getContext('2d');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: labels3,
            datasets: [{
                label: 'Cantidad de Eventos',
                data: values3,
                backgroundColor: colors.slice(0, labels3.length),
                borderColor: 'black',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>


<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>