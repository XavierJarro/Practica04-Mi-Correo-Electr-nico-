<?php
session_start();
$codigoui = $_SESSION['cod'];
$usurol = $_SESSION['rol'];
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === FALSE) {
    header("Location: /correo/public/vista/login.html");
}
if ($usurol == 'admin') {
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>REUNIONES</title>
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <header class="cab">
            <h1>Comprobación de Borrado</h1>
        </header>
        <?php
        include '../../../config/conexionBD.php';
        #Eliminado Completa
        
        date_default_timezone_set('America/Guayaquil');
        $codigo = $_GET["codigo"];
        #Eliminado Lógico
        $sql = "DELETE FROM reunion WHERE reu_codigo=$codigo;";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Se han borrado la reunion correctamemte</p>";
        } else {
            if ($conn->errno == 1062) {
                echo "<p class='error'> La persona con la cedula $cedula no se encuentra registrada en el sistema </p>";
            } else {
                echo "<p class='error'>Error : " . mysqli_error($conn) . "</ p>";
            }
        }
        //cerrar la base de datos
        $conn->close();
        echo "<a href='../../vista/admin/index.php'> Regresar </a>";
        ?>
    </body>

    </html>
<?php
} else {
    header("Location: ../../../config/acceso.html");
}
?>