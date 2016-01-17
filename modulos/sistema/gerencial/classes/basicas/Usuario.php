<?php
    // codificação utf-8
    class Usuario{
        private $intId;
        private $objGrupo;
        private $strLogin;
        private $strSenha;
        private $strDataHoraCadastro;
        private $strTelefone;
        private $strEmail;
        private $strDataHoraUltimoAcesso;
        private $strStatus;
        private $nome;

        public function __construct() {}

        public function setId($intId){
            $this->intId = $intId;
        }

        public function getId(){
            return $this->intId;
        }

        public function setGrupo(Grupo $obj){
            $this->objGrupo = $obj;
        }

        public function getGrupo(){
            return $this->objGrupo;
        }

        public function setLogin($strLogin){
            $this->strLogin = $strLogin;
        }

        public function getLogin(){
            return $this->strLogin;
        }

        public function setSenha($strSenha){
            $this->strSenha = $strSenha;
        }

        public function getSenha(){
            return $this->strSenha;
        }

        public function setDataHoraCadastro($strDataHoraCadastro){
            $this->strDataHoraCadastro = $strDataHoraCadastro;
        }

        public function getDataHoraCadastro(){
            return $this->strDataHoraCadastro;
        }
        
        public function setTelefone($strTelefone){
            $this->strTelefone = $strTelefone;
        }

        public function getTelefone(){
            return $this->strTelefone;
        }
        
        public function setEmail($strEmail){
            $this->strEmail = $strEmail;
        }

        public function getEmail(){
            return $this->strEmail;
        }
        
        public function setDataHoraUltimoAcesso($strDataHoraUltimoAcesso){
            $this->strDataHoraUltimoAcesso = $strDataHoraUltimoAcesso;
        }

        public function getDataHoraUltimoAcesso(){
            return $this->strDataHoraUltimoAcesso;
        } 
        
        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }

        public function getStatus(){
            return $this->strStatus;
        }
        
        public function getNome() {
            return $this->nome;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }


    }
?>