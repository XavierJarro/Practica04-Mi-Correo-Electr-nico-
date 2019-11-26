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
        <title>Correo Electronico</title>
        <link href="../../../public/vista/css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <header class="cab">
            <h1>Comprobación de Borrado</h1>
        </header>
        <?php
        include '../../../config/conexionBD.php';
        #Eliminado Completo
        #$sql = "DELETE FROM usuario WHERE usu_codigo=$codigo;";
        date_default_timezone_set('America/Guayaquil');
        $codigo = $_POST["codigo"];
        $fecha = date('Y-m-d H:i:s', time());

        #Eliminado Lógico
        $sql = "UPDATE correo SET cor_eliminado='S', cor_fecha_modificacion='$fecha' WHERE cor_codigo=$codigo;";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Se han borrado los datos personales correctamemte !!!</p>";
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