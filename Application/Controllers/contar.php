<?php
    class Logeo{
        var $nombre_fichero = "../Assets/docs/numero.txt";
        var $array;

        function actualizarArray(){
            $archivo = fopen($this->nombre_fichero,"r");
            $this->array = file($this->nombre_fichero, FILE_IGNORE_NEW_LINES);
            fclose($archivo);
        }

        function insertarCorreo(string $correoL){
            $archivo = fopen($this->nombre_fichero,"a");
            if($archivo){
                $actual = file_get_contents($this->nombre_fichero);
                $actual .= $correoL.PHP_EOL;
                file_put_contents($this->nombre_fichero,$actual);
            }
            fclose($archivo);
        }

        function buscarCorreo(string $correoL){
            $equal = false;
            $this->actualizarArray();
            foreach($this->array as $correo){
                if($correo == $correoL){
                    $equal = true;
                }
            }
            return $equal;
        }

        function eliminarCorreo(string $correoL){
            $result = $this->buscarCorreo($correoL);
            if($result){
                $archivo = fopen($this->nombre_fichero,"w+");
                fclose($archivo);

                for($i = 0; $i < count($this->array); $i++){
                    if($this->array[$i] != $correoL){
                        $this->insertarCorreo($this->array[$i]);
                    }
                }
            }
            return $result;
        }

        function imprimirArchivo(){
            $this->actualizarArray();
            echo "--------------- ARCHIVO TXT ----------------"."<br>";
            foreach($this->array as $correo){echo $correo."<br>";}
            echo "-------------------------- --------------------------";
        }
    }

    
?>