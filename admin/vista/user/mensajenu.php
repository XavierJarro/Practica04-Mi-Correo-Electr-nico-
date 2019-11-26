<?php
session_start();
$codigoui = $_SESSION['cod'];
$nombresui = explode(" ", $_SESSION['nom']);
$apellidosui =  explode(" ", $_SESSION['ape']);
$correoui = $_SESSION['cor'];
$usurol = $_SESSION['rol'];
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === FALSE) {
    header("Location: /correo/public/vista/login.html");
}
if ($usurol == 'user') {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Correo Electronico</title>
        <link href="../../../public/vista/css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php
        include '../../../config/conexionBD.php';
        $sqlu = "SELECT * FROM usuario WHERE usu_codigo='$codigoui';";
        $resultu = $conn->query($sqlu);
        $row = $resultu->fetch_assoc();
        $foto = $row["usu_foto"];
        ?>
        <header class="cabis">
            <h2>
                Mensaje Nuevo 
            </h2>
            <nav class="navi">
                <ul id="menu">
                    <li><a href="#"> <img id="imagen" src="data:image/*;base64,<?php echo base64_encode($foto); ?>">
                            <?php echo $nombresui[0] . ' ' . $apellidosui[0] ?></a>
                        <ul>
                            <li><a href="../../../config/cerrarSesion.php"> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav class='naveg'>
                <ul>
                    <li> <a href='index.php'>Inicio </a> </li>
                    <li> <a href='mensajenu.php'>Nuevo Mensaje</a> </li>
                    <li> <a href='mensajesen.php'>Mensajes Enviados</a> </li>
                    <li> <a href='cuenta.php'>Mi Cuenta</a> </li>
                </ul>
            </nav>
        </header>
        <form id="formulario01" method="POST" action="../../controladores/user/crearCorreo.php">
            <div class="parte1">
                <label for="destinatario">Correo Destinatario</label>
                <input type="text" id="destinatario" name="destinatario" value=""/>
                <br>
                <label for="asunto"> Asunto</label>
                <input type="text" id="asunto" name="asunto" value=""/>
                <br>
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje"></textarea>
                <br>
                <input type="submit" id="crear" name="crear" value="Enviar" />
                <input type="reset" id="cancelar" name="cancelar" value="Cancelar" />
            </div>
    </body>

    </html>
<?php
} else {
    header("Location: ../../../config/acceso.html");
}
$conn->close();
?>