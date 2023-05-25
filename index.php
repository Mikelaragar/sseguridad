<?php
session_start();
if (isset($_SESSION["mensaje"])){
    $error=$_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
}
else{
    $error="";
}
if (isset($_SESSION["men"])){
    $mensaje=$_SESSION["men"];
    unset($_SESSION["men"]);
}
else{
    $mensaje="";
}

if (isset($_SESSION["visitas"])){
    $visitas=$_SESSION["visitas"];
}
else{
    $_SESSION["visitas"]=0;
    $visitas=$_SESSION["visitas"];
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
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>
<header>
    <h1>SISTEMA DE SEGURIDAD</h1>
</header>
<form name="login" action="proc/acceso.php" method="post" class="form1">
    <div class="titulo"><h2>Inicio de sesión</h2></div><br>
    <label for="usu">Usuario:</label>
    <input type="text" id="usu" name="usu" placeholder="Introduce el usuario" required title="Debes rellenar el campo Usuario"><br>
    <label for="pass">Contraseña:</label>
    <input type="password" name="pass" id="pass" placeholder="Introduce la contraseña" required title="Debes rellenar el campo Contraseña"><br>
    <?php
    if ($visitas > 3) {
        $codigo = "";
        for ($i = 0; $i < 6; $i++) {
            $tipo = rand(0, 1); // 0 = número, 1 = letra
            if ($tipo == 0) {
                $codigo .= rand(0, 9);
            } else {
                $codigo .= chr(rand(65, 90)); // letra mayuscula
            }
        }
        echo '<label for="numbers">Codigo de seguridad</label>';
        echo '<input type="text" readonly class="seguridad" id="numbers" name="numbers" value="'.$codigo.'"><br>';
        echo '<label for="number">Repita Codigo de seguridad</label>';
        echo '<input type="text" id="number" name="number" required title="Debes rellenar el codigo de seguridad"><br>';
    }
    ?>
    <section class="red"><p><?=$error?></p></section>
    <section class="verde"><p><?=$mensaje?></p></section>
    <button>Iniciar sesión</button>
    <div class="enlaces">
        <a href="olvidar-contraseña.php" class="enlace">¿Has olvidado la contraseña?</a>
        <a href="formulario-nuevo-usuario.php" class="enlace">Crear cuenta</a>
    </div>
</form>
<footer>PROYECTO ASIR -- MIKEL ARAMBARRI GARCÍA</footer>
<script src="js/script2.js"></script>
</body>
</html>
