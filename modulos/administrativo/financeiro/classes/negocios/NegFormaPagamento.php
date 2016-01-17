<?php
    // codificação utf-8
    class NegFormaPagamento{
        private static $objInstance;

        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFormaPagamento();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){                        
            $arrStrDados = RepoFormaPagamento::getInstance()->consultar($arrStrFiltros);            
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
                    $arrStrDadosTotal = RepoFormaPagamento::getInstance()->consultar($arrStrFiltros);
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new FormaPagamento();
            if(isset($arrStrDados["FPG_ID"])){
                $obj->setId($arrStrDados["FPG_ID"]);
            }            
            if(isset($arrStrDados["FPG_Descricao"])){
                $obj->setDescricao($arrStrDados["FPG_Descricao"]);            
            }                        
            if(isset($arrStrDados["FPG_Status"])){
                $obj->setStatus($arrStrDados["FPG_Status"]);
            } 
            if(isset($arrStrDados["FPG_ExigeNumero"])){
                $obj->setExigeNumero($arrStrDados["FPG_ExigeNumero"]);
            } 
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            //define o status
            if (!isset($arrStrDados["FPG_Status"])){
                $arrStrDados["FPG_Status"] = "A";
            }
            if (!isset($arrStrDados["FPG_ExigeNumero"])){
                $arrStrDados["FPG_ExigeNumero"] = "N";
            }
            //define o status            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoFormaPagamento::getInstance()->salvar($obj);
            }else{ 
                return RepoFormaPagamento::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new FormaPagamento();
            $obj->setId($arrStrDados["FPG_ID"][0]);
            return RepoFormaPagamento::getInstance()->excluir($obj);
        }
    }
?>