<?php
    // codificação utf-8
    class FachadaTipoLinhaLivro{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaTipoLinhaLivro();
            }

            return self::$objInstance;
        }
        
        public function salvarTipoLinhaLivro($arrStrDados){
            return NegTipoLinhaLivro::getInstance()->salvar($arrStrDados);
        }
        public function consultarTipoLinhaLivro($arrStrFiltros){
            return NegTipoLinhaLivro::getInstance()->consultar($arrStrFiltros);
        }        
    }
?>