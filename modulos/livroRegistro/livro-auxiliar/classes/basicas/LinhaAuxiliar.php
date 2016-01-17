<?php
    // codificação utf-8
    class LinhaAuxiliar{
        private $id;
        private $folhaAuxiliar;        
        private $tipoLinha;        
        private $descricao;
        private $guia;
        private $protocoloRecepcao;
        private $quantidade;
        private $tipoFisicaJuridica;
        private $cpf;
        private $data;
        private $valor;
        private $usuarioCadastro;
        private $dataHoraCadastro;
        private $usuarioAlteracao;
        private $dataHoraAlteracao;
        
        function getId() {
            return $this->id;
        }

        function getFolhaAuxiliar() {
            return $this->folhaAuxiliar;
        }

        function getTipoLinha() {
            return $this->tipoLinha;
        }

        function getDescricao() {
            return $this->descricao;
        }

        function getGuia() {
            return $this->guia;
        }

        function getProtocoloRecepcao() {
            return $this->protocoloRecepcao;
        }

        function getQuantidade() {
            return $this->quantidade;
        }

        function getTipoFisicaJuridica() {
            return $this->tipoFisicaJuridica;
        }

        function getCpf() {
            return $this->cpf;
        }

        function getData() {
            return $this->data;
        }

        function getValor() {
            return $this->valor;
        }

        function getUsuarioCadastro() {
            return $this->usuarioCadastro;
        }

        function getDataHoraCadastro() {
            return $this->dataHoraCadastro;
        }

        function getUsuarioAlteracao() {
            return $this->usuarioAlteracao;
        }

        function getDataHoraAlteracao() {
            return $this->dataHoraAlteracao;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setFolhaAuxiliar($folhaAuxiliar) {
            $this->folhaAuxiliar = $folhaAuxiliar;
        }

        function setTipoLinha($tipoLinha) {
            $this->tipoLinha = $tipoLinha;
        }

        function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        function setGuia($guia) {
            $this->guia = $guia;
        }

        function setProtocoloRecepcao($protocoloRecepcao) {
            $this->protocoloRecepcao = $protocoloRecepcao;
        }

        function setQuantidade($quantidade) {
            $this->quantidade = $quantidade;
        }

        function setTipoFisicaJuridica($tipoFisicaJuridica) {
            $this->tipoFisicaJuridica = $tipoFisicaJuridica;
        }

        function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        function setData($data) {
            $this->data = $data;
        }

        function setValor($valor) {
            $this->valor = $valor;
        }

        function setUsuarioCadastro($usuarioCadastro) {
            $this->usuarioCadastro = $usuarioCadastro;
        }

        function setDataHoraCadastro($dataHoraCadastro) {
            $this->dataHoraCadastro = $dataHoraCadastro;
        }

        function setUsuarioAlteracao($usuarioAlteracao) {
            $this->usuarioAlteracao = $usuarioAlteracao;
        }

        function setDataHoraAlteracao($dataHoraAlteracao) {
            $this->dataHoraAlteracao = $dataHoraAlteracao;
        }

    }
?>