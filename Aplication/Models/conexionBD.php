<?php
    class ConexionBD{
        protected function conectar(){
            // CREAMOS UNA NUEVA CONEXIÓN
            $mysqli = mysqli_init();

            // CONFIGURACIÓN PARA QUE TOME LOS VALORES ENTEROS Y DOUBLES NO COMO STRING
            $mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

            // SE AÑADEN LOS DATOS DE CONEXIÓN --> ("DIRECCION", "USUARIO", "CONTRASEÑA", "NOMBRE BASE DATOS")
            $mysqli->real_connect("127.0.0.1", "phpUser", "phpUser123", "actividadphp");

            // SE REGRESA LA CONEXIÓN
            return $mysqli;
        }
    }
?>