<?php
    // codificação utf-8
    class CentroCusto{
        private $id;
        private $descricao;
        private $observacao;
        private $status;
        
        public function __construct() {}
        
        public  function getId() {
            return $this->id;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getObservacao() {
            return $this->observacao;
        }

        public function getStatus() {
            return $this->status;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }

        public function setStatus($status) {
            $this->status = $status;
        }


        
    }
?>
