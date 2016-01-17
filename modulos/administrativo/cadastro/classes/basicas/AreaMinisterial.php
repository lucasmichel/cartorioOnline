<?php
    // codificação utf-8
    class AreaMinisterial{
        private $id;
        private $descricao;
        private $status;
        
        public function getId() {
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

    }
?>