<?php
    // codificação utf-8

    class NegEstadoCivil{

        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegEstadoCivil();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoEstadoCivil::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoEstadoCivil::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        public function factory($arrStrDados){
            $obj = new EstadoCivil();            
            if(isset($arrStrDados["ECV_ID"])){
                $obj->setId($arrStrDados["ECV_ID"]);
            }
            if(isset($arrStrDados["ECV_Descricao"])){
                $obj->setDescricao($arrStrDados["ECV_Descricao"]);
            }
             
            if(isset($arrStrDados["ECV_ExigeConjuge"])){
                $obj->setExigeConjuge($arrStrDados["ECV_ExigeConjuge"]);
            }else{
                $obj->setExigeConjuge("N");
            }

            
            if(isset($arrStrDados["ECV_Status"])){
                $obj->setStatus($arrStrDados["ECV_Status"]);
            }else{
                $obj->setStatus("A");
            }
            return $obj;
        }

        public function consultarTotal($arrStrFiltros){            
            $arrStrFiltros["TOT_Total"] = true;
            $arrStrDados                = RepoEstadoCivil::getInstance()->consultar($arrStrFiltros); 
            return $arrStrDados[0]["Total"];
        }

        public function salvar($arrStrDados){            
            $arrStrDados = DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados);
            $obj = $this->factory($arrStrDados);
            if($obj->getId() == ""){                  
                return RepoEstadoCivil::getInstance()->salvar($obj);
            }else{ 
                return RepoEstadoCivil::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new EstadoCivil();
            $obj->setId($arrStrDados["ECV_ID"][0]);
            return RepoEstadoCivil::getInstance()->excluir($obj);
        }
    }
?>