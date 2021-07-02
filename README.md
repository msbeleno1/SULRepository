# SULRepository
Aplicativo web para el control y administración de notas de estudiantes.

### Tecnologías implementadas:
  - PHP (Sin framewrok)
  - Html5
  - Css (Framework: Bootsrap)
  - Javascript (Framework: Jquery - Plugin: Datatables)
  - MySql
<br />
  
### Instalación:
  Para su ejecución primero se debe configurar la base de datos de la siguiente manera:
  - En la carpeta MySql DataBase se encuentran los Scripts para la creación de la base de datos local. Cada script debe ejecutarse de manera secuencial en su cliente de base de datos MySql.
  - Luego deberá crear un usuario de conexión local con su respectiva contraseña. En caso de querer evitar la menor configuración posible, se recomienda que el usuario sea **_phpUser_** y la contraseña sea **_phpUser123_**.
  - Después, en la carpeta de la aplicación / Models se encuentra el archivo [conexionBD.php](Aplication/Models/conexionBD.php) en donde se deberán configurar el usuario de conexión y su respectiva clave, en caso de haber creado un usuario o clave diferente a lo mencionado en el paso anterior.
  - Por último, para poder ejecutar la aplicación debe colocar la carpeta Aplication de este repositorio en la respectiva carpeta para desplegar la aplicación en PHP.
<br />
  
### Distribución:
  La distribución de la aplicación en general se divide en 4 carpetas:
  - **Views:** Como nombre lo indica, en esta carpeta se encuentran alojadas todas las vistas o plantillas de HTML.
  - **Models:** Este nombre hace referencia a las clases de PHP utilizadas para el almacenamientos de datos y/o realización de algoritmos. Aquí se encuentran los Value Objects (Objetos de valor), los Data Access Objects (Objetos de acceso de datos) y algunas clases utiles como la conexión a la base de datos y el control del login.
  - **Controllers:** En esta carpeta se almacenan los controladores usados para enviar la información a las vistas.
  - **Assets:** En este directorio se almacenan las subcarpetas con los archivos correspondientes a los estilos, los scripts de JavaScript, imágenes o documentos. Y se encuentra organizado de la siguiente forma:
    - **Css:** Acá se encuentran las hojas de estilos de la aplicación.
    - **Js:** Contiene las hojas de código de JavaScript y Jquery. En la hoja de [ajaxToForm.js](Aplication/Assets/css/js/ajaxToForms.js) se realizan todas las peticiones al servidor mediante el uso de Ajax y en [functionToDatatable.js](Aplication/Assets/css/js/functionToDatatable.js) se realizan todo el proceso de cargar la información en las respectivas tablas de Estudiantes o Usuarios.
    - **Img:** Acá se almacenan los recursos graficos utilizados en el diseño de la aplicación.
    - **Docs:** En este directorio se almacenan los documentos de texto como el archivo de control de login.
