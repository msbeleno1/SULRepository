<?php 

    class EstadoVO{
        var $id;
        var $nombre;

        public function __construct(){
            $this->id = 0;
            $this->nombre = "";
        }

        // GETTERS METHODS ----------------------------------------------

        public function getId(){
            return $this->id;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setEstado(string $id, string $nombre){
            $this->id = intval($id);
            $this->nombre = strtoupper($nombre);
        }
    }
?>