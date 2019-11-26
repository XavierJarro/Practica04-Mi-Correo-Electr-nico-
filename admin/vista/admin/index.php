<?php
session_start();
$nombresui = explode(" ", $_SESSION['nom']);
$apellidosui =  explode(" ", $_SESSION['ape']);
$codigoui = $_SESSION['cod'];
$usurol = $_SESSION['rol'];
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === FALSE) {
    header("Location: /correo/public/vista/login.html");
}
if ($usurol == 'admin') {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>REUNIONES</title>
        <link href="../../../css/stables.css" rel="stylesheet" type="text/css" />
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
            <h2> Listado</h2>
            <nav class="navi">
                <ul id="menu">
                    <li><a href="#"> <?php echo $nombresui[0] . ' ' . $apellidosui[0] ?></a>
                        <ul>
                            <li><a href="../../../config/cerrarSesion.php"> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav class="naveg">
                <ul>
                    <li> <a href="index.php">Inicio </a> </li>
                    <li> <a href="listado.php">Usuarios</a> </li>
                </ul>
            </nav>
        </header>
        <table id="tbl">
        
            <caption>
                <h4>Reuniones </h4>
            </caption>
            <tr>
                <th>Fecha</th>
                <th>Remitente</th>
                <th>Invitado</th>
                <th>Motivo</th>
                <th>Lugar</th>
                <th>Coordenada</th>
                <th>Eliminar Reunion</th>
            </tr>
            <?php
            $sql = "SELECT * FROM reunion ORDER BY reu_fecha_hora DESC;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $codigo = $row["reu_codigo"];
                    $fecha = $row["reu_fecha_hora"];
                    $motivo = $row["reu_motivo"];
                    $lugar = $row["reu_lugar"];
                    $coordenada= $row["reu_coordenada"];
                    $array = array(0 => $row["reu_invitado"], 1 => $row["reu_invitado"]);
                    $array2 = [];
                    foreach ($array as $i => $value) {
                        $bus = "SELECT * FROM usuario WHERE usu_codigo=$array[$i];";
                        $resultb = $conn->query($bus);
                        if ($resultb->num_rows > 0) {
                            while ($row = $resultb->fetch_assoc()) {
                                $array2[] = $row["usu_correo"];
                            }
                        }
                    }
                    echo "<tr>";
                    echo "   <td>" . $fecha . "</td>";
                    echo "   <td>" . $array2[0] . "</td>";
                    echo "   <td>" . $array2[1] . "</td>";
                    echo "   <td>" . $motivo . "</td>";
                    echo "   <td>" . $lugar . "</td>";
                    echo "   <td>" . $coordenada . "</td>";
                    echo "   <td> <a href='/correo/admin/controladores/admin/eliminarReu.php?codigo=$codigo'> Ir </a> </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "   <td colspan='7'> No existen correos registrados al usuario </td>";
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