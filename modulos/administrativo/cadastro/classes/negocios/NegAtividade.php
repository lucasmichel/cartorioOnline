<?php
    // codificação utf-8
    class NegAtividade{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegAtividade();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoAtividade::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoAtividade::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Atividade();            
            if(isset($arrStrDados["ATV_ID"])){
                $obj->setId($arrStrDados["ATV_ID"]);
            }            
            if(isset($arrStrDados["ATV_Descricao"])){
                $obj->setDescricao($arrStrDados["ATV_Descricao"]);
            }
            if(isset($arrStrDados["ATV_ExigeData"])){
                $obj->setExigeData($arrStrDados["ATV_ExigeData"]);
            }else{
                $obj->setExigeData("N");
            }
            if(isset($arrStrDados["ATV_Status"])){
                $obj->setStatus($arrStrDados["ATV_Status"]);
            }else{
                $obj->setStatus("A");
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if($obj->getId() == ""){                
                return RepoAtividade::getInstance()->salvar($obj);
            }else{ 
                return RepoAtividade::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new Atividade();
            $obj->setId($arrStrDados["ATV_ID"][0]);
            return RepoAtividade::getInstance()->excluir($obj);
        }
    }
?>