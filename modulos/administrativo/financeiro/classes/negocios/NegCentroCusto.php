<?php
    // codificação utf-8
    class NegCentroCusto{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegCentroCusto();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){                        
            $arrStrDados = RepoCentroCusto::getInstance()->consultar($arrStrFiltros);            
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
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoCentroCusto::getInstance()->consultar($arrStrFiltros);
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $objCentroCusto = new CentroCusto();
            if(isset($arrStrDados["CEN_ID"])){
                $objCentroCusto->setId($arrStrDados["CEN_ID"]);
            }            
            if(isset($arrStrDados["CEN_Descricao"])){
                $objCentroCusto->setDescricao($arrStrDados["CEN_Descricao"]);            
            }            
            if(isset($arrStrDados["CEN_Observacao"])){
                $objCentroCusto->setObservacao($arrStrDados["CEN_Observacao"]);            
            }            
            if(isset($arrStrDados["CEN_Status"])){
                $objCentroCusto->setStatus($arrStrDados["CEN_Status"]);
            }            
            return $objCentroCusto;
        }
        
        public function salvar($arrStrDados){            
            //define o status
            if (!isset($arrStrDados["CEN_Status"])){
                $arrStrDados["CEN_Status"] = "A";
            }
            //define o status            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoCentroCusto::getInstance()->salvar($obj);
            }else{ 
                return RepoCentroCusto::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new CentroCusto();
            $obj->setId($arrStrDados["CEN_ID"][0]);
            return RepoCentroCusto::getInstance()->excluir($obj);
        }
    }
?>