<?php
    // codificaçao utf-8
    class DadosEclesiasticos{
        private $id;                
        private $membro;
        private $data;
        private $dataAceito;
        private $igrejaNome;
        private $igrejaCidade;
        private $igrejaUf;
        private $igrejaPastor;
        private $ano;
        private $tipo;
        private $numeroAta;
        
        public function getId() {
            return $this->id;
        }

        public function getMembro() {
            return $this->membro;
        }

        public function getData() {
            return $this->data;
        }

        public function getDataAceito() {
            return $this->dataAceito;
        }

        public function getIgrejaNome() {
            return $this->igrejaNome;
        }

        public function getIgrejaCidade() {
            return $this->igrejaCidade;
        }

        public function getIgrejaUf() {
            return $this->igrejaUf;
        }

        public function getIgrejaPastor() {
            return $this->igrejaPastor;
        }

        public function getAno() {
            return $this->ano;
        }

        public function getTipo() {
            return $this->tipo;
        }

        public function getNumeroAta() {
            return $this->numeroAta;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setMembro($membro) {
            $this->membro = $membro;
        }

        public function setData($data) {
            $this->data = $data;
        }

        public function setDataAceito($dataAceito) {
            $this->dataAceito = $dataAceito;
        }

        public function setIgrejaNome($igrejaNome) {
            $this->igrejaNome = $igrejaNome;
        }

        public function setIgrejaCidade($igrejaCidade) {
            $this->igrejaCidade = $igrejaCidade;
        }

        public function setIgrejaUf($igrejaUf) {
            $this->igrejaUf = $igrejaUf;
        }

        public function setIgrejaPastor($igrejaPastor) {
            $this->igrejaPastor = $igrejaPastor;
        }

        public function setAno($ano) {
            $this->ano = $ano;
        }

        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }

        public function setNumeroAta($numeroAta) {
            $this->numeroAta = $numeroAta;
        }


        
    }
?>