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
    </head>

    <body>
        <table id="tbl">
            <?php
            $motivo = $_GET['motivo'];
            $url = $_GET['url'];
            include '../../../config/conexionBD.php';
            $val = false;
            $val1 = false;
            $array = [];
            $bus = "SELECT * FROM reunion WHERE reu_motivo LIKE '$motivo';";
            $resultb = $conn->query($bus);
            if ($resultb->num_rows > 0) {
                while ($row = $resultb->fetch_assoc()) {
                    $array[] = $row["reu_invitado"];
                }
            }
            if (count($array) != 0) {
                if ($url == "/correo/admin/vista/user/mensajesen.php") {
                    echo "<tr>";
                    echo "<th>Fecha</th>";
                    echo "<th>Invitado</th>";
                    echo " <th>Motivo</th>";
                    echo " <th>Lugar</th>";
                    echo " <th>Coordenada</th>";
                    echo "<th>Leer</th>";
                    echo "</tr>";
                    foreach ($array as $i => $value) {
                        //$sql = "SELECT * FROM reunion WHERE reu_invitado=$array[$i] AND reu_remitente=$codigoui ORDER BY reu_fecha_hora DESC;";
                        $sql = "SELECT * FROM reunion WHERE reu_invitado=$array[$i] AND reu_invitado=$codigoui ORDER BY reu_fecha_hora DESC;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $codigo = $row["reu_codigo"];
                                $fecha = $row["reu_fecha_hora"];
                                $motivo = $row["reu_motivo"];
                                $lugar = $row["reu_lugar"];
                                $coordenada= $row["reu_coordenada"];
                                $correodes = "";
                                $bus = "SELECT * FROM usuario WHERE usu_codigo=$row[reu_invitado];";
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
                                echo "   <td> <a href='eliminar.php?codigo=$codigo'> Ir </a> </td>";
                                echo "</tr>";
                            }
                        } else {
                            $val1 = true;
                        }
                    }
                    if ($val1 == true) {
                        echo "<tr>";
                        echo "   <td colspan='4'> No existen reuniones de usuarios que su motivo empieze con $motivo </td>";
                        echo "</tr>";
                    }
                } else if ($url == "/correo/admin/vista/user/index.php") {
                    echo "<tr>";
                    echo "<th>Fecha</th>";
                    echo "<th>Remitente</th>";
                    echo " <th>Motivo</th>";
                    echo " <th>Lugar</th>";
                    echo " <th>Coordenada</th>";
                    echo "<th>Leer</th>";
                    echo "</tr>";
                    foreach ($array as $i => $value) {
                        $sql = "SELECT * FROM reunion WHERE reu_invitado=$array[$i] AND reu_remitente=$codigoui ORDER BY reu_fecha_hora DESC;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $codigo = $row["reu_codigo"];
                                $fecha = $row["reu_fecha_hora"];
                                $motivo = $row["reu_motivo"];
                                $lugar = $row["reu_lugar"];
                                $coordenada= $row["reu_coordenada"];
                                $correodes = "";
                                $bus = "SELECT * FROM usuario WHERE usu_codigo=$row[reu_invitado];";
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
                                echo "   <td> <a href='eliminar.php?codigo=$codigo'> Ir </a> </td>";
                                echo "</tr>";
                            }
                        } else {
                            $val = true;
                        }
                    }
                    if ($val == true) {
                        echo "<tr>";
                        echo "   <td colspan='4'>  No existen reuniones de usuarios que su motivo empieze con $motivo </td>";
                        echo "</tr>";
                    }
                }
            } else {
                if ($url == "/correo/admin/vista/user/mensajesen.php") {
                    echo "<tr>";
                    echo "<th>Fecha</th>";
                    echo "<th>Remitente</th>";
                    echo " <th>Motivo</th>";
                    echo " <th>Lugar</th>";
                    echo " <th>Coordenada</th>";
                    echo "<th>Leer</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "   <td colspan='4'>  No existen reuniones de usuarios que su motivo empieze con $motivo </td>";
                    echo "</tr>";
                } else if ($url == "/correo/admin/vista/user/index.php") {
                    echo "<tr>";
                    echo "<th>Fecha</th>";
                    echo "<th>Remitente</th>";
                    echo " <th>Motivo</th>";
                    echo " <th>Lugar</th>";
                    echo " <th>Coordenada</th>";
                    echo "<th>Leer</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "   <td colspan='4'>  No existen reuniones de usuarios que su motivo empieze con $motivo </td>";
                    echo "</tr>";
                }
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