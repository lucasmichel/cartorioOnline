<?php
    // codificação utf-8
    class NegModulo{
        private static $obj;

        private function __construct() {}

        public static function getInstance(){
            if(self::$obj == null){
                self::$obj = new NegModulo();
            }

            return self::$obj;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados    = RepoModulo::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoModulo::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                    
                }
            }
            
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){            
            $obj = new Modulo();
            $obj->setId($arrStrDados["MOD_ID"]);
            
            $objModuloCategoria = new ModuloCategoria(); 
            
            if (isset($arrStrDados["MCT_ID"])){
                $objModuloCategoria->setId($arrStrDados["MCT_ID"]);
            }
            
            if (isset($arrStrDados["MCT_Descricao"])){
                $objModuloCategoria->setDescricao($arrStrDados["MCT_Descricao"]);
            }
            
            if (isset($arrStrDados["MCT_Imagem"])){
                $objModuloCategoria->setImagem($arrStrDados["MCT_Imagem"]);
            }
            
            if (isset($arrStrDados["MCT_BackgroundModulo"])){
                $objModuloCategoria->setBackgroundModulo($arrStrDados["MCT_BackgroundModulo"]);
            }
            
            if (isset($arrStrDados["MCT_BackgroundSubModulo"])){
                $objModuloCategoria->setBackgroundSubModulo($arrStrDados["MCT_BackgroundSubModulo"]);
            }
            
            $obj->setModuloCategoria($objModuloCategoria);
            $obj->setDescricao($arrStrDados["MOD_Descricao"]);
            $obj->setCaminho($arrStrDados["MOD_Caminho"]);
            $obj->setImagem($arrStrDados["MOD_Imagem"]);
            $obj->setStatus($arrStrDados["MOD_Status"]);            
            
            return $obj;
        }
    }
?>