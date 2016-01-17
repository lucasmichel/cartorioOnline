<?php
    // codificação utf-8
    class Familia{
        private $PessoaPrimarioId;// pai
        private $PessoaPrimarioNome;// pai
        private $PessoaSecundarioId;// filho
        private $PessoaSecundarioNome;// filho
        private $grauParentesco;
        private $PessoaSecundarioFoto;

        public function __construct() {}

        
        public  function getPessoaPrimarioId() {
            return $this->PessoaPrimarioId;
        }

        public function getPessoaPrimarioNome() {
            return $this->PessoaPrimarioNome;
        }

        public function getPessoaSecundarioId() {
            return $this->PessoaSecundarioId;
        }

        public function getPessoaSecundarioNome() {
            return $this->PessoaSecundarioNome;
        }

        public function getGrauParentesco() {
            return $this->grauParentesco;
        }
        
        public function getPessoaSecundarioFoto(){
            return $this->PessoaSecundarioFoto;
        }

        public function setPessoaPrimarioId($PessoaPrimarioId) {
            $this->PessoaPrimarioId = $PessoaPrimarioId;
        }

        public function setPessoaPrimarioNome($PessoaPrimarioNome) {
            $this->PessoaPrimarioNome = $PessoaPrimarioNome;
        }

        public function setPessoaSecundarioId($PessoaSecundarioId) {
            $this->PessoaSecundarioId = $PessoaSecundarioId;
        }

        public function setPessoaSecundarioNome($PessoaSecundarioNome) {
            $this->PessoaSecundarioNome = $PessoaSecundarioNome;
        }

        public function setGrauParentesco($grauParentesco) {
            $this->grauParentesco = $grauParentesco;
        }

        public function setPessoaSecundarioFoto($PessoaSecundarioFoto){
            $this->PessoaSecundarioFoto = $PessoaSecundarioFoto;
        }
    }
?>
