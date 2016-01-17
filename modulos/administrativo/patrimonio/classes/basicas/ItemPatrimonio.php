<?php
    // codificação utf-8
    class ItemPatrimonio{
        private $id;
        private $descricao;
        private $tipoPatrimonio;
        private $status;
        private $percentualDepreciacao;
        
        public function getId() {
            return $this->id;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getTipoPatrimonio() {
            return $this->tipoPatrimonio;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getPercentualDepreciacao() {
            return $this->percentualDepreciacao;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setTipoPatrimonio($tipoPatrimonio) {
            $this->tipoPatrimonio = $tipoPatrimonio;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

        public function setPercentualDepreciacao($percentualDepreciacao) {
            $this->percentualDepreciacao = $percentualDepreciacao;
        }


    }
?>