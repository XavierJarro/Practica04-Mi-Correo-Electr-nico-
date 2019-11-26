# OBJETIVO ALCANZADO:
- Entender y organizar de una mejor manera los sitios de web en Internet.
- Diseñar adecuadamente elementos gráficos en sitios web en Internet.
- Crear sitios web aplicando estándares actuales.

## 1.	Generar el diagrama E-R para la solución de la práctica.
![1](https://user-images.githubusercontent.com/56524895/69604416-608ff600-0feb-11ea-9852-c2fbacf1d667.png)
## 2.	Nombre de la base de datos.
El nombre de la base de datos es “practica”.
![2](https://user-images.githubusercontent.com/56524895/69604478-9503b200-0feb-11ea-9312-afa96c4e3a77.png)
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
`usu_foto` longblob, 
PRIMARY KEY (`usu_codigo`), 
UNIQUE KEY `usu_cedula` (`usu_cedula`))
ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

### Creación de tabla correo:

CREATE TABLE `correo` (
 `cor_codigo` int(11) NOT NULL AUTO_INCREMENT, 
`cor_fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `cor_usu_remitente` int(11) NOT NULL,
 `cor_usu_destinatario` int(11) NOT NULL, 
`cor_asunto` varchar(50) NOT NULL, 
`cor_mensaje` varchar(255) NOT NULL,
 `cor_eliminado` varchar(1) NOT NULL DEFAULT 'N', 
`cor_fecha_modificacion` timestamp NULL DEFAULT NULL, 
PRIMARY KEY (`cor_codigo`), 
FOREIGN KEY (`cor_usu_remitente`) REFERENCES usuario(usu_codigo),
FOREIGN KEY (`cor_usu_destinatario`) REFERENCES usuario(usu_codigo) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

## 4.	Creación de la página index.php del usuario. Donde creamos una lista donde se encuentre el menú de la página nuevomensaje, mensajesenviados, Mi Cuenta y finalmente el cerrar sesión.
![3](https://user-images.githubusercontent.com/56524895/69604564-d4320300-0feb-11ea-8a04-d436ee45fa2e.png)
Hacemos una consulta sql para poder cargar la foto que se encuentra en la base del usuario que este dentro de la página, en donde utilizamos una etiqueta img para poder ver la imagen del usuario.
![4](https://user-images.githubusercontent.com/56524895/69604595-e8760000-0feb-11ea-9857-a2a720b5f3f3.png)
Creamos otra consulta para que en la página index se me visualice los mensajes que han enviado. En donde utilizo la variable session para poder obtener el código del usuario que se encuentra dentro de la página, y asi poder obtener los mensajes que han enviado a este usuario. En la sentencia sql pongo una condición, que es que me muestre que el correo no este eliminado, es decir si el correo tiene el valor N en la columna correo_eliminado es que se encuentra eliminado. Y finalmente que me muestre los mensajes más recientes, para lo cual utilize ORDER BY DESC. Para que se me visualice el correo electrónico del remitente utilizo dentro del while otra sentencia sql para poder obtener el correo del remitente en cada iteración del while, y finalmente lo muestro en la tabla.
![5](https://user-images.githubusercontent.com/56524895/69604619-faf03980-0feb-11ea-9074-df36296b97b2.png)
Para poder leer los mensajes utilice una etiqueta a dentro de la tabla que me permitirá leer el correo que ha enviado el remitente. Para esto utilizo el método get para pasar el código del correo a la página leer.php. En la página leer.php hacemos una consulta sql donde obtenemos todo de un correo en específico mediante el código del correo, el cual lo obtenemos de la página index.php mediante el método GET. Después obtenemos el correo del remitente mediante otra consulta sql , donde obtenemos el correo del remitente mediante el código de dicho remitente, para ello utilizamos el resultado del anterior secuencia sql. A continuación, creo un formulario html, en donde en el value de cada input de doy el valores de las sentencias sql.
![6](https://user-images.githubusercontent.com/56524895/69604661-10656380-0fec-11ea-9cd0-bbc886576acd.png)
En la página mensajes enviados para obtener los mensajes que el usuario ha enviado utilizo la variable SESSION, para así obtener el código del usuario y con este preguntar en una sentencia sql si el código del destinatario sea igual al código del usuario que se encuentra en la página web. Dentro del while hago otra consulta sql para poder obtener el correo del destinatario y visualizarlo en la tabla. Para visualizar utilizamos una tabla para que nos muestre los mensajes y al final una opción leer para poder leer el mensaje. Para Poder leer el mensaje accedemos a la página leer.php de los controladores, y hacemos el mismo procedimiento que en la página index para los mensajes recibidos.
![7](https://user-images.githubusercontent.com/56524895/69604682-207d4300-0fec-11ea-8eea-5546ad3a2e64.png)
Para poder mandar un correo a otro usuario creamos un formulario para poder escribir el asunto, el mansaje y el destinatario a quien queremos escribir. Después mediante el formulario accedemos a la página nuevomensaje.php mediante un action y el método $_POST.
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
![26](https://user-images.githubusercontent.com/56524895/69605279-b8c7f780-0fed-11ea-9752-8c56893fc458.png)
### Iniciar sesión.
![27](https://user-images.githubusercontent.com/56524895/69605281-b9f92480-0fed-11ea-9b71-a801cf49153d.png)
### Como admin:
![28](https://user-images.githubusercontent.com/56524895/69605291-bcf41500-0fed-11ea-8b23-898048d164bf.png)
### Listar usuarios.
![29](https://user-images.githubusercontent.com/56524895/69605385-f593ee80-0fed-11ea-9e5f-4331210b6042.png)
### Eliminar usuario.
![30](https://user-images.githubusercontent.com/56524895/69605391-fb89cf80-0fed-11ea-981a-c3bb67f814a0.png)
### Actualizar Usuario.
![31](https://user-images.githubusercontent.com/56524895/69605423-13615380-0fee-11ea-9177-b24044b714d2.png)
### Cambiar contrase;a usurio.
![32](https://user-images.githubusercontent.com/56524895/69605463-283de700-0fee-11ea-9cb7-e899d2418439.png)
### Inicio de sesión user.
![33](https://user-images.githubusercontent.com/56524895/69605487-3be94d80-0fee-11ea-8e55-71a5caba097d.png)
### Nuevo mensaje.
![34](https://user-images.githubusercontent.com/56524895/69605511-4c99c380-0fee-11ea-8c72-7dd7f7221635.png)
### Mensajes enviados.
![35](https://user-images.githubusercontent.com/56524895/69605545-5fac9380-0fee-11ea-925e-04405a3b1f32.png)
### Datos del usuario.
![36](https://user-images.githubusercontent.com/56524895/69605567-7226cd00-0fee-11ea-98e7-85e38a70f25c.png)
### Actualizar usuario.
![37](https://user-images.githubusercontent.com/56524895/69605588-836fd980-0fee-11ea-91bf-ae3a8ff812f5.png)
### Cambiar contrase;a.
![38](https://user-images.githubusercontent.com/56524895/69605609-94b8e600-0fee-11ea-95e0-d1e43cde282f.png)
## 6.	En el informe se debe incluir la información de GitHub (usuario y URL del repositorio de la práctica)
Usuario:XavierJarro
URL: https://github.com/XavierJarro/Practica04-Mi-Correo-Electr-nico-

## CONCLUSIONES:
- Hemos podido realizar la practica con éxito, implementando php, javascript, html y Ajax
- Hemos implementado la página web con la base de datos de manera correcta. Hemos hecho los pasos necesarios para poder trabajar con la base sin ningún error.
## RECOMENDACIONES:
- Se debe de implementar html. Javascript, php y ajax de manera correcta para poder realizar esta práctica de manera correcta.
- Se debe de implementar las consultas sql a la hora de desarrollar la práctica para que no nos de ningún error inesperado.

