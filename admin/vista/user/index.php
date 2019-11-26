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
        ?>
        <header class="cabis">
            <h2>
                Listado de Reuniones
            </h2>
            <nav class="navi">
                <ul id="menu">
                    <li><a href="#"> <?php echo $nombresui[0] . ' ' . $apellidosui[0] ?></a>
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
            <h4>Invitaciones de reuniones</h4>
        </header>
        <table id="tbl">
        <input autofocus type="text" id="motivo" name="motivo" value="" placeholder="Ingrese el motivo para buscar" required onkeyup="buscarPorMotivo()" />
         <br>
         <br>
        <tr>
            <tr>
                <th>Fecha</th>
                <th>Remitente</th>
                <th>Motivo</th>
                <th>Lugar</th>
                <th>Coordenada</th>
                <th>Leer</th>
            </tr>
            <?php
            $url = $_SERVER['REQUEST_URI'];
            $sql = "SELECT * FROM reunion WHERE reu_invitado=$codigoui ORDER BY reu_fecha_hora DESC;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $codigo = $row["reu_codigo"];
                    $fecha = $row["reu_fecha_hora"];
                    $motivo = $row["reu_motivo"];
                    $lugar = $row["reu_lugar"];
                    $coordenada= $row["reu_coordenada"];
                    $correodes = "";
                    $bus = "SELECT usu_correo FROM usuario WHERE usu_codigo='$row[reu_invitado]';";
                    $resultb = $conn->query($bus);
                    if ($resultb->num_rows > 0) {
                        while ($row = $resultb->fetch_assoc()) {
                            $correodes = $row["usu_correo"];
                        }
                    }
                    echo "<tr>";
                    echo "   <td>" . $fecha . "</td>";
                    echo "   <td>" . $correodes . "</td>";
                    echo "   <td>" . $motivo . "</td>";
                    echo "   <td>" . $lugar . "</td>";
                    echo "   <td>" . $coordenada . "</td>";
                    echo "   <td> <a href='../../controladores/user/lecturamen.php?codigo=$codigo&url=$url'> Ir </a> </td>";
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