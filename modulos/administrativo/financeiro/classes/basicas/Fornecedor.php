<?php
    // codificação utf-8
    class Fornecedor{
        private $id;
        private $banco;
        private $membro;
        private $nomeFantasia;
        private $razaoSocial;
        private $endereco;
        private $CNPJ;
        private $InscricaoEstadual;
        private $DataFundacao;
        private $ramoAtividade; 
        private $agencia;
        private $conta;        
        private $site;
        private $observacao;
        private $tipo;
        private $status;
        
        public function getId() {
            return $this->id;
        }

        public function getBanco() {
            return $this->banco;
        }

        public function getMembro() {
            return $this->membro;
        }

        public function getNomeFantasia() {
            return $this->nomeFantasia;
        }

        public function getRazaoSocial() {
            return $this->razaoSocial;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getCNPJ() {
            return $this->CNPJ;
        }

        public function getInscricaoEstadual() {
            return $this->InscricaoEstadual;
        }

        public function getDataFundacao() {
            return $this->DataFundacao;
        }

        public function getRamoAtividade() {
            return $this->ramoAtividade;
        }

        public function getAgencia() {
            return $this->agencia;
        }

        public function getConta() {
            return $this->conta;
        }

        public function getSite() {
            return $this->site;
        }

        public function getObservacao() {
            return $this->observacao;
        }

        public function getTipo() {
            return $this->tipo;
        }

        public function getStatus() {
            return $this->status;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setBanco($banco) {
            $this->banco = $banco;
        }

        public function setMembro($membro) {
            $this->membro = $membro;
        }

        public function setNomeFantasia($nomeFantasia) {
            $this->nomeFantasia = $nomeFantasia;
        }

        public function setRazaoSocial($razaoSocial) {
            $this->razaoSocial = $razaoSocial;
        }

        public function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        public function setCNPJ($CNPJ) {
            $this->CNPJ = $CNPJ;
        }

        public function setInscricaoEstadual($InscricaoEstadual) {
            $this->InscricaoEstadual = $InscricaoEstadual;
        }

        public function setDataFundacao($DataFundacao) {
            $this->DataFundacao = $DataFundacao;
        }

        public function setRamoAtividade($ramoAtividade) {
            $this->ramoAtividade = $ramoAtividade;
        }

        public function setAgencia($agencia) {
            $this->agencia = $agencia;
        }

        public function setConta($conta) {
            $this->conta = $conta;
        }

        public function setSite($site) {
            $this->site = $site;
        }

        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }

        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }

        public function setStatus($status) {
            $this->status = $status;
        }
        
    }
?>