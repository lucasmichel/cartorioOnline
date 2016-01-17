<?php
    // codificação utf-8
    class NegStatusMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegStatusMembro();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoStatusMembro::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoStatusMembro::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new StatusMembro();            
            if(isset($arrStrDados["MES_ID"])){
                $obj->setId($arrStrDados["MES_ID"]);
            }            
            if(isset($arrStrDados["MES_Descricao"])){
                $obj->setDescricao($arrStrDados["MES_Descricao"]);
            }
            if(isset($arrStrDados["MES_Status"])){
                $obj->setStatus($arrStrDados["MES_Status"]);
            }else{
                $obj->setStatus("A");
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if($obj->getId() == ""){                
                return RepoStatusMembro::getInstance()->salvar($obj);
            }else{ 
                return RepoStatusMembro::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new StatusMembro();
            $obj->setId($arrStrDados["MES_ID"][0]);
            return RepoStatusMembro::getInstance()->excluir($obj);
        }
    }
?>