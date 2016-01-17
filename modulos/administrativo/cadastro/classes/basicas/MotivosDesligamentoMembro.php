<?php
    // codificaçao utf-8
    class MotivosDesligamentoMembro{
        private $pessoa;                
        private $motivo;
        private $descricao;
        private $data;
        
        public function getPessoa() {
            return $this->pessoa;
        }

        public function getMotivo() {
            return $this->motivo;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getData() {
            return $this->data;
        }

        public function setPessoa($pessoa) {
            $this->pessoa = $pessoa;
        }

        public function setMotivo($motivo) {
            $this->motivo = $motivo;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setData($data) {
            $this->data = $data;
        }

        
    }
?>