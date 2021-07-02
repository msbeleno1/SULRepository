<?php
    require_once '../Models/conexionBD.php';
    require_once '../Models/controlLogeo.php';
    require_once '../Models/usuarioVO.php';
    require_once '../Models/usuarioDAO.php';
    require_once '../Models/estadoDAO.php';
    require_once '../Models/rolDAO.php';
    
    if(isset($_POST["opcion"]) && !empty($_POST["opcion"])){
        $opcion = $_POST["opcion"];
        $userDAO = new UsuarioDAO();
        $to_return = [];

        if($opcion == "refresh"){

            if(isset($_POST["txtDocumentoRefresh"]) && isset($_POST["txtEstadoRefresh"])){
                $documento = intval($_POST["txtDocumentoRefresh"]);
                $estado = intval($_POST["txtEstadoRefresh"]);
                $to_return = $userDAO->restablecerClave($documento,$estado);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Problemas al tratar de restablecer la clave.";
            }

            $estateDAO = new EstadoDAO();
            $to_return["selectEstados"] = $estateDAO->verTodosEstados();

            $rolDAO = new RolDAO();
            $to_return["selectRol"] = $rolDAO->verTodosRoles();

            $userDAO = new UsuarioDAO();
            $to_return["dataTable"] = $userDAO->verTodosUsuarios();
        }
        else if($opcion == "login"){
            if(isset($_POST["txtCorreo"]) && isset($_POST["txtClave"])){
                $correo = $_POST["txtCorreo"];
                $clave = $_POST["txtClave"];
                $to_return = $userDAO->buscarUsuario($correo,$clave);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Sin datos";
            }
        }
        else if($opcion == "delete"){;

            if(isset($_POST["txtDocumentoDelete"]) && isset($_POST["txtEstadoDelete"])){
                $documento = intval($_POST["txtDocumentoDelete"]);
                $estado = intval($_POST["txtEstadoDelete"]);
                $to_return = $userDAO->eliminarUsuario($documento,$estado);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Problemas al tratar de restablecer la clave.";
            }

            $estateDAO = new EstadoDAO();
            $to_return["selectEstados"] = $estateDAO->verTodosEstados();

            $rolDAO = new RolDAO();
            $to_return["selectRol"] = $rolDAO->verTodosRoles();

            $userDAO = new UsuarioDAO();
            $to_return["dataTable"] = $userDAO->verTodosUsuarios();
        }

        else if($opcion == "cambiarClave"){
            if(isset($_POST["correo"]) && isset($_POST["txtClave1"])){
                $correo = $_POST["correo"];
                $clave = $_POST["txtClave1"];
                $to_return = $userDAO->cambiarClave($correo,$clave);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Sin datos";
            }
        }

        else if($opcion == "edit"){

            // VALIDAMOS QUE HAYAN SIDO ENVIADOS LOS RESPECTIVOS DATOS DEL USUARIO
            if(isset($_POST["txtDocumento"]) && isset($_POST["txtNombres"]) && isset($_POST["txtRol"]) 
                && isset($_POST["txtCorreo"]) && isset($_POST["txtEstado"])){
                $documento = $_POST["txtDocumento"];
                $nombres = $_POST["txtNombres"];
                $correo = $_POST["txtCorreo"];
                $estado = intval($_POST["txtEstado"]);
                $rol = intval($_POST["txtRol"]);
                $usuario = new UsuarioVO();
                $usuario->setUsuario($documento,$nombres,$correo,"VACIO","VACIO",$estado,$rol);
                $to_return = $userDAO->actualizarUsuario($usuario);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Problemas al tratar de actualizar el usuario.";
            }

            $estateDAO = new EstadoDAO();
            $to_return["selectEstados"] = $estateDAO->verTodosEstados();

            $rolDAO = new RolDAO();
            $to_return["selectRol"] = $rolDAO->verTodosRoles();

            $userDAO = new UsuarioDAO();
            $to_return["dataTable"] = $userDAO->verTodosUsuarios();
        }

        else if($opcion == "create"){

            if(isset($_POST["txtDocumento"]) && isset($_POST["txtNombres"]) && isset($_POST["txtRol"]) 
                && isset($_POST["txtCorreo"]) && isset($_POST["txtClave1"])){
                $documento = $_POST["txtDocumento"];
                $nombres = $_POST["txtNombres"];
                $correo = $_POST["txtCorreo"];
                $clave = $_POST["txtClave1"];
                $estado = 1;
                $rol = intval($_POST["txtRol"]);
                $usuario = new UsuarioVO();
                $usuario->setUsuario($documento,$nombres,$correo,"VACIO",$clave,$estado,$rol);
                $to_return = $userDAO->crearUsuario($usuario);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Problemas al tratar de crear el usuario.";
            }

            $estateDAO = new EstadoDAO();
            $to_return["selectEstados"] = $estateDAO->verTodosEstados();

            $rolDAO = new RolDAO();
            $to_return["selectRol"] = $rolDAO->verTodosRoles();

            $userDAO = new UsuarioDAO();
            $to_return["dataTable"] = $userDAO->verTodosUsuarios();
        }

        else if($opcion == "actualizar"){
            $estateDAO = new EstadoDAO();
            $to_return["selectEstados"] = $estateDAO->verTodosEstados();

            $rolDAO = new RolDAO();
            $to_return["selectRol"] = $rolDAO->verTodosRoles();

            $userDAO = new UsuarioDAO();
            $to_return["dataTable"] = $userDAO->verTodosUsuarios();
        }

        $to_return = json_encode($to_return, JSON_UNESCAPED_UNICODE);
        echo $to_return;
    }
    else{
        if(isset($_GET["correo"]) && !empty($_GET["correo"])){
            $correo = $_GET["correo"];
            $userDAO = new UsuarioDAO();
            $userDAO->eliminar_lista_conectados($correo);
            echo "Eliminado";
        }
    }
?>