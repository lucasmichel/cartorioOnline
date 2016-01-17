<?php
    // codificação utf-8
    class SegurancaHelper{
        private static $objInstance;
        
        private function __construct(){}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new SegurancaHelper();                
            }
            
            return self::$objInstance;
        }
        
        public function removerSQLInjection($strTexto){
            @$strTexto = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|\*|--|\\\\)/"), "", $strTexto);
            @$strTexto = trim($strTexto);
            // @$strTexto = strip_tags($strTexto);
            //@$strTexto = addslashes($strTexto);
            
            return $strTexto;
	}
    }
?>
