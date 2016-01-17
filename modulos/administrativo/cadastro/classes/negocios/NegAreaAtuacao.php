<?php
    // codificação utf-8

    class NegAreaAtuacao{

        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegAreaAtuacao();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoAreaAtuacao::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoAreaAtuacao::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new AreaAtuacao();            
            if(isset($arrStrDados["AAT_ID"])){
                $obj->setId($arrStrDados["AAT_ID"]);
            }
            if(isset($arrStrDados["AAT_Descricao"])){
                $obj->setDescricao($arrStrDados["AAT_Descricao"]);
            }
            if(isset($arrStrDados["AAT_Status"])){
                $obj->setStatus($arrStrDados["AAT_Status"]);
            }
            return $obj;
        }

        public function consultarTotal($arrStrFiltros){            
            $arrStrFiltros["TOT_Total"] = true;
            $arrStrDados                = RepoAreaAtuacao::getInstance()->consultar($arrStrFiltros); 
            return $arrStrDados[0]["Total"];
        }

        public function salvar($arrStrDados){            
            //define o status
            if (!isset($arrStrDados["AAT_Status"])){
                $arrStrDados["AAT_Status"] = "A";
            }
            //define o status   
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                  
                return RepoAreaAtuacao::getInstance()->salvar($obj);
            }else{ 
                return RepoAreaAtuacao::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new AreaAtuacao();
            $obj->setId($arrStrDados["AAT_ID"][0]);
            return RepoAreaAtuacao::getInstance()->excluir($obj);
        }
    }
?>