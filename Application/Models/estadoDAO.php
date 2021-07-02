<?php
    require_once 'conexionBD.php';
    require_once 'estadoVO.php';

    class EstadoDAO extends ConexionBD{
        function verTodosEstados(){
            $to_return = [];
            $array_estado = array();
            $mysqli = $this->conectar();
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->connect_error);
            }
            else{
                $sql = "SELECT * FROM estado";
                $resultado = $mysqli->query($sql);
                
                if($resultado->num_rows > 0){
                    while($row = $resultado->fetch_assoc()){
                        $estado = new EstadoVO();
                        $estado->setEstado($row["id_estado"], $row["nombre_estado"]);
                        $array_estado[] = $estado;
                    }
                    $to_return = $array_estado;
                }
                else{
                    $to_return = null;
                }
                $mysqli->close();
                $resultado->close();
            }
            return $to_return;
        }

        function buscarEstado(int $idIn){
            $mysqli = $this->conectar();
            if ($mysqli->connect_errno) {
                $resultado = null;
            }
            else{
                $sql = "SELECT nombre_estado FROM estado WHERE id_estado=?";
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