<?php
    // codificação utf-8
    class DiaSemana{
        private $intId;
        private $strDescricao;
        private $strStatus;

        public function __construct() {}

        public function setId($intId){
            $this->intId = $intId;
        }

        public function getId(){
            return $this->intId;
        }

        public function setDescricao($strDescricao){
            $this->strDescricao = $strDescricao;
        }

        public function getDescricao(){
            return $this->strDescricao;
        }

        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }

        public function getStatus(){
            return $this->strStatus;
        }
    }
?>
