<?php
    // codificação utf-8
    class NegDiaSemana{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegDiaSemana();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoDiaSemana::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"] = $arrObjs;
                    $arrObjsRetorno["rows"]    = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta
                    $arrStrFiltrosTotal = array();
                    $arrStrFiltrosTotal["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoDiaSemana::getInstance()->consultar($arrStrFiltrosTotal); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new DiaSemana();
            
            if(isset($arrStrDados["DIA_ID"])){
                $obj->setId($arrStrDados["DIA_ID"]);
            }
            
            if(isset($arrStrDados["DIA_Descricao"])){
                $obj->setDescricao($arrStrDados["DIA_Descricao"]);
            }
            
            if(isset($arrStrDados["DIA_Status"])){
                $obj->setStatus($arrStrDados["DIA_Status"]);
            }else{
                $obj->setStatus("A");
            }

            return $obj;
        }
    }
?>