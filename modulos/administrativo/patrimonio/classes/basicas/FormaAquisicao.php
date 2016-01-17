<?php
    // codificação utf-8
    class FormaAquisicao{
        private $Id;
        private $Descricao;
        private $Status;
        
        public function __construct() {}

        public  function getId() {
            return $this->Id;
        }

        public function getDescricao() {
            return $this->Descricao;
        }

        public function getStatus() {
            return $this->Status;
        }

        public function setId($Id) {
            $this->Id = $Id;
        }

        public function setDescricao($Descricao) {
            $this->Descricao = $Descricao;
        }

        public function setStatus($Status) {
            $this->Status = $Status;
        }
          
    }
?>