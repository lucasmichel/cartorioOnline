<?php
    // codificação utf-8
    class NegAcao{
        private static $objInstance; 
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegAcao();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoAcao::getInstance()->consultar($arrStrFiltros);            
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta
                    $arrStrFiltrosTotal = array();
                    $arrStrFiltrosTotal["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoAcao::getInstance()->consultar($arrStrFiltrosTotal); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            } 
            
            return $arrObjsRetorno;
        }
        
        public function consultarAcoesPermitidas($arrStrFiltros){
            $arrStrDados = RepoAcao::getInstance()->consultarAcoesPermitidas($arrStrFiltros);            
            $arrObjs = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                }
            } 
            
            return $arrObjs;
        }

        public function factory($arrStrDados){
            $obj = new Acao();

            $obj->setId($arrStrDados["ACO_ID"]);
            
            if(isset($arrStrDados["ACO_Descricao"])){
                $obj->setDescricao($arrStrDados["ACO_Descricao"]);
            }
            
            if(isset($arrStrDados["ACO_Status"])){
                $obj->setStatus($arrStrDados["ACO_Status"]);
            }

            return $obj;
        }
    }
?>