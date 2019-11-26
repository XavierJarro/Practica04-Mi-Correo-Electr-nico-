<?php
session_start();
$codigoui = $_SESSION['cod'];
$nombresui = explode(" ", $_SESSION['nom']);
$apellidosui =  explode(" ", $_SESSION['ape']);
$correoui = $_SESSION['cor'];
$usurol = $_SESSION['rol'];
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === FALSE) {
    header("Location: /SistemaDeGestion/public/vista/login.html");
}
if ($usurol == 'user') {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Correo Electronico</title>
        <link href="../../../css/stables.css" rel="stylesheet" type="text/css" />
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../../controladores/user/js/metodos.js"> </script>
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
                Listado de Correos
            </h2>
            <nav class="navi">
                <ul id="menu">
                    <li><a href="#"> <img id="imagen" src="data:image/*;base64,<?php echo base64_encode($foto); ?>"> <?php echo $nombresui[0] . ' ' . $apellidosui[0] ?></a>
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
            <h4>Mensajes Enviados</h4>
        </header>
        <table id="tbl">            
            <tr>
                <th>Fecha</th>
                <th>Destinatario</th>
                <th>Asunto</th>
                <th>Leer</th>
            </tr>
            <?php
            $url = $_SERVER['REQUEST_URI'];
            include '../../../config/conexionBD.php';
            $sql = "SELECT * FROM correo WHERE cor_eliminado='N' AND cor_usu_remitente=$codigoui ORDER BY cor_fecha_hora DESC;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $codigo = $row["cor_codigo"];
                    $fecha = $row["cor_fecha_hora"];
                    $asunto = $row["cor_asunto"];
                    $correodes = "";
                    $bus = "SELECT * FROM usuario WHERE usu_codigo='$row[cor_usu_destinatario]';";
                    $resultb = $conn->query($bus);
                    if ($resultb->num_rows > 0) {
                        while ($row = $resultb->fetch_assoc()) {
                            $correodes = $row["usu_correo"];
                        }
                    }
                    echo "<tr>";
                    echo "   <td>" . $fecha . "</td>";
                    echo "   <td>" . $correodes . "</td>";
                    echo "   <td>" . $asunto . "</td>";
                    echo "   <td> <a href='../../controladores/user/lecturamen.php?codigo=$codigo&url=$url'> Ir </a> </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "   <td colspan=' 7'> No existen correos registrados al usuario </td>";
                echo "</tr>";
            }
            $conn->close();
            ?>
        </table>
    </body>

    </html>
<?php
} else {
    header("Location: ../../../config/acceso.html");
}
?>