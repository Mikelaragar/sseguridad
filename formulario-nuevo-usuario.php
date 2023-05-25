<?php
session_start();
if (isset($_SESSION["mensaje"])){
    $error=$_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
}
else{
    $error="";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style2.css">
    <title>SISTEMA DE SEGURIDAD</title>
</head>
<body>
<header>
    <h1>SISTEMA DE SEGURIDAD</h1>
</header>
    <form action="proc/agregar-usuario.php" method="post">
        <section class="rojo"><p><?=$error?></p></section>
        <label for="login">Usuario:<span style="color:red">*</span></label>
        <input type="text" id="login" required placeholder="Introduce el nombre de usuario" name="login" ><br>
        <label for="correo">Correo electronico:<span style="color:red">*</span></label>
        <input type="text" id="correo"  name="correo" placeholder="Introduce tu correo electrónico" required><br>
        <label for="nombre">Nombre:<span style="color:red">*</span></label>
        <input type="text" id="nombre" name="nombre" required placeholder="Introduce tu nombre"><br>
        <label for="apellido1">Apellido1:<span style="color:red">*</span></label>
        <input type="text" id="apellido1" name="apellido1" required placeholder="Introduce tu primer apellido"><br>
        <label for="apellido2">Apellido2:</label>
        <input type="text" id="apellido2" name="apellido2" placeholder="Introduce tu segundo apellido"><br>
        <label for="pass">Contraseña:<span style="color:red">*</span></label>
        <input type="password" name="pass" id="pass" required placeholder="Introduce la contraseña" minlength="5"  maxlength="20"><br>
        <label for="pass2">Repita Contraseña:<span style="color:red">*</span></label>
        <input type="password" name="pass2" id="pass2" required placeholder="Repite la contraseña" minlength="5"  maxlength="20"><br>
    <button>CREAR USUARIO</button>
        <div class="enlaces">
            <a href="index.php" class="enlace">Tengo cuenta</a>
            <a class="enlace" href="mailto:mikelarambarrig@salesianosvillamuriel.com?subject=Asunto del correo&amp;body=Cuerpo del correo">Soporte cuenta</a>
        </div>
</form>
<br><br>
<footer>PROYECTO ASIR -- MIKEL ARAMBARRI GARCÍA</footer>
</body>
</html>
