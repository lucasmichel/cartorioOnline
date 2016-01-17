<?php
    // codificação utf-8
    class Membro extends Pessoa{        
        private $areaDeAtuacao;                
        private $statusMembro;               
        private $congregacao;    
        private $rendaSalario;        
        private $empresaNome;
        private $empresaTelefoneComercial;
        private $empresaTelefoneFax;        
        private $enderecoEmpresa;        
        private $temEmprego;
        private $familia;
        private $profissao;
        private $numeroFicha;
        
        private $tipo;
        private $dataInativacao;
        private $motivoInativacao;
        private $descricaoInativacao;
        private $dataDescricaoInativacao;        
        
        public function getAreaDeAtuacao() {
            return $this->areaDeAtuacao;
        }

        public function getStatusMembro() {
            return $this->statusMembro;
        }

        public function getCongregacao() {
            return $this->congregacao;
        }

        public function getRendaSalario() {
            return $this->rendaSalario;
        }

        public function getEmpresaNome() {
            return $this->empresaNome;
        }

        public function getEmpresaTelefoneComercial() {
            return $this->empresaTelefoneComercial;
        }

        public function getEmpresaTelefoneFax() {
            return $this->empresaTelefoneFax;
        }

        public function getEnderecoEmpresa() {
            return $this->enderecoEmpresa;
        }

        public function getTemEmprego() {
            return $this->temEmprego;
        }

        public function getFamilia() {
            return $this->familia;
        }

        public function getProfissao() {
            return $this->profissao;
        }

        public function getNumeroFicha() {
            return $this->numeroFicha;
        }

        public function setAreaDeAtuacao($areaDeAtuacao) {
            $this->areaDeAtuacao = $areaDeAtuacao;
        }

        public function setStatusMembro($statusMembro) {
            $this->statusMembro = $statusMembro;
        }

        public function setCongregacao($congregacao) {
            $this->congregacao = $congregacao;
        }

        public function setRendaSalario($rendaSalario) {
            $this->rendaSalario = $rendaSalario;
        }

        public function setEmpresaNome($empresaNome) {
            $this->empresaNome = $empresaNome;
        }

        public function setEmpresaTelefoneComercial($empresaTelefoneComercial) {
            $this->empresaTelefoneComercial = $empresaTelefoneComercial;
        }

        public function setEmpresaTelefoneFax($empresaTelefoneFax) {
            $this->empresaTelefoneFax = $empresaTelefoneFax;
        }

        public function setEnderecoEmpresa($enderecoEmpresa) {
            $this->enderecoEmpresa = $enderecoEmpresa;
        }

        public function setTemEmprego($temEmprego) {
            $this->temEmprego = $temEmprego;
        }

        public function setFamilia($familia) {
            $this->familia = $familia;
        }

        public function setProfissao($profissao) {
            $this->profissao = $profissao;
        }

        public function setNumeroFicha($numeroFicha) {
            $this->numeroFicha = $numeroFicha;
        }

        public function getTipo() {
            return $this->tipo;
        }

        public function getDataInativacao() {
            return $this->dataInativacao;
        }

        public function getMotivoInativacao() {
            return $this->motivoInativacao;
        }

        public function getDescricaoInativacao() {
            return $this->descricaoInativacao;
        }

        public function getDataDescricaoInativacao() {
            return $this->dataDescricaoInativacao;
        }

        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }

        public function setDataInativacao($dataInativacao) {
            $this->dataInativacao = $dataInativacao;
        }

        public function setMotivoInativacao($motivoInativacao) {
            $this->motivoInativacao = $motivoInativacao;
        }

        public function setDescricaoInativacao($descricaoInativacao) {
            $this->descricaoInativacao = $descricaoInativacao;
        }

        public function setDataDescricaoInativacao($dataDescricaoInativacao) {
            $this->dataDescricaoInativacao = $dataDescricaoInativacao;
        }


        
    }
?>