<?php
    include_once "contar.php";
    function escribir(string $mensaje){
        echo "<br>";
        echo $mensaje."<br>";
        echo "<br>";
    }

    $log = new Logeo();
    $log->insertarCorreo("maikol.stally@gmail.com");
    $log->insertarCorreo("algo@algo.com");
    $log->insertarCorreo("algo111@algo111.com");
    $log->insertarCorreo("algo222@algo222.com");
    $log->insertarCorreo("algo333@algo333.com");
    echo $log->imprimirArchivo();
    echo "<br><br>";

    if($log->buscarCorreo("algo@algo.com")){
        echo "Buscar correo: "."Existe"."<br><br>";
    }
    else{
        echo "Buscar correo: "."No existe"."<br><br>";
    }

    echo "<br><br>Eliminar correo: ".$log->eliminarCorreo("algo111@algo111.com")."<br><br>";
    echo $log->imprimirArchivo();
?>