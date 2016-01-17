<?php
    // codificação utf-8
    class NegModuloCategoria{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegModuloCategoria();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados    = RepoModuloCategoria::getInstance()->consultar($arrStrFiltros);
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
                    if(isset($arrStrFiltros["GRU_ID"])){
                        $arrStrFiltros["GRU_ID"] = null;
                    }
                    
                    if(isset($arrStrFiltros["USU_ID"])){
                        $arrStrFiltros["USU_ID"] = null;
                    }
                        
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoModuloCategoria::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            
            return $arrObjsRetorno;
        }

        public function factory($arrStrDados){
            $obj = new ModuloCategoria();
            
            $obj->setId($arrStrDados["MCT_ID"]);
            $obj->setDescricao($arrStrDados["MCT_Descricao"]);
            $obj->setImagem($arrStrDados["MCT_Imagem"]);
            $obj->setBackgroundModulo($arrStrDados["MCT_BackgroundModulo"]);
            $obj->setBackgroundSubModulo($arrStrDados["MCT_BackgroundSubModulo"]);
            $obj->setOrdem($arrStrDados["MCT_Ordem"]);
            $obj->setStatus($arrStrDados["MCT_Status"]);

            return $obj;
        }
    }
?>