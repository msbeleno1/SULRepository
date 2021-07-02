<?php
    require_once 'usuarioVO.php';  
    class EstudianteVO extends UsuarioVO{

        var $nota1;
        var $nota2;
        var $nota3;
        var $nota4;
        var $nota_final;

        public function __construct()
        {
            $this->nota1 = 0.0;
            $this->nota2 = 0.0;
            $this->nota3 = 0.0;
            $this->nota4 = 0.0;
            $this->nota_final = 0.0;
        }


        // GETTER METHODS ----------------------------------------------

        function getNombresEst(){
            return $this->nombres;
        }

        function getCorreoEst(){
            return $this->correo;
        }

        function getDocumentoEst(){
            return $this->documento;
        }

        function getNota1(){
            return $this->nota1;
        }

        function getNota2(){
            return $this->nota2;
        }

        function getNota3(){
            return $this->nota3;
        }

        function getNota4(){
            return $this->nota4;
        }

        function getNota_final(){
            return $this->nota_final;
        }



        // SETTER METHODS ----------------------------------------------
        
        function setNombresEst(string $nombres){
            $this->nombres = $nombres;
        }

        function setCorreoEst(string $correo){
            $this->correo = $correo;
        }

        function setDocumentoEst(string $documento){
            $this->documento = $documento;
        }        
        
        function setNota1(float $nota){
            $this->nota1 = $nota;
        }

        function setNota2(float $nota){
            $this->nota2 = $nota;
        }

        function setNota3(float $nota){
            $this->nota3 = $nota;
        }

        function setNota4(float $nota){
            $this->nota4 = $nota;
        }

        function setNota_final(float $nota){
            $this->nota_final = $nota;
        }
    }
?>