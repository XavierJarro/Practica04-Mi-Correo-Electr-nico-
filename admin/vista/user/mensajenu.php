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
        <title>REUNIONES</title>
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php
        include '../../../config/conexionBD.php';
        $sqlu = "SELECT * FROM usuario WHERE usu_codigo='$codigoui';";
        $resultu = $conn->query($sqlu);
        $row = $resultu->fetch_assoc();        
        ?>
        <header class="cabis">
            <h2>
                Reunion Nueva
            </h2>
            <nav class="navi">
                <ul id="menu">
                    <li><a><?php echo $nombresui[0] . ' ' . $apellidosui[0] ?></a>
                        <ul>
                            <li><a href="../../../config/cerrarSesion.php"> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav class='naveg'>
                <ul>
                    <li> <a href='index.php'>Inicio </a> </li>
                    <li> <a href='mensajenu.php'>Nueva Reunion</a> </li>
                    <li> <a href='mensajesen.php'>Reuniones Enviados</a> </li>
                    <li> <a href='cuenta.php'>Mi Cuenta</a> </li>
                </ul>
            </nav>
        </header>
        <form id="formulario01" method="POST" action="../../controladores/user/crearReunion.php">
            <div class="parte1">
                <label for="invitado">Correo Invitado</label>
                <input type="text" id="invitado" name="invitado" value=""/>
                <br>
                <label for="motivo"> Motivo</label>
                <input type="text" id="motivo" name="motivo" value=""/>
                <br>                
                <label for="lugar"> Lugar</label>
                <input type="text" id="lugar" name="lugar" value=""/>
                <br>
                <label for="coordenada"> Coordenada</label>
                <input type="text" id="coordenada" name="coordenada" value=""/>
                <br>
                <label for="observacion">Observacion</label>
                <textarea id="observacion" name="observacion"></textarea>
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