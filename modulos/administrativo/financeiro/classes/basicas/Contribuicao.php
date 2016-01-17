<?php
    // codificaçãoo utf-8
    class Contribuicao{
        private $id;
        private $centroCusto;
        private $planoConta;
        private $contaBancaria;        
        private $pessoa;    
        private $formaPagamento;
        private $data;
        private $valor;        
        private $observacao;
        private $referencia;
        private $lote;
        
        public function getId() {
            return $this->id;
        }

        public function getCentroCusto() {
            return $this->centroCusto;
        }

        public function getPlanoConta() {
            return $this->planoConta;
        }

        public function getContaBancaria() {
            return $this->contaBancaria;
        }

        public function getPessoa() {
            return $this->pessoa;
        }

        public function getFormaPagamento() {
            return $this->formaPagamento;
        }

        public function getData() {
            return $this->data;
        }

        public function getValor() {
            return $this->valor;
        }

        public function getObservacao() {
            return $this->observacao;
        }

        public function getReferencia() {
            return $this->referencia;
        }

        public function getLote() {
            return $this->lote;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setCentroCusto($centroCusto) {
            $this->centroCusto = $centroCusto;
        }

        public function setPlanoConta($planoConta) {
            $this->planoConta = $planoConta;
        }

        public function setContaBancaria($contaBancaria) {
            $this->contaBancaria = $contaBancaria;
        }

        public function setPessoa($pessoa) {
            $this->pessoa = $pessoa;
        }

        public function setFormaPagamento($formaPagamento) {
            $this->formaPagamento = $formaPagamento;
        }

        public function setData($data) {
            $this->data = $data;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }

        public function setReferencia($referencia) {
            $this->referencia = $referencia;
        }

        public function setLote($lote) {
            $this->lote = $lote;
        }
        
    }
?>
