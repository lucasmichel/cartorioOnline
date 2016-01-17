<?php
    // codificação utf-8
    class NegFormaAquisicao {
        private static $objInstance;
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFormaAquisicao();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoFormaAquisicao::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoFormaAquisicao::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $objFormaAquisicao = new FormaAquisicao();                        
            if(isset($arrStrDados["FRA_ID"])){
                $objFormaAquisicao->setId($arrStrDados["FRA_ID"]);  
            }
            if(isset($arrStrDados["FRA_Descricao"])){
                $objFormaAquisicao->setDescricao($arrStrDados["FRA_Descricao"]);  
            }
            if(isset($arrStrDados["FRA_Status"])){
                $objFormaAquisicao->setStatus($arrStrDados["FRA_Status"]);  
            }else{
                $objFormaAquisicao->setStatus("A");      
            }
            return $objFormaAquisicao;
        }
        
        public function salvar($arrStrDados){
            $objFormaAquisicao = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($objFormaAquisicao->getId() == ""){                
                return RepoFormaAquisicao::getInstance()->salvar($objFormaAquisicao);
            }else{
                return RepoFormaAquisicao::getInstance()->alterar($objFormaAquisicao);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new FormaAquisicao();
            $obj->setId($arrStrDados["FRA_ID"][0]);
            return RepoFormaAquisicao::getInstance()->excluir($obj);
        }
    }
?>