<?php
    // codificaçao utf-8
    class Congregacao{
        private $id;                
        private $descricao;
        private $endereco;
        private $telefone;
        private $fax;
        private $status;
        private $observacao;
        private $responsavel;
        
        public function getStatus() {
            return $this->status;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

                public function getId() {
            return $this->id;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getTelefone() {
            return $this->telefone;
        }

        public function getFax() {
            return $this->fax;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function setFax($fax) {
            $this->fax = $fax;
        }
 
        public function setObservacao($observacao){
            $this->observacao = $observacao;
        }
        
        public function getObservacao(){
            return $this->observacao;
        }
        
        public function setResponsavel($responsavel){
            $this->responsavel = $responsavel;
        }
        
        public function getResponsavel(){
            return $this->responsavel;
        }
    }
?>