<?php
    // codificação utf8
    class ParcelaContaPagarReceber{
        private $id;
        private $formaPagamento;
        private $contaBancaria;
        private $dataVencimento;
        private $dataBaixa;
        private $valor;
        private $juros;
        private $mora;
        private $multa;
        private $desconto;
        private $numero;
        private $formaPagamentoNumero; // em caso de cheque, informar o número do cheque
        private $valorPago;
        private $referencia;
        private $anexoArquivo;
        
        public function __construct() {}
        
        public function getId() {
            return $this->id;
        }

        public function getFormaPagamento() {
            return $this->formaPagamento;
        }

        public function getContaBancaria() {
            return $this->contaBancaria;
        }

        public function getDataVencimento() {
            return $this->dataVencimento;
        }

        public function getDataBaixa() {
            return $this->dataBaixa;
        }

        public function getValor() {
            return $this->valor;
        }

        public function getJuros() {
            return $this->juros;
        }

        public function getMora() {
            return $this->mora;
        }

        public function getMulta() {
            return $this->multa;
        }

        public function getDesconto() {
            return $this->desconto;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getFormaPagamentoNumero() {
            return $this->formaPagamentoNumero;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setFormaPagamento($formaPagamento) {
            $this->formaPagamento = $formaPagamento;
        }

        public function setContaBancaria($contaBancaria) {
            $this->contaBancaria = $contaBancaria;
        }

        public function setDataVencimento($dataVencimento) {
            $this->dataVencimento = $dataVencimento;
        }

        public function setDataBaixa($dataBaixa) {
            $this->dataBaixa = $dataBaixa;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function setJuros($juros) {
            $this->juros = $juros;
        }

        public function setMora($mora) {
            $this->mora = $mora;
        }

        public function setMulta($multa) {
            $this->multa = $multa;
        }

        public function setDesconto($desconto) {
            $this->desconto = $desconto;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function setFormaPagamentoNumero($formaPagamentoNumero) {
            $this->formaPagamentoNumero = $formaPagamentoNumero;
        }

        public function setValorPago($valoPago){
            $this->valorPago = $valoPago;
        }
        
        public function getValorPago(){
            return $this->valorPago;
        }
        
        public function setReferencia($referencia){
            $this->referencia = $referencia;
        }
        
        public function getReferencia(){
            return $this->referencia;
        }
        
        public function getAnexoArquivo() {
            return $this->anexoArquivo;
        }

        public function setAnexoArquivo($anexoArquivo) {
            $this->anexoArquivo = $anexoArquivo;
        }

    }
?>