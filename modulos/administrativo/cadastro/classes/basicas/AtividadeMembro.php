<?php
    // codificaçao utf-8
    class AtividadeMembro{
        private $membro;                
        private $atividade;
        private $dataDesde;
        private $dataAte;
        
        public function getMembro() {
            return $this->membro;
        }

        public function getAtividade() {
            return $this->atividade;
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

        public function setAtividade($atividade) {
            $this->atividade = $atividade;
        }

        public function setDataDesde($dataDesde) {
            $this->dataDesde = $dataDesde;
        }

        public function setDataAte($dataAte) {
            $this->dataAte = $dataAte;
        }

        
    }
?>