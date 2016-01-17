<?php
    // codificação utf-8
    class FluxoCaixa{
        private $id;
        private $historico;
        private $centroCusto;
        private $planoConta;        
        private $pessoa; 
        private $fornecedor;
        private $formaPagamento;
        private $data;
        private $valor;        
        private $observacao;
        private $referencia;
        private $tipo;
                
        public function __construct() {}
        
        public  function getId() {
            return $this->id;
        }
        public function setId($id) {
            $this->id = $id;
        }
        
        public  function getHistorico() {
            return $this->historico;
        }
        public function setHistorico($historico) {
            $this->historico = $historico;
        }

        public function getCentroCusto() {
            return $this->centroCusto;
        }
        public function setCentroCusto($centroCusto) {
            $this->centroCusto = $centroCusto;
        }
        
        public function getPlanoConta() {
            return $this->planoConta;
        }
        public function setPlanoConta($planoConta) {
            $this->planoConta = $planoConta;
        }
        
        public function getContaBancaria() {
            return $this->contaBancaria;
        }
        public function setContaBancaria($contaBancaria) {
            $this->contaBancaria = $contaBancaria;
        }
        
        public function getPessoa() {
            return $this->pessoa;
        }
        public function setPessoa($pessoa) {
            $this->pessoa = $pessoa;
        }

        public function getFornecedor() {
            return $this->fornecedor;
        }
        public function setFornecedor($fornecedor) {
            $this->fornecedor = $fornecedor;
        }
        
        public function getFormaPagamento(){
            return $this->formaPagamento;
        }        
        public function setFormaPagamento($formaPagamento){
            $this->formaPagamento = $formaPagamento;
        }
        
        public function getData() {
            return $this->data;
        }
        public function setData($data) {
            $this->data = $data;
        }
        
        public function getValor() {
            return $this->valor;
        }
        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function getObservacao() {
            return $this->observacao;
        }
        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }

        public function getReferencia() {
            return $this->referencia;
        }
        public function setReferencia($referencia) {
            $this->referencia = $referencia;
        }
        
        public function getTipo() {
            return $this->tipo;
        }
        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }
    }
?>
