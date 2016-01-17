<?php
    // codificação utf-8
    class FormaPagamento{
        private $id;
        private $descricao;        
        private $status;
        private $exigeNumero;
        
        public function __construct() {}
        
        public  function getId() {
            return $this->id;
        }
        public function getDescricao() {
            return $this->descricao;
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
        public function setStatus($status) {
            $this->status = $status;
        }  
        
        public function getExigeNumero() {
            return $this->exigeNumero;
        }

        public function setExigeNumero($exigeNumero) {
            $this->exigeNumero = $exigeNumero;
        }


    }
?>
