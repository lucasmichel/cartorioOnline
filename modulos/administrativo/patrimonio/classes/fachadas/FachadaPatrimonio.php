<?php
    // codificação utf-8
    class FachadaPatrimonio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaPatrimonio();
            }

            return self::$objInstance;
        }
        
        public function consultarFormaAquisicao($arrStrFiltros){            
            return NegFormaAquisicao::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarFormaAquisicao($arrStrDados){
            return NegFormaAquisicao::getInstance()->salvar($arrStrDados);
        }
        public function excluirFormaAquisicao($arrStrDados){
            return NegFormaAquisicao::getInstance()->excluir($arrStrDados);
        }
        
	public function consultarPatrimonio($arrStrFiltros){            
            return NegPatrimonio::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarPatrimonio($arrStrDados){
            return NegPatrimonio::getInstance()->salvar($arrStrDados);
        }        
        public function excluirPatrimonio($arrStrDados){
            return NegPatrimonio::getInstance()->excluir($arrStrDados);
        }   
        
	public function consultarTipoPatrimonio($arrStrFiltros){            
            return NegTipoPatrimonio::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarTipoPatrimonio($arrStrDados){
            return NegTipoPatrimonio::getInstance()->salvar($arrStrDados);
        }
        public function excluirTipoPatrimonio($arrStrDados){
            return NegTipoPatrimonio::getInstance()->excluir($arrStrDados);
        }
        
        public function salvarItemPatrimonio($arrStrDados){
            return NegItemPatrimonio::getInstance()->salvar($arrStrDados);
        }
        public function consultarItemPatrimonio($arrStrFiltros){
            return NegItemPatrimonio::getInstance()->consultar($arrStrFiltros);
        }
        public function excluirItemPatrimonio($arrStrFiltros){
            return NegItemPatrimonio::getInstance()->excluir($arrStrFiltros);
        }
    }
?>