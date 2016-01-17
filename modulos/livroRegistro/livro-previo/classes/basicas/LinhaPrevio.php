<?php
    // codificação utf-8
    class LinhaPrevio{
        private $id;
        private $folhaPrevio;        
        private $tipoLinha;        
        private $descricao;
        private $guia;
        private $nome;
        private $cpf;
        private $quantidade;        
        private $data;
        private $valor;        
        private $usuarioCadastro;
        private $dataHoraCadastro;        
        private $usuarioAlteracao;
        private $dataHoraAlteracao;
        private $statusConclusao;
        private $dataHoraStatusConclusao;
        private $usuarioStatusConclusao;
        private $protocoloRecepcao;
        
        function getId() {
            return $this->id;
        }

        function getFolhaPrevio() {
            return $this->folhaPrevio;
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

        function getNome() {
            return $this->nome;
        }

        function getCpf() {
            return $this->cpf;
        }

        function getQuantidade() {
            return $this->quantidade;
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

        function getStatusConclusao() {
            return $this->statusConclusao;
        }

        function getDataHoraStatusConclusao() {
            return $this->dataHoraStatusConclusao;
        }

        function getUsuarioStatusConclusao() {
            return $this->usuarioStatusConclusao;
        }

        function getProtocoloRecepcao() {
            return $this->protocoloRecepcao;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setFolhaPrevio($folhaPrevio) {
            $this->folhaPrevio = $folhaPrevio;
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

        function setNome($nome) {
            $this->nome = $nome;
        }

        function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        function setQuantidade($quantidade) {
            $this->quantidade = $quantidade;
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

        function setStatusConclusao($statusConclusao) {
            $this->statusConclusao = $statusConclusao;
        }

        function setDataHoraStatusConclusao($dataHoraStatusConclusao) {
            $this->dataHoraStatusConclusao = $dataHoraStatusConclusao;
        }

        function setUsuarioStatusConclusao($usuarioStatusConclusao) {
            $this->usuarioStatusConclusao = $usuarioStatusConclusao;
        }

        function setProtocoloRecepcao($protocoloRecepcao) {
            $this->protocoloRecepcao = $protocoloRecepcao;
        }

    }
?>