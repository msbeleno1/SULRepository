<?php
    // UTILS
    require_once "conexionBD.php";
    require_once 'controlLogeo.php';
    // VO
    require_once 'usuarioVO.php';

    class UsuarioDAO extends ConexionBD{
        
        // METODO PARA TAER LA LISTA DE USUARIOS
        public function verTodosUsuarios(){
            $mysqli = $this->conectar();
            $to_return = [];
            $array_usuario = array();
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->connect_error);
            }
            else{
                $sql = "SELECT * FROM usuario JOIN rol ON usuario.id_rol = rol.id_rol JOIN estado ON usuario.id_estado = estado.id_estado";
                $resultado = $mysqli->query($sql);
                
                if($resultado->num_rows > 0){
                    while($row = $resultado->fetch_assoc()){
                        $usuario = new UsuarioVO();
                        $usuario->setUsuario($row["documento_usuario"],$row["nombre_usuario"], $row["correo_usuario"],$row["fecha_ult_login"],$row["clave_usuario"],$row["id_estado"], $row["id_rol"]);
                        
                        // OBTENER EL NOMBRE DEL ESTADO
                        $usuario->setEstado_name($row["nombre_estado"]);
                        
                        // OBTENER EL NOMBRE DEL ROL
                        $usuario->setRol_name($row["nombre_rol"]);
                        
                        $array_usuario[] = $usuario;
                    }
                    $to_return = $array_usuario;
                }
                else{
                    $to_return = null;
                }
                $mysqli->close();
                $resultado->close();
            }
            return $to_return;
        }


        // METODO PARA CREAR UN USUARIO
        public function crearUsuario(UsuarioVO $usuario){
            $mysqli = $this->conectar();
            $to_return = [];
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->connect_error);
            }
            else{
                try {
                    // PREPARAMOS LA LLAMADA A LA BD
                    $pr = $mysqli->prepare("CALL crearUsuario(?,?,?,?,?,?)");

                    // ENLAZAMOS LOS VALORES
                    $usuario->encryptarClave();
                    $documento = $usuario->getDocumento();
                    $nombres = $usuario->getNombres();
                    $correo = $usuario->getCorreo();
                    $clave = $usuario->getClave();
                    $estado = $usuario->getEstado();
                    $rol = $usuario->getRol();
                    $pr->bind_param("ssssii",$documento,$nombres,$correo,$clave,$estado,$rol);
                    $pr->execute();
                    mysqli_stmt_bind_result($pr,$resultado);
                    $pr->fetch();

                    if($resultado == 'Usuario creado'){
                        $to_return = Array("informacion"=>"exito",
                                    "datos"=>$resultado);
                    }
                    else{
                        $to_return = Array("informacion"=>"error",
                                    "datos"=>$resultado);
                    }
                    
                } catch (Exception $e){
                    $to_return = Array("informacion"=>"error",
                                    "datos"=>$e->getMessage());
                } finally {
                    $pr->close();
                    $mysqli->close();
                }
                return $to_return;
            }
        }


        // METODO PARA ACTUALIZAR UN USUARIO
        public function actualizarUsuario(UsuarioVO $usuario){
            $mysqli = $this->conectar();
            $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->connect_error);

            // PREPARAMOS LA LLAMADA A LA BD
            $pr = $mysqli->prepare("CALL actualizarUsuario(?,?,?,?,?)");

            // ENLAZAMOS LOS VALORES
            $documento = $usuario->getDocumento();
            $nombres = $usuario->getNombres();
            $correo = $usuario->getCorreo();
            $estado = $usuario->getEstado();
            $rol = $usuario->getRol();
            $pr->bind_param("sssii",$documento,$nombres,$correo,$estado,$rol);
            $pr->execute();
            mysqli_stmt_bind_result($pr,$resultado);
            if($pr->fetch()){
                if($resultado == 'Usuario actualizado'){
                    $to_return = Array("informacion"=>"exito",
                                "datos"=>$resultado);
                }
                else{
                    $to_return = Array("informacion"=>"error",
                                "datos"=>$resultado);
                }
            }

            $pr->close();
            $mysqli->close();
            return $to_return;
        }


        // METODO PARA DAR DE BAJA UN USUARIO
        public function eliminarUsuario(int $documento, int $estado){
            $mysqli = $this->conectar();
            $to_return = [];
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->$mysqli->connect_error);
            }
            else{
                try{
                    $sql = "UPDATE usuario SET id_estado = 2  WHERE documento_usuario = ? AND id_estado = ?";
                    $pr = $mysqli->prepare($sql);
                    $pr->bind_param("ii",$documento,$estado);
                    $resultado = $pr->execute();
                    
                    if($resultado){
                        $to_return = Array("informacion"=>"exito","datos"=>"El usuario fue dado de baja");
                    }
                    else{
                        $to_return = Array("informacion"=>"error","datos"=>"Problemas al dar de baja al usuario");
                    }
                } catch (Exception $e){
                    $to_return = Array("informacion"=>"error",
                                    "datos"=>$e->getMessage());
                } finally {
                    $pr->close();
                    $mysqli->close();
                }
            }
            return $to_return;
        }


        // METODO PARA CAMBIAR LA CLAVE
        public function cambiarClave(string $correoL, string $claveL){
            $mysqli = $this->conectar();
            $to_return = [];
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->$mysqli->connect_error);
            }
            else{
                try{
                    $user = new UsuarioVO();
                    $user->setClave($claveL);
                    $user->encryptarClave();
                    $clave = $user->getClave();
                    $pr = $mysqli->prepare("CALL cambiarClave(?,?)");
                    $pr->bind_param("ss",$correoL,$clave);
                    $resultado = $pr->execute();
                    
                    if($resultado){
                        $to_return = Array("informacion"=>"exito","datos"=>"Cambie cambiada con exito");
                    }
                    else{
                        $to_return = Array("informacion"=>"error","datos"=>"Problemas para cambiar la clave");
                    }
                } catch (Exception $e){
                    $to_return = Array("informacion"=>"error",
                                    "datos"=>$e->getMessage());
                } finally {
                    $pr->close();
                    $mysqli->close();
                }
            }
            return $to_return;
        }


        // METODO PARA RESTABLECER LA CONTRASEÑA - NUEVA CLAVE: Abc12345$
        public function restablecerClave(int $documento, int $estado){
            $mysqli = $this->conectar();
            $to_return = [];
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->$mysqli->connect_error);
            }
            else{
                try{
                    $clave = password_hash("Abc12345$", PASSWORD_DEFAULT);
                    $sql = "UPDATE usuario SET clave_usuario = ?  WHERE documento_usuario = ? AND id_estado = ?";
                    $pr = $mysqli->prepare($sql);
                    $pr->bind_param("sii",$clave,$documento,$estado);
                    $resultado = $pr->execute();
                    
                    if($resultado){
                        $to_return = Array("informacion"=>"exito","datos"=>"La nueva contraseña es Abc12345$");
                    }
                    else{
                        $to_return = Array("informacion"=>"error","datos"=>"Problemas al restablecer la contraseña");
                    }
                } catch (Exception $e){
                    $to_return = Array("informacion"=>"error",
                                    "datos"=>$e->getMessage());
                } finally {
                    $pr->close();
                    $mysqli->close();
                }
            }
            return $to_return;
        }


        // METODO PARA VALIDAR SI EL USUARIO YA SE LOGEO
        private function validar_lista_conectados($correoL){
            $log = new Logeo();
            $correo_logeado = $log->buscarCorreo($correoL);
            if($correo_logeado){
                $to_return = "error";
            }
            else{
                $to_return = "exito";
                $log->insertarCorreo($correoL);
            }
            return $to_return;
        }


        // METODO PARA VALIDAR SI ELIMINAR EL USUARIO CUANDO SE DESLOGUE
        public function eliminar_lista_conectados($correoL){
            $log = new Logeo();
            $log->eliminarCorreo($correoL);
        }


        // METODO PARA BUSCAR UN USUARIO DEL LOGIN
        public function buscarUsuario(string $correoL, string $claveL){

            $to_return = Array("informacion"=>"error","datos"=>"El usuario y/o la contraseña son incorrectos.");
            $mysqli = $this->conectar();
            
            $pr = $mysqli->prepare("CALL buscarUsuario(?)");
            $pr->bind_param("s",$correoL);
            $pr->execute();
            // OBTENEMOS RESULTADO DEL PROCEDIMIENTO ALMACENADO (COLUMNAS DE TABLA A TRAVES DE SELECT)
            mysqli_stmt_bind_result($pr,$nombre,$clave,$rol_name); // VINCULAMOS LAS VARIABLES CON EL PS SEGUN SU ORDEN DE SALIDA EN MYSQL
            
            // OBTENEMOS EL VALOR DE LAS COLUMNAS DEL RESULTADO
            if (mysqli_stmt_fetch($pr) && $clave != NULL) {

                // EVALUAMOS QUE LAS CONTRASEÑAS SEAN IGUALES
                $usuario = new UsuarioVO();
                $usuario->setClave($clave);
                $equal = $usuario->validarClave($claveL);

                // SI SON IGUALES ENTONCES......
                if($equal){

                    // VALIDAMOS QUE ESE CORREO YA NO APAREZCA LOGEADO
                    $conectado = $this->validar_lista_conectados($correoL);
                    if($conectado == "error"){
                        $to_return = Array("informacion"=>$conectado,"datos"=>"El usuario ya se encuentra realizando un proceso.");
                    }
                    else{
                        if($claveL == "Abc12345$"){
                            $datos = Array("nombre"=>$nombre,"rol"=>$rol_name, "clave"=>"reject");
                        }
                        else{
                            $datos = Array("nombre"=>$nombre,"rol"=>$rol_name, "clave"=>"ok");
                        }
                        
                        $to_return = Array("informacion"=>$conectado, "datos"=>$datos);
                    }
                }
            }
            $pr->close();
            $mysqli->close();
            return $to_return;
        }
    }
?>