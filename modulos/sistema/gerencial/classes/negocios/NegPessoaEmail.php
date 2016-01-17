<?php
    // codificação utf-8
    class NegPessoaEmail{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegPessoaEmail();
            }
            
            return self::$objInstance;
        }
        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoPessoaEmail::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoPessoaEmail::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new PessoaEmail();            
            if(isset($arrStrDados["EMA_ID"])){
                $obj->setId($arrStrDados["EMA_ID"]);
            }
            $pessoa = new Pessoa();
            if(isset($arrStrDados["PES_ID"])){
                $pessoa->setId($arrStrDados["PES_ID"]);
            }
            $obj->setPessoa($pessoa);            
            if(isset($arrStrDados["EMA_Email"])){
                $obj->setEmail($arrStrDados["EMA_Email"]);
            }                 
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoPessoaEmail::getInstance()->salvar($obj);            
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoPessoaEmail::getInstance()->excluir($obj);
            
        }
    }
?>
