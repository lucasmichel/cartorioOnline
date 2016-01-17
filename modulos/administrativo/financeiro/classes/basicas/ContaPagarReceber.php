<?php
    // codificação utf-8
    class ContaPagarReceber{
        private $id;        
        private $centroCusto;
        private $planoConta;
        private $descricao;        
        private $numero;
        private $observacao;
        private $pessoa; 
        private $fornecedor;
        private $valorTotal;
        private $tipo;
        private $numeroParcelas;
        private $parcelas;
        
        private $foto1;        
        private $arquivo;        
        
        public function getId() {
            return $this->id;
        }

        public function getCentroCusto() {
            return $this->centroCusto;
        }
        
        public function getPlanoConta(){
            return $this->planoConta;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getValorTotal() {
            return $this->valorTotal;
        }

        public function getObservacao() {
            return $this->observacao;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setCentroCusto($centroCusto) {
            $this->centroCusto = $centroCusto;
        }
        
        public function setPlanoConta($planoConta){
            $this->planoConta = $planoConta;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function setValorTotal($valor) {
            $this->valorTotal = $valor;
        }

        public function setObservacao($observacao) {
            $this->observacao = $observacao;
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
        
        public function setTipo($tipo){
            $this->tipo = $tipo;
        }
        
        public function getTipo(){
            return $this->tipo;
        }
        
        public function getParcelas(){
            return $this->parcelas;
        }
        
        public function adicionarParcela($parcela){
            $this->parcelas[count($this->parcelas)] = $parcela;
        }
        public function getNumeroParcelas(){
            return $this->numeroParcelas;
        }
        
        public function setNumeroParcelas($numeroParcelas){
            $this->numeroParcelas= $numeroParcelas;
        }
        
        public function getFoto1() {
            return $this->foto1;
        }

        public function setFoto1($foto1) {
            $this->foto1 = $foto1;
        }
        
        public function getArquivo() {
            return $this->arquivo;
        }

        public function setArquivo($arquivo) {
            $this->arquivo = $arquivo;
        }
        
    }
?>