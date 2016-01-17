<?php
    // codificação utf-8
    class NegLote{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegLote();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){                 
            $arrStrDados = RepoLote::getInstance()->consultar($arrStrFiltros);            
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
                    $arrStrDadosTotal = RepoLote::getInstance()->consultar($arrStrFiltros);
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new Lote();            
            if(isset($arrStrDados["LOT_ID"])){
                $obj->setId($arrStrDados["LOT_ID"]);
            }  
            if(isset($arrStrDados["LOT_Descricao"])){
                $obj->setDescricao($arrStrDados["LOT_Descricao"]);            
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){
                return RepoLote::getInstance()->salvar($obj);            
            }else{
                return RepoLote::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){             
            $obj = new Lote();
            $obj->setId($arrStrDados["LOT_ID"]);                    
            return RepoLote::getInstance()->excluir($obj);
        }
    }
?>