<?php
    // codificação utf-8
    class FachadaCarta{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaCarta();
            }
            return self::$objInstance;
        }
        
        
        // TIPO CARTA
        public function consultarTipoCarta($arrStrFiltros){
            return NegTipoCarta::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarTipoCarta($arrStrDados){
            return NegTipoCarta::getInstance()->salvar($arrStrDados);
        }
        public function excluirTipoCarta($arrStrDados){
            return NegTipoCarta::getInstance()->excluir($arrStrDados);
        }
        
        // CARTA
        public function consultarCarta($arrStrFiltros){
            return NegCarta::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarCarta($arrStrDados){
            return NegCarta::getInstance()->salvar($arrStrDados);
        }
        public function excluirCarta($arrStrDados){
            return NegCarta::getInstance()->excluir($arrStrDados);
        }
    }
?>