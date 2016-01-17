<?php
    // codificação utf-8

    class NegAreaMinisterial{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegAreaMinisterial();
            }
            return self::$objInstance;
        }
        public function consultar($arrStrFiltros){
            $arrStrDados = RepoAreaMinisterial::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoAreaMinisterial::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }        
        public function factory($arrStrDados){
            $obj = new AreaMinisterial();            
            if(isset($arrStrDados["AMI_ID"])){
                $obj->setId($arrStrDados["AMI_ID"]);
            }
            if(isset($arrStrDados["AMI_Descricao"])){
                $obj->setDescricao($arrStrDados["AMI_Descricao"]);
            }
            if(isset($arrStrDados["AMI_Status"])){
                $obj->setStatus($arrStrDados["AMI_Status"]);
            }else{
                $obj->setStatus("A");
            }
            return $obj;
        }
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                  
                return RepoAreaMinisterial::getInstance()->salvar($obj);
            }else{ 
                return RepoAreaMinisterial::getInstance()->alterar($obj);
            }
        }
        public function excluir($arrStrDados){            
            $obj = new AreaMinisterial();
            $obj->setId($arrStrDados["AMI_ID"]);
            return RepoAreaMinisterial::getInstance()->excluir($obj);
        }
    }
?>