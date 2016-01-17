<?php
    // codificação utf-8
    class PessoaTelefone{
        private $id;
        private $pessoa;        
        private $numero;
        private $operadora;
        private $contato;
        
        public function getId() {
            return $this->id;
        }

        public function getPessoa() {
            return $this->pessoa;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getOperadora() {
            return $this->operadora;
        }

        public function getContato() {
            return $this->contato;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setPessoa($pessoa) {
            $this->pessoa = $pessoa;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function setOperadora($operadora) {
            $this->operadora = $operadora;
        }

        public function setContato($contato) {
            $this->contato = $contato;
        }



    }
?>