<?php
    // codificação utf-8
    class Funcionario extends Pessoa{                       
        private $idFuncionario;                
        private $membroFuncionario;                
        private $dataAdmissao;
        private $dataSaida;
        private $funcao;
        private $salario;
        private $cargaHoraria;
        private $horarioEntrada;
        private $horarioSaida;
        private $cnhNumero;
        private $carteiraTrabalhoNumero;
        
        public function getIdFuncionario() {
            return $this->idFuncionario;
        }

        public function getMembroFuncionario() {
            return $this->membroFuncionario;
        }

        public function getDataAdmissao() {
            return $this->dataAdmissao;
        }

        public function getDataSaida() {
            return $this->dataSaida;
        }

        public function getFuncao() {
            return $this->funcao;
        }

        public function getSalario() {
            return $this->salario;
        }

        public function getCargaHoraria() {
            return $this->cargaHoraria;
        }

        public function getHorarioEntrada() {
            return $this->horarioEntrada;
        }

        public function getHorarioSaida() {
            return $this->horarioSaida;
        }

        public function getCnhNumero() {
            return $this->cnhNumero;
        }

        public function getCarteiraTrabalhoNumero() {
            return $this->carteiraTrabalhoNumero;
        }

        public function setIdFuncionario($idFuncionario) {
            $this->idFuncionario = $idFuncionario;
        }

        public function setMembroFuncionario($membroFuncionario) {
            $this->membroFuncionario = $membroFuncionario;
        }

        public function setDataAdmissao($dataAdmissao) {
            $this->dataAdmissao = $dataAdmissao;
        }

        public function setDataSaida($dataSaida) {
            $this->dataSaida = $dataSaida;
        }

        public function setFuncao($funcao) {
            $this->funcao = $funcao;
        }

        public function setSalario($salario) {
            $this->salario = $salario;
        }

        public function setCargaHoraria($cargaHoraria) {
            $this->cargaHoraria = $cargaHoraria;
        }

        public function setHorarioEntrada($horarioEntrada) {
            $this->horarioEntrada = $horarioEntrada;
        }

        public function setHorarioSaida($horarioSaida) {
            $this->horarioSaida = $horarioSaida;
        }

        public function setCnhNumero($cnhNumero) {
            $this->cnhNumero = $cnhNumero;
        }

        public function setCarteiraTrabalhoNumero($carteiraTrabalhoNumero) {
            $this->carteiraTrabalhoNumero = $carteiraTrabalhoNumero;
        }        
    }
?>