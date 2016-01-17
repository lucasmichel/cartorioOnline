<?php
    // codificação utf-8
    class NegItemPatrimonio {
        private static $objInstance;
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegItemPatrimonio();
            }

            return self::$objInstance;
        }

        
        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoItemPatrimonio::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoItemPatrimonio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new ItemPatrimonio();          
            
            if(isset($arrStrDados["IPT_ID"])){
                $obj->setId($arrStrDados["IPT_ID"]);  
            }
            
            $obj->setDescricao($arrStrDados["IPT_Descricao"]);  
            
            if(isset($arrStrDados["IPT_Status"])){
                $obj->setStatus($arrStrDados["IPT_Status"]);  
            }else{
                $obj->setStatus("A");      
            }
            
            if(isset($arrStrDados["IPT_PercentualDepreciacao"])){
                $obj->setPercentualDepreciacao($arrStrDados["IPT_PercentualDepreciacao"]);  
            }
            
            // tipo patrimonio
            $objTipo = new TipoPatrimonio();
            $objTipo->setId($arrStrDados["TIP_ID"]);
            $objTipo->setDescricao($arrStrDados["IPT_Descricao"]);
            $obj->setTipoPatrimonio($objTipo);
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if($obj->getId() == ""){                
                return RepoItemPatrimonio::getInstance()->salvar($obj);
            }else{
                return RepoItemPatrimonio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new ItemPatrimonio();
            $obj->setId($arrStrDados["IPT_ID"][0]);
            return RepoItemPatrimonio::getInstance()->excluir($obj);
        }
    }
?>