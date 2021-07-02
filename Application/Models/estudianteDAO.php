<?php
    require_once 'estudianteVO.php';
    require_once 'conexionBD.php'; 

    class EstudianteDAO extends ConexionBD{
        function verTodosEstudiantes(){
            $to_return = [];
            $array_estudiante = array();
            $mysqli = $this->conectar();
            if ($mysqli->connect_errno) {
                $to_return = Array("informacion"=>"error",
                                    "datos"=>$mysqli->connect_error);
            }
            else{
                $sql = "SELECT * FROM estudiante";
                $resultado = $mysqli->query($sql);
                
                if($resultado->num_rows > 0){
                    while($row = $resultado->fetch_assoc()){
                        $estudiante = new EstudianteVO();
                        $estudiante->setDocumentoEst($row["documento_estudiante"]);
                        $estudiante->setNombresEst($row["nombre_estudiante"]);
                        $estudiante->setCorreoEst($row["correo_estudiante"]);
                        $estudiante->setNota1(floatval($row["nota_1"]));
                        $estudiante->setNota2(floatval($row["nota_2"]));
                        $estudiante->setNota3(floatval($row["nota_3"]));
                        $estudiante->setNota4(floatval($row["nota_4"]));
                        $estudiante->setNota_final(floatval($row["nota_final"]));
                        $array_estudiante[] = $estudiante;
                    }
                    $to_return =  $array_estudiante;
                }
                else{
                    $to_return = null;
                }
                $mysqli->close();
                $resultado->close();
            }
            return $to_return;
        }

        function actualizarNotas(EstudianteVO $est){
            $mysqli = $this->conectar();
            if ($mysqli->connect_errno) {
                $resultado = null;
            }
            else{
                $nota1 = $est->getNota1();
                $nota2 = $est->getNota2();
                $nota3 = $est->getNota3();
                $nota4 = $est->getNota4();
                $nota_final = $est->getNota_final();
                $documento = $est->getDocumento();
                $sql = "UPDATE estudiante SET nota_1=?, nota_2=?, nota_3=?, nota_4=?, nota_final=? WHERE documento_estudiante = ?";
                $pr = $mysqli->prepare($sql);
                $pr->bind_param("ddddds",$nota1,$nota2,$nota3,$nota4,$nota_final,$documento);
                $resultado = $pr->execute();

                if($resultado){
                    $resultado = Array("informacion"=>"exito","datos"=>"Notas actualizadas");
                }
                else{
                    $resultado = Array("informacion"=>"error","datos"=>"Error al actualizar notas. Por favor intente nuevamente");
                }

                $mysqli->close();
                $pr->close();
            }
            return $resultado;
        }

        // METODO PARA BUSCAR LAS NOTAS DE UN ESTUDIANTE
        public function buscarNotas(string $nombreE){

            $to_return = Array("informacion"=>"error","datos"=>"El estudiante no tiene notas");
            $mysqli = $this->conectar();

            $pr = $mysqli->prepare("SELECT nota_1, nota_2, nota_3, nota_4, nota_final FROM estudiante WHERE nombre_estudiante = ?");
            $pr->bind_param("s",$nombreE);
            $pr->execute();
            // OBTENEMOS RESULTADO DEL PROCEDIMIENTO ALMACENADO (COLUMNAS DE TABLA A TRAVES DE SELECT)
            mysqli_stmt_bind_result($pr,$nota1,$nota2,$nota3,$nota4,$nota_final); // VINCULAMOS LAS VARIABLES CON EL PS SEGUN SU ORDEN DE SALIDA EN MYSQL
            
            // OBTENEMOS EL VALOR DE LAS COLUMNAS DEL RESULTADO
            while (mysqli_stmt_fetch($pr)) {

                $datos = Array("nota1"=>floatval($nota1), "nota2"=>floatval($nota2), 
                                "nota3"=>floatval($nota3), "nota4"=>floatval($nota4), "nota_final"=>floatval($nota_final));

                $to_return = Array("informacion"=>"exito", "datos"=>$datos);
            }
            $pr->close();
            $mysqli->close();
            return $to_return;
        }
    }
?>