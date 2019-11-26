# OBJETIVO ALCANZADO:
- Entender y organizar de una mejor manera los sitios de web en Internet.
- Diseñar adecuadamente elementos gráficos en sitios web en Internet.
- Crear sitios web aplicando estándares actuales.

## 1.	Generar el diagrama E-R para la solución de la práctica.
![1](https://user-images.githubusercontent.com/56524895/69665057-92d73d00-1057-11ea-8bdb-96e33b292152.png)
## 2.	Nombre de la base de datos.
El nombre de la base de datos es “practica”.
![2](https://user-images.githubusercontent.com/56524895/69665083-a387b300-1057-11ea-99dc-dba2693232bc.png)
## 3.	Sentencias SQL de la estructura de la base de datos.

### Creación de tabla usuario:

CREATE TABLE `usuario` ( 
`usu_codigo` int(11) NOT NULL AUTO_INCREMENT, 
`usu_cedula` varchar(10) NOT NULL,
 `usu_nombres` varchar(50) NOT NULL,
  `usu_apellidos` varchar(50) NOT NULL,
 `usu_direccion` varchar(75) NOT NULL, 
`usu_telefono` varchar(20) NOT NULL, 
`usu_correo` varchar(20) NOT NULL, 
`usu_password` varchar(255) NOT NULL,
 `usu_fecha_nacimiento` date NOT NULL, 
`usu_eliminado` varchar(1) NOT NULL DEFAULT 'N',
 `usu_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `usu_fecha_modificacion` timestamp NULL DEFAULT NULL,
`usu_rol` varchar(10),
PRIMARY KEY (`usu_codigo`), 
UNIQUE KEY `usu_cedula` (`usu_cedula`))
ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

### Creación de tabla correo:

CREATE TABLE `reunion`. ( `reu_codigo` INT NOT NULL AUTO_INCREMENT ,
 `reu_fecha_hora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `reu_lugar` VARCHAR(50) NOT NULL ,
 `reu_coordenada` VARCHAR(100) NOT NULL ,
 `reu_remitente` INT NOT NULL , 
`reu_invitado` INT NOT NULL ,
 `reu_motivo` VARCHAR(255) NOT NULL ,
 `reu_observacion` VARCHAR(255) NOT NULL ,
 PRIMARY KEY (`reu_codigo`)) ENGINE = InnoDB;PRIMARY KEY (`reu_codigo`), 
FOREIGN KEY (`reu_remitente`) REFERENCES usuario(usu_codigo),
FOREIGN KEY (`reu_invitado`) REFERENCES usuario(usu_codigo) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1


## 4.	Creación de la página index.php del usuario. Donde creamos una lista donde se encuentre el menú de la página nueva reunion, reuniones enviadas, Mi Cuenta y finalmente el cerrar sesión.
![3](https://user-images.githubusercontent.com/56524895/69604564-d4320300-0feb-11ea-8a04-d436ee45fa2e.png)
Creamos otra consulta para que en la página index se me visualice las reuniones que han enviado. En donde utilizo la variable session para poder obtener el código del usuario que se encuentra dentro de la página, y asi poder obtener los mensajes que han enviado a este usuario. En la sentencia sql pongo una condición, que es que me muestre que el correo no este eliminado, es decir si el correo tiene el valor N en la columna reunion_eliminado es que se encuentra eliminado. Y finalmente que me muestre los mensajes más recientes, para lo cual utilize ORDER BY DESC. Para que se me visualice el correo electrónico del remitente utilizo dentro del while otra sentencia sql para poder obtener la reunión del remitente en cada iteración del while, y finalmente lo muestro en la tabla.
![5](https://user-images.githubusercontent.com/56524895/69604619-faf03980-0feb-11ea-9074-df36296b97b2.png)
Para poder leer los mensajes utilice una etiqueta a dentro de la tabla que me permitirá leer la reunión que ha enviado el remitente. Para esto utilizo el método get para pasar el código de la reunión a la página leer.php. En la página leer.php hacemos una consulta sql donde obtenemos todo de una reunión en específico mediante el código de la reunión, el cual lo obtenemos de la página index.php mediante el método GET. Después obtenemos la reunión del remitente mediante otra consulta sql, donde obtenemos la reunión del remitente mediante el código de dicho remitente, para ello utilizamos el resultado de la anterior secuencia sql. A continuación, creo un formulario html, en donde en el value de cada input de doy el valor de las sentencias sql.
![6](https://user-images.githubusercontent.com/56524895/69604661-10656380-0fec-11ea-9cd0-bbc886576acd.png)
En la página reuniones enviados para obtener las reuniones que el usuario ha enviado utilizo la variable SESSION, para así obtener el código del usuario y con este preguntar en una sentencia sql si el código del destinatario sea igual al código del usuario que se encuentra en la página web. Dentro del while hago otra consulta sql para poder obtener la reunión del destinatario y visualizarlo en la tabla. Para visualizar utilizamos una tabla para que nos muestre las reuniones y al final una opción leer para poder leer la reunión. Para Poder leer la reunión accedemos a la página leer.php de los controladores, y hacemos el mismo procedimiento que en la página index para las reuniones recibidos.
![7](https://user-images.githubusercontent.com/56524895/69604682-207d4300-0fec-11ea-8eea-5546ad3a2e64.png)
Para poder mandar una reunión a otro usuario creamos un formulario para poder escribir el asunto, el mensaje y el destinatario a quien queremos escribir. Después mediante el formulario accedemos a la página nuevomensaje.php mediante un action y el método $_POST.
![8](https://user-images.githubusercontent.com/56524895/69604750-4b679700-0fec-11ea-90dd-b49d25460a78.png)
![9](https://user-images.githubusercontent.com/56524895/69604751-4c002d80-0fec-11ea-8ca1-e85fee07206a.png)
Después obtenemos el valor de las cajas del formulario con el método POST y hacemos una sentencia sql para poder insertar en la base de datos los valores, donde también hacemos otra sentencia para obtener el código del destinatario y poder asignarlo a la base.
![10](https://user-images.githubusercontent.com/56524895/69604778-5e7a6700-0fec-11ea-9ee3-f30325658408.png)
Para buscar el mensaje electrónico utilizamos ajax. Para realizar la búsqueda utilizamos onkeyup en el input de la página index. Donde utilizamos una función que la hemos llamado buscarPorCorreo. Donde si lo utilizamos nos mandara a la página buscar.php , y donde también utilizaremos el método GET para poder enviar el correo electrónico para que nos pueda buscar mediante el correo.
![11](https://user-images.githubusercontent.com/56524895/69604808-781bae80-0fec-11ea-8038-18531fcc1a2d.png)
En la página buscar php utilizamos el método get para poder obtener el correo de la persona que queremos buscar en los mensajes enviados. Hacemos una sentencia sql para obtener el correo del remitente en donde utilizamos la Palabra LIKE para poder obtener el correo del usuario mediante las primeras letras ingresadas para buscar. Después creamos otras dos sentencias para obtener los correos que tengan un mismo destinatario y un mismo remitente. Y el ultimo para obtener el correo del destinatario y ponerlo en la tabla.
![12](https://user-images.githubusercontent.com/56524895/69604829-88338e00-0fec-11ea-8fd8-ee12e57b0591.png)
Para poder modificar los datos creamos un formulario, en donde primeramente creamos una sentencia sql para obtener los datos del usuario, donde utilizamos la variable sesión para obtener el código del usuario. Después procedemos a pasar todos los datos del usuario al formulario. Cuando demos click al botón modificar nos llevará a la página modificar.php del controlador.
![13](https://user-images.githubusercontent.com/56524895/69604850-98e40400-0fec-11ea-8b3d-252fd5fd354b.png)
En la página modificar.php del controlador utilizamos el método post para obtener los valores de las cajas del formulario. A continuación, hacemos un update para actualizar los campos del usuario. En el update ponemos la hora que se ha ejecutado la actualización.
![14](https://user-images.githubusercontent.com/56524895/69604875-a9947a00-0fec-11ea-876d-a5b5b495db89.png)
En la página cambiarcontraseña.php de controladores obtenemos lo que se encuentra en los campos con el método POST , después hacemos una sentencia sql para obtener todo del usuario que tiene la contraseña actual. Después hacemos un update de este mismo usuario en donde le damos la nueva contraseña obtenida del campo del formulario.
![15](https://user-images.githubusercontent.com/56524895/69604923-ca5ccf80-0fec-11ea-8942-6fc1f4917410.png)
Para que un administrador no reciba un correo preguntamos en la página login.php si el rol de usuario es igual a user se pueda ingresar los datos a la tabla correo de la base.
![16](https://user-images.githubusercontent.com/56524895/69604956-dba5dc00-0fec-11ea-9878-40f2c3c013b1.png)
Para poder eliminar los correos electronicos, creamos un formulario donde obtendremos la fecha. El remitente , el destinatario y el asunto. En este formulario ya tendremos puesto todos los valores en los inputs ya que hemos utilizado el metodo get para obtener mediante la url los datos del correo. Después accedemos al metodo eliminar de la carpeta controladores mediante un action y pasamos los valores a esta pagina mediante el metodo POST.
![17](https://user-images.githubusercontent.com/56524895/69604973-ea8c8e80-0fec-11ea-9fce-6c3d8eeeed37.png)
Para que el administrador pueda eliminar el usuario, mandamos los datos del usuario a un formulario, en este formulario que se llama eliminarUsuario.php obtenemos el código del usuario al cual queremos eliminar, donde utilizaremos el método GET para obtener el código del usuario que le hemos pasado en la url . Después obtenemos todos los valores de la tabla usuario donde el código del usuario sea la variable que le hemos asignado al metogo Get.
![18](https://user-images.githubusercontent.com/56524895/69605000-fa0bd780-0fec-11ea-951f-9afe7a0c8e5f.png)
Para que el administrador pueda modificar el usuario pasamos los datos del usuario a un formulario, en donde utilizamos el método get para poder obtener el código del usuario que hemos mandado mediante la url y cuando demos click en modificar, nos llevara a la página modificar.php del controlador.
![19](https://user-images.githubusercontent.com/56524895/69605029-0e4fd480-0fed-11ea-97a3-0986963c0d1c.png)
![20](https://user-images.githubusercontent.com/56524895/69605030-0e4fd480-0fed-11ea-8b39-9424ac290394.png)
Para poder modificar la contraseña del usuario usamos un formulario para poder ingresar la contraseña actual y la nueva contraseña. En donde utilizamos el método GET para poder obtener el codigo de el usuario que hemos enviado mediante la url. Después accedemos a la pagina cambiar_contraseña.php mediante action y mandamos los valores mediante el método POST.
![21](https://user-images.githubusercontent.com/56524895/69605075-2889b280-0fed-11ea-8eac-8ac3eab5739f.png)
En la página cambiarcontraseña.php de controladores obtenemos lo que se encuentra en los campos con el método POST , después hacemos una sentencia sql para obtener todo del usuario que tiene la contraseña actual. Después hacemos un update de este mismo usuario en donde le damos la nueva contraseña obtenida del campo del formulario.
![22](https://user-images.githubusercontent.com/56524895/69605095-37706500-0fed-11ea-8c82-fd5376a81fda.png)
Para poder verificar que un usuario sea user o admin y pueda ingresar a ciertas páginas de la página web utilizamos la variable $_SESSION en el login.php. En donde si es rol user se cree la variable $_SESSION[‘isAdmin´]= TRUE ; y no es user que se cree la variable $_SESSION[‘isAdmin´]= TRUE ;. De esta manera sabremos si es un administrador o un usuario.

![23](https://user-images.githubusercontent.com/56524895/69605115-4a833500-0fed-11ea-8bd0-9f7f62b904e8.png)
En cada página que sea user agregamos el siguiente codigo para que no permita ingresar a la pagina si no esta con la session user.

![24](https://user-images.githubusercontent.com/56524895/69605152-64247c80-0fed-11ea-9204-968db684daee.png)
Cuando damos cerrar sesion nos manda al archivo cerrar_sesion_User y nos Cierra la session con el siguiente codigo
![25](https://user-images.githubusercontent.com/56524895/69605189-769eb600-0fed-11ea-9d07-2ab3411c3bdb.png)
## 5.	La evidencia del correcto diseño de las páginas HTML usando CSS.
### Crear Usuario.
![26](https://user-images.githubusercontent.com/56524895/69667094-560d4500-105b-11ea-925f-873e938910ff.png)
### Iniciar sesión.
![27](https://user-images.githubusercontent.com/56524895/69667108-5d345300-105b-11ea-98ae-2d37311e1988.png)
### Como admin:
![28](https://user-images.githubusercontent.com/56524895/69667122-632a3400-105b-11ea-9d60-5d7fca90cd0e.png)
### Listar usuarios.
![29](https://user-images.githubusercontent.com/56524895/69667137-6d4c3280-105b-11ea-8b48-7473db8d77f5.png)
### Eliminar usuario.
![30](https://user-images.githubusercontent.com/56524895/69667150-73421380-105b-11ea-8367-cc67e5c2f6cb.png)
### Actualizar Usuario.
![31](https://user-images.githubusercontent.com/56524895/69667164-7937f480-105b-11ea-8cb4-e51de10f8762.png)
### Cambiar contrase;a usurio.
![32](https://user-images.githubusercontent.com/56524895/69667174-7fc66c00-105b-11ea-8ba3-9171a37167a9.png)
### Inicio de sesión user.
![33](https://user-images.githubusercontent.com/56524895/69667189-86ed7a00-105b-11ea-9e0d-481c09c510c0.png)
### Nueva Reunion.
![34](https://user-images.githubusercontent.com/56524895/69667201-8ce35b00-105b-11ea-92e6-26342ac691ed.png)
### Reunion enviadas.
![35](https://user-images.githubusercontent.com/56524895/69667237-9967b380-105b-11ea-8b0d-af3d58bb2e87.png)
### Datos del usuario.
![36](https://user-images.githubusercontent.com/56524895/69667256-a1bfee80-105b-11ea-9d85-21d9e8288e7f.png)
### Actualizar usuario.
![37](https://user-images.githubusercontent.com/56524895/69667269-a97f9300-105b-11ea-80b7-b6baa71f5db5.png)
### Cambiar contrase;a.
![38](https://user-images.githubusercontent.com/56524895/69667279-b00e0a80-105b-11ea-8dcf-f378bea98322.png)
## 6.	En el informe se debe incluir la información de GitHub (usuario y URL del repositorio de la práctica)
Usuario:XavierJarro
URL: https://github.com/XavierJarro/Practica04-Mi-Correo-Electr-nico-

## CONCLUSIONES:
- Hemos podido realizar la practica con éxito, implementando php, javascript, html y Ajax
- Hemos implementado la página web con la base de datos de manera correcta. Hemos hecho los pasos necesarios para poder trabajar con la base sin ningún error.
## RECOMENDACIONES:
- Se debe de implementar html. Javascript, php y ajax de manera correcta para poder realizar esta práctica de manera correcta.
- Se debe de implementar las consultas sql a la hora de desarrollar la práctica para que no nos de ningún error inesperado.

