<?php
    // codificação utf-8
    class NegGrupo{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegGrupo();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoGrupo::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrFiltrosTotal = array();
                    $arrStrFiltrosTotal["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoGrupo::getInstance()->consultar($arrStrFiltrosTotal); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Grupo();
            
            if(isset($arrStrDados["GRU_ID"])){
                $obj->setId($arrStrDados["GRU_ID"]);
            }
            
            if(isset($arrStrDados["GRU_Descricao"])){
                $obj->setDescricao($arrStrDados["GRU_Descricao"]);
            }
            
            if(isset($arrStrDados["GRU_Status"])){
                $obj->setStatus($arrStrDados["GRU_Status"]);
            }else{
                $obj->setStatus("A");
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            
            if($obj->getId() == ""){                
                return RepoGrupo::getInstance()->salvar($obj);
            }else{ 
                return RepoGrupo::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new Grupo();
            $obj->setId($arrStrDados["GRU_ID"][0]);
            return RepoGrupo::getInstance()->excluir($obj);
        }
    }
?>