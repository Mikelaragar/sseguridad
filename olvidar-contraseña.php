<?php
session_start();
if (isset($_SESSION["mensaje2"])){
    $error=$_SESSION["mensaje2"];
    unset($_SESSION["mensaje2"]);
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
<form name="login" action="proc/cambio_contraseña.php" method="post">
    <div class="titulo"><h2>Contraseña olvidada</h2></div><br>
    <label for="usu">Usuario:<span style="color:red">*</span></label>
    <input type="text" id="usu" name="usu" placeholder="Introduce el usuario" required title="Debes rellenar el campo Usuario"><br>
    <label for="correo">Correo:<span style="color:red">*</span></label>
    <input type="text" id="correo" name="correo" placeholder="Introduce el correo" required title="Debes rellenar el campo correo"><br>
    <label for="codigo">Codigo de seguridad:<span style="color:red">*</span></label>
    <input type="text" id="codigo" name="codigo" placeholder="Introduce el codigo de seguridad" required title="Debes rellenar el codigo de seguridad"><br>
    <label for="pass">Nueva Contraseña:<span style="color:red">*</span></label>
    <input type="password" name="pass" id="pass" placeholder="Introduce la contraseña" required title="Debes rellenar el campo Contraseña"><br>
    <section class="red"><p><?=$error?></p></section>
    <section class="verde"><p><?=$mensaje?></p></section>
    <button>Cambiar contraseña</button>
    <div class="enlaces">
        <a href="index.php" class="enlace">Tengo cuenta</a>
        <a class="enlace" href="mailto:mikelarambarrig@salesianosvillamuriel.com?subject=Asunto del correo&amp;body=Cuerpo del correo">Soporte cuenta</a>
    </div>
</form>

<footer>PROYECTO ASIR -- MIKEL ARAMBARRI GARCÍA</footer>
</body>
</html>
