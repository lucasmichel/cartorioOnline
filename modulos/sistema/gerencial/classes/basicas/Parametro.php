<?php
    // codificação utf-8
    class Parametro{        
        private $cnpj;
        private $razaoSocial;
        private $nomeFantasia;
        private $denominacao;
        private $dataFundacao;
        private $site;
        private $pastor;
        private $enderecoLogradouro;
        private $enderecoNumero;
        private $enderecoComplemento;
        private $enderecoBairro;
        private $enderecoCidade;
        private $enderecoUf;
        private $enderecoCep;
        private $logo;
        private $totFolhaLivro;
        private $totLinhaFolha;
        
        public function getCnpj() {
            return $this->cnpj;
        }

        public function getRazaoSocial() {
            return $this->razaoSocial;
        }

        public function getNomeFantasia() {
            return $this->nomeFantasia;
        }

        public function getDenominacao() {
            return $this->denominacao;
        }

        public function getDataFundacao() {
            return $this->dataFundacao;
        }

        public function getSite() {
            return $this->site;
        }

        public function getPastor() {
            return $this->pastor;
        }

        public function getEnderecoLogradouro() {
            return $this->enderecoLogradouro;
        }

        public function getEnderecoNumero() {
            return $this->enderecoNumero;
        }

        public function getEnderecoComplemento() {
            return $this->enderecoComplemento;
        }

        public function getEnderecoBairro() {
            return $this->enderecoBairro;
        }

        public function getEnderecoCidade() {
            return $this->enderecoCidade;
        }

        public function getEnderecoUf() {
            return $this->enderecoUf;
        }

        public function getEnderecoCep() {
            return $this->enderecoCep;
        }

        public function setCnpj($cnpj) {
            $this->cnpj = $cnpj;
        }

        public function setRazaoSocial($razaoSocial) {
            $this->razaoSocial = $razaoSocial;
        }

        public function setNomeFantasia($nomeFantasia) {
            $this->nomeFantasia = $nomeFantasia;
        }

        public function setDenominacao($denominacao) {
            $this->denominacao = $denominacao;
        }

        public function setDataFundacao($dataFundacao) {
            $this->dataFundacao = $dataFundacao;
        }

        public function setSite($site) {
            $this->site = $site;
        }

        public function setPastor($pastor) {
            $this->pastor = $pastor;
        }

        public function setEnderecoLogradouro($enderecoLogradouro) {
            $this->enderecoLogradouro = $enderecoLogradouro;
        }

        public function setEnderecoNumero($enderecoNumero) {
            $this->enderecoNumero = $enderecoNumero;
        }

        public function setEnderecoComplemento($enderecoComplemento) {
            $this->enderecoComplemento = $enderecoComplemento;
        }

        public function setEnderecoBairro($enderecoBairro) {
            $this->enderecoBairro = $enderecoBairro;
        }

        public function setEnderecoCidade($enderecoCidade) {
            $this->enderecoCidade = $enderecoCidade;
        }

        public function setEnderecoUf($enderecoUf) {
            $this->enderecoUf = $enderecoUf;
        }

        public function setEnderecoCep($enderecoCep) {
            $this->enderecoCep = $enderecoCep;
        }

        public function getLogo() {
            return $this->logo;
        }

        public function setLogo($logo) {
            $this->logo = $logo;
        }
        
        function getTotFolhaLivro() {
            return $this->totFolhaLivro;
        }

        function getTotLinhaFolha() {
            return $this->totLinhaFolha;
        }

        function setTotFolhaLivro($totFolhaLivro) {
            $this->totFolhaLivro = $totFolhaLivro;
        }

        function setTotLinhaFolha($totLinhaFolha) {
            $this->totLinhaFolha = $totLinhaFolha;
        }


    }
?>
