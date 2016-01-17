<?php
    // codificação utf-8
    class DadosHelper{
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new DadosHelper();                
            }
            
            return self::$objInstance;
        }
        
        // recebe um array e trabalha os dados
        // ex.: $_POST
        // após tratá-los retorna o array
        public function prepararDados($arrStrDados){
            foreach($arrStrDados as $arrStrTemp => $strValor){
                if(!is_array($strValor)){
                    $strValor = SegurancaHelper::getInstance()->removerSQLInjection($strValor);
                    $strValor = StringHelper::getInstance()->removerAcentos($strValor);
                    $strValor = StringHelper::getInstance()->toUpper($strValor);
                }else{                    
                    // recursividade para trabalhar
                    // em campos que se tem um array
                    $strValor = $this->prepararDados($strValor);
                }
                
                $arrStrDados[$arrStrTemp] = $strValor;                
            } 
            
            return $arrStrDados;
        }
        
        public function prepararDadosComAcentuacao($arrStrDados){            
            foreach($arrStrDados as $arrStrTemp => $strValor){
                if(!is_array($strValor)){
                    $strValor = SegurancaHelper::getInstance()->removerSQLInjection($strValor);
                    $strValor = StringHelper::getInstance()->toUpper($strValor);                    
                }else{                    
                    // recursividade para trabalhar
                    // em campos que se tem um array
                    $strValor = $this->prepararDadosComAcentuacao($strValor);
                }
                
                $arrStrDados[$arrStrTemp] = $strValor;                
            } 
            
            return $arrStrDados;
        }
        
        public function prepararDadosSemModificacao($arrStrDados){
            foreach($arrStrDados as $arrStrTemp => $strValor){
                if(!is_array($strValor)){
                    $strValor = SegurancaHelper::getInstance()->removerSQLInjection($strValor);
                }else{                    
                    // recursividade para trabalhar
                    // em campos que se tem um array
                    $strValor = $this->prepararDadosSemModificacao($strValor);
                }
                
                $arrStrDados[$arrStrTemp] = $strValor;                
            } 
            
            return $arrStrDados;
        }
        
        public function prepararDadoSemModificacao($strValor){
            $strValor = SegurancaHelper::getInstance()->removerSQLInjection($strValor);
            
            return $strValor;
        }
    }
?>
