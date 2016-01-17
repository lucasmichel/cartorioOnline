<?php
    // codificaçao utf-8
    class MembroMinisterio{
        private $membro;                
        private $ministerio;
        private $dataDesde;
        private $dataAte;
        
        public function getMembro() {
            return $this->membro;
        }

        public function getMinisterio() {
            return $this->ministerio;
        }

        public function getDataDesde() {
            return $this->dataDesde;
        }

        public function getDataAte() {
            return $this->dataAte;
        }

        public function setMembro($membro) {
            $this->membro = $membro;
        }

        public function setMinisterio($ministerio) {
            $this->ministerio = $ministerio;
        }

        public function setDataDesde($dataDesde) {
            $this->dataDesde = $dataDesde;
        }

        public function setDataAte($dataAte) {
            $this->dataAte = $dataAte;
        }
        
    }
?>