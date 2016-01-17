<?php
    // codificação utf-8
    class Reuniao{
        private $objDiaSemana;
        private $strHorario;

        public function __construct() {}

        public function setDiaSemana(DiaSemana $obj){
            $this->objDiaSemana = $obj;
        }
        public function getDiaSemana(){
            return $this->objDiaSemana;
        }

        public function setHorario($str){
            $this->strHorario = $str;
        }
        public function getHorario(){
            return $this->strHorario;
        }
    }
?>
