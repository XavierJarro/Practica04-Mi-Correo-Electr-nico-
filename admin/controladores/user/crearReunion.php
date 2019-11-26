<?php
session_start();
$codigoui = $_SESSION['cod'];
$usurol = $_SESSION['rol'];
$correoui = $_SESSION['cor'];
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
        <style type="text/css" rel="stylesheet">
            .error {
                color: red;
            }
        </style>
    </head>

    <body>
        <?php
        date_default_timezone_set('America/Guayaquil');
        //incluir conexión a la base de datos
        include '../../../config/conexionBD.php';

        $reu_invitado = isset($_POST["invitado"]) ? mb_strtoupper(trim($_POST["invitado"]), 'UTF-8') : null;

        $codigodes = 0;
        $bus = "SELECT * FROM usuario WHERE usu_correo='$reu_invitado';";
        $resultb = $conn->query($bus);
        if ($resultb->num_rows > 0) {
            while ($row = $resultb->fetch_assoc()) {
                $codigodes = $row["usu_codigo"];
                $rol = $row["usu_rol"];
            }
        }
        $motivo = isset($_POST["motivo"])  ? trim($_POST["motivo"]) : null;
        $observacion =  isset($_POST["observacion"]) ?  mb_strtoupper(trim($_POST["observacion"])) : null;
        $lugar = isset($_POST["lugar"])  ? trim($_POST["lugar"]) : null;
        $coordenada=isset($_POST["coordenada"])  ? trim($_POST["coordenada"]) : null;
        if ($rol == 'admin') {
            echo "<h2> No se puede enviar la reunion a usuarios administradores </h2>";
        } else {
            $sql = "INSERT INTO reunion VALUES(0,NULL,'$lugar','$coordenada',$codigoui,'$codigodes', '$motivo', '$observacion');";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Se ha enviado la invitacion correctamente</p>";
            } else {
                echo "<p class='error'>Error : " . mysqli_error($conn) . "</ p>";
            }
        }
        //cerrar la base de datos
        $conn->close();
        echo "<a href='../../vista/user/index.php'> Regresar </a>";
        ?>
    </body>

    </html>
<?php
} else {
    header("Location: ../../../config/acceso.html");
}
?>