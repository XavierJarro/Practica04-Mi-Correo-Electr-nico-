<?php
session_start();
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
        <?php
            include '../../../config/conexionBD.php';
            $sqlu = "SELECT * FROM usuario WHERE usu_codigo=$_GET[codigo];";
            $resultu = $conn->query($sqlu);
            if ($resultu->num_rows > 0) {
                while ($row = $resultu->fetch_assoc()) {
                    $codigo = $row["usu_codigo"];
                    $cedula = $row["usu_cedula"];
                    $nombres = $row["usu_nombres"];
                    $apellidos = $row["usu_apellidos"];
                    $direccion = $row["usu_direccion"];
                    $telefono = $row["usu_telefono"];
                    $correo = $row["usu_correo"];
                    $fecha = $row["usu_fecha_nacimiento"];
                    $fecha = date('d/m/Y', strtotime(str_replace('-', '/', $fecha)));
                    $contrasena = $row["usu_password"];                    
                }
            }
            ?>
        <header class="cab">
            <h1>Eliminar Usuario</h1>
        </header>
        <form id="formulario01" method="POST" action="../../controladores/admin/eliminar.php">
            <div class="parte1">
                <input type="hidden" id="codigo" name="codigo" value=" <?php echo $codigo; ?>" />
                <label for="cedula">Cedula</label>
                <input type="text" id="cedula" name="cedula" value="<?php echo $cedula; ?>" disabled />
                <br>
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>" disabled />
                <br>
                <label for="apellidos">Apelidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" disabled />
                <br>
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" disabled />
                <br>
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" disabled />
                <br>
                <label for="fecha">Fecha Nacimiento</label>
                <input type="text" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $fecha; ?>" disabled />
                <br>
                <label for="correo">Correo electrónico</label>
                <input type="text" id="correo" name="correo" value="<?php echo $correo; ?>" disabled />
                <br>                
                <input type="submit" id="eliminar" name="eliminar " value="Eliminar" />
                <input type="reset" id="cancelar " name="cancelar" value="Cancelar" />
                <a href="listado.php"> Regresar </a>
            </div>


        </form>
    </body>

    </html>
<?php
} else {
    header("Location: ../../../config/acceso.html");
}
$conn->close();
?>