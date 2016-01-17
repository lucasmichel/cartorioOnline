<?php
    // codificação utf-8

    class NegNivelEscolaridade{

        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegNivelEscolaridade();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $arrStrDados = RepoNivelEscolaridade::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoNivelEscolaridade::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        public function factory($arrStrDados){            
            $obj = new NivelEscolaridade();            
            if(isset($arrStrDados["NES_ID"])){
                $obj->setId($arrStrDados["NES_ID"]);
            }
            if(isset($arrStrDados["NES_Descricao"])){
                $obj->setDescricao($arrStrDados["NES_Descricao"]);
            }
            if(isset($arrStrDados["NES_ExigeFormacao"])){
                $obj->setExigeFormacao($arrStrDados["NES_ExigeFormacao"]);
            }else{
                $obj->setExigeFormacao("N");
            }
            if(isset($arrStrDados["NES_Status"])){
                $obj->setStatus($arrStrDados["NES_Status"]);
            }else{
                $obj->setStatus("A");
            }            
            return $obj;
        }

        public function consultarTotal($arrStrFiltros){            
            $arrStrFiltros["TOT_Total"] = true;
            $arrStrDados                = RepoNivelEscolaridade::getInstance()->consultar($arrStrFiltros); 
            return $arrStrDados[0]["Total"];
        }

        public function salvar($arrStrDados){
            $arrStrDados = DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados);            
            $obj = $this->factory($arrStrDados);
            if($obj->getId() == ""){                  
                return RepoNivelEscolaridade::getInstance()->salvar($obj);
            }else{ 
                return RepoNivelEscolaridade::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new NivelEscolaridade();
            $obj->setId($arrStrDados["NES_ID"][0]);
            return RepoNivelEscolaridade::getInstance()->excluir($obj);
        }
    }
?>