<?php
    // codificação utf-8
    class NegBanco{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegBanco();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoBanco::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoBanco::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Banco();
            
            if(isset($arrStrDados["BAN_ID"])){
                $obj->setId($arrStrDados["BAN_ID"]);
            }
            
            if(isset($arrStrDados["BAN_Descricao"])){
                $obj->setDescricao($arrStrDados["BAN_Descricao"]);
            }
            
            if(isset($arrStrDados["BAN_Codigo"])){
                $obj->setCodigo($arrStrDados["BAN_Codigo"]);
            }
            
            if(isset($arrStrDados["BAN_Status"])){
                $obj->setStatus($arrStrDados["BAN_Status"]);
            }else{
                $obj->setStatus("A");
            }

            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if($obj->getId() == ""){                
                return RepoBanco::getInstance()->salvar($obj);
            }else{ 
                return RepoBanco::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new Banco();
            $obj->setId($arrStrDados["BAN_ID"][0]);
            return RepoBanco::getInstance()->excluir($obj);
        }
    }
?>