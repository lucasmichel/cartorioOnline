<?php
    // codificação utf-8
    class ContaTransferencia{
        private $id;
        private $dataHoraCadastro;
        private $dataTransferencia;
        private $valor;
        private $contaTransferenciaDe;
        private $contaTransferenciaPara;
        private $usuarioCadastro;
        
        public function getId() {
            return $this->id;
        }

        public function getDataHoraCadastro() {
            return $this->dataHoraCadastro;
        }

        public function getDataTransferencia() {
            return $this->dataTransferencia;
        }

        public function getValor() {
            return $this->valor;
        }

        public function getContaTransferenciaDe() {
            return $this->contaTransferenciaDe;
        }

        public function getContaTransferenciaPara() {
            return $this->contaTransferenciaPara;
        }

        public function getUsuarioCadastro() {
            return $this->usuarioCadastro;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setDataHoraCadastro($dataHoraCadastro) {
            $this->dataHoraCadastro = $dataHoraCadastro;
        }

        public function setDataTransferencia($dataTransferencia) {
            $this->dataTransferencia = $dataTransferencia;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function setContaTransferenciaDe($contaTransferenciaDe) {
            $this->contaTransferenciaDe = $contaTransferenciaDe;
        }

        public function setContaTransferenciaPara($contaTransferenciaPara) {
            $this->contaTransferenciaPara = $contaTransferenciaPara;
        }

        public function setUsuarioCadastro($usuarioCadastro) {
            $this->usuarioCadastro = $usuarioCadastro;
        }



    }
?>
