<?php
    require_once 'rolVO.php';
    require_once 'conexionBD.php'; 

    class RolDAO extends ConexionBD{
        function verTodosRoles(){
            $to_return = [];
            $array_rol = array();
            $mysqli = $this->conectar();
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->connect_error);
            }
            else{
                $sql = "SELECT * FROM rol";
                $resultado = $mysqli->query($sql);
                
                if($resultado->num_rows > 0){
                    while($row = $resultado->fetch_assoc()){
                        $rol = new Rol(intval($row["id_rol"]), $row["nombre_rol"]);
                        $array_rol[] = $rol;
                    }
                    $to_return = $array_rol;
                }
                else{
                    $to_return = null;
                }
                $mysqli->close();
                $resultado->close();
            }
            return $to_return;
        }

        function buscarRol(int $idIn){
            $mysqli = $this->conectar();
            if ($mysqli->connect_errno) {
                $resultado = null;
            }
            else{
                $sql = "SELECT nombre_rol FROM rol WHERE id_rol=?";
                $pr = $mysqli->prepare($sql);
                $pr->bind_param("i",$idIn);
                $pr->execute();
                $pr->bind_result($resultado);
                $pr->fetch();

                $mysqli->close();
                $pr->close();
            }
            return $resultado;
        }
    }
?>