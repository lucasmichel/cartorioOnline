<?php
    // codificaçao utf-8
    class MalaDireta{
        private $id;                
        private $assunto;
        private $conteudo;
        private $dataHoraCadastro;
        private $dataHoraAlteracao;
        private $usuarioCadastro;
        private $usuarioAlteracao;
        
        public function getId() {
            return $this->id;
        }

        public function getAssunto() {
            return $this->assunto;
        }

        public function getConteudo() {
            return $this->conteudo;
        }

        public function getDataHoraCadastro() {
            return $this->dataHoraCadastro;
        }

        public function getDataHoraAlteracao() {
            return $this->dataHoraAlteracao;
        }

        public function getUsuarioCadastro() {
            return $this->usuarioCadastro;
        }

        public function getUsuarioAlteracao() {
            return $this->usuarioAlteracao;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setAssunto($assunto) {
            $this->assunto = $assunto;
        }

        public function setConteudo($conteudo) {
            $this->conteudo = $conteudo;
        }

        public function setDataHoraCadastro($dataHoraCadastro) {
            $this->dataHoraCadastro = $dataHoraCadastro;
        }

        public function setDataHoraAlteracao($dataHoraAlteracao) {
            $this->dataHoraAlteracao = $dataHoraAlteracao;
        }

        public function setUsuarioCadastro($usuarioCadastro) {
            $this->usuarioCadastro = $usuarioCadastro;
        }

        public function setUsuarioAlteracao($usuarioAlteracao) {
            $this->usuarioAlteracao = $usuarioAlteracao;
        }
        
    }
?>