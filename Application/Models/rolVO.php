<?php
    class Rol{
        var $id;
        var $nombre;

        function __construct(int $id, $nombre)
        {
            $this->id = $id;
            $this->nombre = $nombre;
        }

        // GETTERS METHODS ----------------------------------------------

        public function getId(){
            return $this->id;
        }

        public function getNombre(){
            return $this->nombre;
        }
    }
?>