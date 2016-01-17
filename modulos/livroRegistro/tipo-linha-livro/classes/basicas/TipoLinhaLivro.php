<?php
    // codificação utf-8
    class TipoLinhaLivro{
        private $id;
        private $descricao;
        private $tipo;
        private $status;
        private $usuarioCadastro;
        private $dataHoraCadastro;
        private $usuarioAlteracao;
        private $dataHoraAlteracao;
        
        function getId() {
            return $this->id;
        }

        function getDescricao() {
            return $this->descricao;
        }

        function getTipo() {
            return $this->tipo;
        }

        function getStatus() {
            return $this->status;
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

        function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        function setTipo($tipo) {
            $this->tipo = $tipo;
        }

        function setStatus($status) {
            $this->status = $status;
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