<?php
    // codificação utf-8
    class NegFornecedorTelefone{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFornecedorTelefone();
            }
            
            return self::$objInstance;
        }
        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoFornecedorTelefone::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoFornecedorTelefone::getInstance()->consultar($arrStrFiltros);                     
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){            
            $obj = new FornecedorTelefone();            
            if(isset($arrStrDados["TEL_ID"])){
                $obj->setId($arrStrDados["TEL_ID"]);
            }
            
            $fornecedor = new Fornecedor();
            if(isset($arrStrDados["FOR_ID"])){
                $fornecedor->setId($arrStrDados["FOR_ID"]);
            }
            $obj->setFornecedor($fornecedor);
            
            if(isset($arrStrDados["TEL_Numero"])){
                $obj->setNumero($arrStrDados["TEL_Numero"]);
            }
            if(isset($arrStrDados["TEL_Operadora"])){
                $obj->setOperadora($arrStrDados["TEL_Operadora"]);
            }
            if(isset($arrStrDados["TEL_NomeContato"])){
                $obj->setContato($arrStrDados["TEL_NomeContato"]);
            }            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoFornecedorTelefone::getInstance()->salvar($obj);            
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoFornecedorTelefone::getInstance()->excluir($obj);
            
        }
    }
?>
