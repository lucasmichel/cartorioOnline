<?php
    // codificação utf-8
    class NegTipoPatrimonio {
        private static $objInstance;
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegTipoPatrimonio();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoTipoPatrimonio::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoTipoPatrimonio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new TipoPatrimonio();            
            if(isset($arrStrDados["TIP_ID"])){
                $obj->setId($arrStrDados["TIP_ID"]);  
            }
            if(isset($arrStrDados["TIP_Descricao"])){
                $obj->setDescricao($arrStrDados["TIP_Descricao"]);  
            }
            if(isset($arrStrDados["TIP_Status"])){
                $obj->setStatus($arrStrDados["TIP_Status"]);  
            }else{
                $obj->setStatus("A");      
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoTipoPatrimonio::getInstance()->salvar($obj);
            }else{
                return RepoTipoPatrimonio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new TipoPatrimonio();
            $obj->setId($arrStrDados["TIP_ID"][0]);
            return RepoTipoPatrimonio::getInstance()->excluir($obj);
        }
    }
?>