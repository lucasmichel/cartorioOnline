<?php
    // codificação utf-8
    class NegPlanoConta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegPlanoConta();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoPlanoConta::getInstance()->consultar($arrStrFiltros);            
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
                    $arrStrDadosTotal = RepoPlanoConta::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new PlanoConta();
            
            $obj->setId($arrStrDados["PLA_ID"]);
            $obj->setDescricao($arrStrDados["PLA_Descricao"]);            
                                    
            if(isset($arrStrDados["PLA_CodigoContabil"])){
                $obj->setCodigoContabil($arrStrDados["PLA_CodigoContabil"]);            
            }
            
            if(isset($arrStrDados["PLA_Movimentacao"])){
                $obj->setMovimento($arrStrDados["PLA_Movimentacao"]);            
            }
            
            if(isset($arrStrDados["PLA_Tipo"])){
                $obj->setTipo($arrStrDados["PLA_Tipo"]);            
            }
            
            if(isset($arrStrDados["PLA_Status"])){
                $obj->setStatus($arrStrDados["PLA_Status"]);
            }else{
                $obj->setStatus("A");
            }
            
            if(isset($arrStrDados["PLA_CodigoContabilPai"])){
                $obj->setPai($arrStrDados["PLA_CodigoContabilPai"]);            
            }else{
                $obj->setPai("");
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if($obj->getId() != ""){
                return RepoPlanoConta::getInstance()->alterar($obj);
            }
            
            return RepoPlanoConta::getInstance()->salvar($obj);
        }
        
        public function excluir($arrStrDados){            
            $obj = new PlanoConta();
            $obj->setId($arrStrDados["PLA_ID"][0]);
            return RepoPlanoConta::getInstance()->excluir($obj);
        }
    }
?>