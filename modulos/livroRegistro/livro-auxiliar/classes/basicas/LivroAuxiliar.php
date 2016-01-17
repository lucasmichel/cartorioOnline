<?php
    // codificação utf-8
    class LivroAuxiliar{
        private $id;
        private $numero;
        private $quantidadeFolha;
        private $dataHoraCadastro;        
        private $usuarioCadastro;
        
        function getId() {
            return $this->id;
        }

        function getNumero() {
            return $this->numero;
        }

        function getDataHoraCadastro() {
            return $this->dataHoraCadastro;
        }

        function getUsuarioCadastro() {
            return $this->usuarioCadastro;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setNumero($numero) {
            $this->numero = $numero;
        }

        function setDataHoraCadastro($dataHoraCadastro) {
            $this->dataHoraCadastro = $dataHoraCadastro;
        }

        function setUsuarioCadastro($usuarioCadastro) {
            $this->usuarioCadastro = $usuarioCadastro;
        }
        
        function getQuantidadeFolha() {
            return $this->quantidadeFolha;
        }

        function setQuantidadeFolha($quantidadeFolha) {
            $this->quantidadeFolha = $quantidadeFolha;
        }


    }
?>