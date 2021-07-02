<?php 

    class UsuarioVO{
        var $documento;
        var $nombres;
        var $correo;
        var $fecha;
        var $clave;
        var $estado;
        var $estado_name;
        var $rol;
        var $rol_name;

        public function __construct(){
            $this->documento = "";
            $this->nombres = "";
            $this->correo = "";
            $this->fecha = "";
            $this->clave = "";
            $this->estado = 0;
            $this->estado_name = "";
            $this->rol = 0;
            $this->rol_name = "";
        }

        // FUNCIONALS METHODS --------------------------------------------

        public function encryptarClave(){
            $this->clave = password_hash($this->clave, PASSWORD_DEFAULT);
        }

        public function validarClave(string $otraClave){
            return password_verify($otraClave,$this->clave);
        }


        // GETTERS METHODS ----------------------------------------------

        public function getDocumento(){
            return $this->documento;
        }

        public function getNombres(){
            return $this->nombres;
        }

        public function getRol(){
            return $this->rol;
        }

        public function getCorreo(){
            return $this->correo;
        }

        public function getFecha(){
            return $this->fecha;
        }

        public function getClave(){
            return $this->clave;
        }

        public function getEstado(){
            return $this->estado;
        }

        public function getEstado_name(){
            return $this->estado_name;
        }

        public function getRol_name(){
            return $this->rol_name;
        }

        public function setCorreo(string $correo){
            $this->correo = strtolower($correo);
        }

        public function setDocumento(string $documento){
            $this->documento = strtoupper($documento);
        }

        public function setNombres(string $nombres){
            $this->nombres = strtoupper($nombres);
        }

        public function setClave(string $clave){
            $this->clave = $clave;
        }

        public function setEstado_name(string $estado_name){
            $this->estado_name = strtoupper($estado_name);
        }

        public function setRol(int $rol){
            $this->rol = $rol;
        }

        public function setRol_name(string $rol_name){
            $this->rol_name = strtoupper($rol_name);
        }

        public function setUsuario(string $documento, string $nombres, string $correo, string $fecha, string $clave, int $estado, int $rol){
            $this->documento = $documento;
            $this->nombres = strtoupper($nombres);
            $this->correo = strtolower($correo);
            $this->fecha = $fecha;
            $this->clave = $clave;
            $this->estado = $estado;
            $this->rol = $rol;
        }
    }
?>