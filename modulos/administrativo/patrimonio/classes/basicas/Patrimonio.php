<?php
    // codificação utf-8
    class Patrimonio{ 
        private $id;
        private $tipoPatrimonio; // grupo
        private $formaAquisicao;          
        private $usuarioCadastro;          
        private $usuarioAlteracao;          
        private $itemPatrimonio; // subgrupo
        private $congregacao;
        private $numeroTombamento;        
        private $dataAquisicao;
        private $dataHoraCadastro;
        private $dataHoraAlteracao;        
        private $dataExpiracaoGarantia;        
        private $observacao;
        private $condicao;
        private $valorEstimado;
        private $numero;
        private $descricao;
        private $quantidade;
        private $foto;
        private $fabricante;
        private $fornecedor;
        private $numeroDocumento;
        
        public function getId() {
            return $this->id;
        }

        public function getTipoPatrimonio() {
            return $this->tipoPatrimonio;
        }

        public function getFormaAquisicao() {
            return $this->formaAquisicao;
        }

        public function getUsuarioCadastro() {
            return $this->usuarioCadastro;
        }

        public function getUsuarioAlteracao() {
            return $this->usuarioAlteracao;
        }

        public function getItemPatrimonio() {
            return $this->itemPatrimonio;
        }

        public function getCongregacao() {
            return $this->congregacao;
        }

        public function getNumeroTombamento() {
            return $this->numeroTombamento;
        }

        public function getDataAquisicao() {
            return $this->dataAquisicao;
        }

        public function getDataHoraCadastro() {
            return $this->dataHoraCadastro;
        }

        public function getDataHoraAlteracao() {
            return $this->dataHoraAlteracao;
        }

        public function getDataExpiracaoGarantia() {
            return $this->dataExpiracaoGarantia;
        }

        public function getObservacao() {
            return $this->observacao;
        }

        public function getCondicao() {
            return $this->condicao;
        }

        public function getValorEstimado() {
            return $this->valorEstimado;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getQuantidade() {
            return $this->quantidade;
        }

        public function getFoto() {
            return $this->foto;
        }

        public function getFabricante() {
            return $this->fabricante;
        }

        public function getFornecedor() {
            return $this->fornecedor;
        }

        public function getNumeroDocumento() {
            return $this->numeroDocumento;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setTipoPatrimonio($tipoPatrimonio) {
            $this->tipoPatrimonio = $tipoPatrimonio;
        }

        public function setFormaAquisicao($formaAquisicao) {
            $this->formaAquisicao = $formaAquisicao;
        }

        public function setUsuarioCadastro($usuarioCadastro) {
            $this->usuarioCadastro = $usuarioCadastro;
        }

        public function setUsuarioAlteracao($usuarioAlteracao) {
            $this->usuarioAlteracao = $usuarioAlteracao;
        }

        public function setItemPatrimonio($itemPatrimonio) {
            $this->itemPatrimonio = $itemPatrimonio;
        }

        public function setCongregacao($congregacao) {
            $this->congregacao = $congregacao;
        }

        public function setNumeroTombamento($numeroTombamento) {
            $this->numeroTombamento = $numeroTombamento;
        }

        public function setDataAquisicao($dataAquisicao) {
            $this->dataAquisicao = $dataAquisicao;
        }

        public function setDataHoraCadastro($dataHoraCadastro) {
            $this->dataHoraCadastro = $dataHoraCadastro;
        }

        public function setDataHoraAlteracao($dataHoraAlteracao) {
            $this->dataHoraAlteracao = $dataHoraAlteracao;
        }

        public function setDataExpiracaoGarantia($dataExpiracaoGarantia) {
            $this->dataExpiracaoGarantia = $dataExpiracaoGarantia;
        }

        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }

        public function setCondicao($condicao) {
            $this->condicao = $condicao;
        }

        public function setValorEstimado($valorEstimado) {
            $this->valorEstimado = $valorEstimado;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setQuantidade($quantidade) {
            $this->quantidade = $quantidade;
        }

        public function setFoto($foto) {
            $this->foto = $foto;
        }

        public function setFabricante($fabricante) {
            $this->fabricante = $fabricante;
        }

        public function setFornecedor($fornecedor) {
            $this->fornecedor = $fornecedor;
        }

        public function setNumeroDocumento($numeroDocumento) {
            $this->numeroDocumento = $numeroDocumento;
        }

    }
?>