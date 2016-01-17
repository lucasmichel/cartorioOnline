<?php
    // codificação utf-8
    class NegFornecedorEmail{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFornecedorEmail();
            }
            
            return self::$objInstance;
        }
        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoFornecedorEmail::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoFornecedorEmail::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new FornecedorEmail();            
            if(isset($arrStrDados["EMA_ID"])){
                $obj->setId($arrStrDados["EMA_ID"]);
            }
            $fornecedor = new Fornecedor();
            if(isset($arrStrDados["FOR_ID"])){
                $fornecedor->setId($arrStrDados["FOR_ID"]);
            }
            $obj->setFornecedor($fornecedor);            
            if(isset($arrStrDados["EMA_Email"])){
                $obj->setEmail($arrStrDados["EMA_Email"]);
            }                 
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoFornecedorEmail::getInstance()->salvar($obj);            
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoFornecedorEmail::getInstance()->excluir($obj);
            
        }
    }
?>
