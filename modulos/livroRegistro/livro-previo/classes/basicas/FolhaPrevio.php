<?php
    // codificação utf-8
    class FolhaPrevio{
        private $id;
        private $livroPrevio;
        private $numero;
        private $data;        
        private $usuarioCadastro;
        private $dataHoraCadastro;
        private $usuarioAlteracao;
        private $dataHoraAlteracao;
        private $quantidadeLinha;
        
        function getId() {
            return $this->id;
        }

        function getLivroPrevio() {
            return $this->livroPrevio;
        }

        function getNumero() {
            return $this->numero;
        }

        function getData() {
            return $this->data;
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

        function getQuantidadeLinha() {
            return $this->quantidadeLinha;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setLivroPrevio($livroPrevio) {
            $this->livroPrevio = $livroPrevio;
        }

        function setNumero($numero) {
            $this->numero = $numero;
        }

        function setData($data) {
            $this->data = $data;
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

        function setQuantidadeLinha($quantidadeLinha) {
            $this->quantidadeLinha = $quantidadeLinha;
        }



    }
?>