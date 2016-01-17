<?php
    // codificação utf-8
    class NegRendaSalario{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegRendaSalario();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoRendaSalario::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoRendaSalario::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new RendaSalario();            
            if(isset($arrStrDados["ARS_ID"])){
                $obj->setId($arrStrDados["ARS_ID"]);
            }            
            if(isset($arrStrDados["ARS_Descricao"])){
                $obj->setDescricao($arrStrDados["ARS_Descricao"]);
            }
            if(isset($arrStrDados["ARS_Status"])){
                $obj->setStatus($arrStrDados["ARS_Status"]);
            }else{
                $obj->setStatus("A");
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoRendaSalario::getInstance()->salvar($obj);
            }else{ 
                return RepoRendaSalario::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new RendaSalario();
            $obj->setId($arrStrDados["ARS_ID"][0]);
            return RepoRendaSalario::getInstance()->excluir($obj);
        }
    }
?>