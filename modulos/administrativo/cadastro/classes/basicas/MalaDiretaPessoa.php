<?php
    // codificaçao utf-8
    class MalaDiretaPessoa{
        private $id;
        private $pessoa;                
        private $malaDireta;
        private $dataEnvio;
        private $dataVisualizacao;
        
        public function getId() {
            return $this->id;
        }

        public function getPessoa() {
            return $this->pessoa;
        }

        public function getMalaDireta() {
            return $this->malaDireta;
        }

        public function getDataEnvio() {
            return $this->dataEnvio;
        }

        public function getDataVisualizacao() {
            return $this->dataVisualizacao;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setPessoa($pessoa) {
            $this->pessoa = $pessoa;
        }

        public function setMalaDireta($malaDireta) {
            $this->malaDireta = $malaDireta;
        }

        public function setDataEnvio($dataEnvio) {
            $this->dataEnvio = $dataEnvio;
        }

        public function setDataVisualizacao($dataVisualizacao) {
            $this->dataVisualizacao = $dataVisualizacao;
        }
        
    }
?>