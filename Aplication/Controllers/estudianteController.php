<?php
    require_once '../Models/estudianteDAO.php';
    require_once '../Models/estudianteVO.php';

    if(isset($_POST["opcion"]) && !empty($_POST["opcion"])){
        $opcion = $_POST["opcion"];
        $estudianteDAO = new EstudianteDAO();
        $to_return = [];

        if($opcion == "edit"){
            if(isset($_POST["txtDocumento"]) && isset($_POST["txtNombres"]) && isset($_POST["txtNota1"]) && 
                isset($_POST["txtNota2"]) && isset($_POST["txtNota3"]) && isset($_POST["txtNota4"]) && 
                isset($_POST["txtNotaFinal"])){
                $est = new EstudianteVO();
                $est->setDocumento($_POST["txtDocumento"]);
                $est->setNota1(floatval($_POST["txtNota1"]));
                $est->setNota2(floatval($_POST["txtNota2"]));
                $est->setNota3(floatval($_POST["txtNota3"]));
                $est->setNota4(floatval($_POST["txtNota4"]));
                $est->setNota_final(floatval($_POST["txtNotaFinal"]));
                $to_return = $estudianteDAO->actualizarNotas($est);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Problemas al actualizar las notas. Intente nuevamente";
            }
            $to_return["dataTable"] = $estudianteDAO->verTodosEstudiantes();
        }
        else if($opcion == "verNotas"){
            if(isset($_POST["nombre"])){
                $nombre = $_POST["nombre"];
                $to_return = $estudianteDAO->buscarNotas($nombre);
            }
            else{
                $to_return["informacion"] = "error";
                $to_return["datos"] = "Problemas al consultar notas. Intente nuevamente";
            }
        }

        else if($opcion == "actualizar"){
            $to_return["dataTable"] = $estudianteDAO->verTodosEstudiantes();
        }

        $to_return = json_encode($to_return, JSON_UNESCAPED_UNICODE);
        echo $to_return;
    }    
?>