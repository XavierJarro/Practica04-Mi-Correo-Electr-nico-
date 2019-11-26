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
        <header class="cabis">
            <h2>
                Lectura Reunion
            </h2>
        </header>
        <?php
        include '../../../config/conexionBD.php';
        if ($_GET['url'] == '/correo/admin/vista/user/index.php') {
            $sql = "SELECT * FROM reunion WHERE reu_codigo=$_GET[codigo];";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $codigo = $row["reu_codigo"];
                    $motivo = $row["reu_motivo"];
                    $observacion = $row["reu_observacion"];                    
                    $lugar = $row["reu_lugar"];
                    $coordenada= $row["reu_coordenada"];
                    $correorem = "";
                    $bus = "SELECT * FROM usuario WHERE usu_codigo='$row[reu_invitado]';";
                    $resultb = $conn->query($bus);
                    if ($resultb->num_rows > 0) {
                        while ($row = $resultb->fetch_assoc()) {
                            $correorem = $row["usu_correo"];
                        }
                    }
                }
            }
        } else {
            $sql = "SELECT * FROM reunion WHERE reu_codigo=$_GET[codigo];";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $codigo = $row["reu_codigo"];
                    $motivo = $row["reu_motivo"];
                    $observacion = $row["reu_observacion"];                    
                    $lugar = $row["reu_lugar"];
                    $coordenada= $row["reu_coordenada"];
                    $correorem = "";
                    $bus = "SELECT * FROM usuario WHERE usu_codigo='$row[reu_invitado]';";
                    $resultb = $conn->query($bus);
                    if ($resultb->num_rows > 0) {
                        while ($row = $resultb->fetch_assoc()) {
                            $correorem = $row["usu_correo"];
                        }
                    }
                }
            }
        }
        $conn->close();
        ?>
        <form id="formulario01" method="POST" action="../../controladores/usuario/crearCorreo.php">
            <label for="invitado">Remitente</label>
            <input type="text" id="remitente" name="remitente" value="<?php echo $correorem ?>" placeholder="Ingrese el correo del invitado
                            ..." disabled />
            <br>
            <label for="motivo"> Motivo</label>
            <input type="text" id="motivo" name="motivo" value="<?php echo $motivo ?>" placeholder="Ingrese el motivo
                                ..." disabled />
            <br>

            <label for="lugar"> Lugar</label>
            <input type="text" id="lugar" name="lugar" value="<?php echo $lugar ?>" placeholder="Ingrese el lugar
                                ..." disabled />
            <br>

            <label for="coordenada"> Coordenada</label>
            <input type="text" id="coordenada" name="coordenada" value="<?php echo $coordenada ?>" placeholder="Ingrese la coordenada
                                ..." disabled />
            <br>
            
            <label for="observacion">Observacion</label>
            <textarea id="observacion" name="observacion" placeholder="Ingrese la Observacion..." disabled><?php echo $observacion ?></textarea>
            <br>
            <a href="/correo/admin/vista/user/mensajesen.php"> Regresar </a>
        </form>
    </body>

    </html>
<?php
} else {
    header("Location: ../../../config/acceso.html");
}
?>