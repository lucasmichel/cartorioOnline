<?php
    // codificação utf-8
    class NegDadosEclesiasticos{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegDadosEclesiasticos();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoDadosEclesiasticos::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrStrDados[$intI]["DAM_Data"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["DAM_Data"]);                                                
                        $arrStrDados[$intI]["DAM_DataAceito"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["DAM_DataAceito"]);
                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoDadosEclesiasticos::getInstance()->consultar($arrStrFiltros);                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            
            $obj = new DadosEclesiasticos();            
            if(isset($arrStrDados["DAM_ID"])){
                $obj->setId($arrStrDados["DAM_ID"]);
            }            
            
            $membro = new Membro();
            if(isset($arrStrDados["PES_ID"])){
                $membro->setId($arrStrDados["PES_ID"]);
            }
            $obj->setMembro($membro);
            
            if(isset($arrStrDados["DAM_Data"])){
                $obj->setData($arrStrDados["DAM_Data"]);
            }
            if(isset($arrStrDados["DAM_DataAceito"])){
                $obj->setDataAceito($arrStrDados["DAM_DataAceito"]);
            }
            if(isset($arrStrDados["DAM_IgrejaNome"])){
                $obj->setIgrejaNome($arrStrDados["DAM_IgrejaNome"]);
            }
            if(isset($arrStrDados["DAM_IgrejaCidade"])){
                $obj->setIgrejaCidade($arrStrDados["DAM_IgrejaCidade"]);
            }
            if(!empty($arrStrDados["DAM_IgrejaUf"])){
                $obj->setIgrejaUf($arrStrDados["DAM_IgrejaUf"]);
            }
            if(isset($arrStrDados["DAM_IgrejaPastor"])){
                $obj->setIgrejaPastor($arrStrDados["DAM_IgrejaPastor"]);
            }
            if(isset($arrStrDados["DAM_Ano"])){
                $obj->setAno($arrStrDados["DAM_Ano"]);
            }
            if(isset($arrStrDados["DAM_Tipo"])){
                $obj->setTipo($arrStrDados["DAM_Tipo"]);
            }
            if(isset($arrStrDados["DAM_NumeroAta"])){
                $obj->setNumeroAta($arrStrDados["DAM_NumeroAta"]);
            }            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if(isset($arrStrDados["DAM_Data"])){
                if(trim($arrStrDados["DAM_Data"]) != ""){
                    $obj->setData(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["DAM_Data"]));
                }
            }
            if(isset($arrStrDados["DAM_DataAceito"])){
                if(trim($arrStrDados["DAM_DataAceito"]) != ""){
                    $obj->setDataAceito(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["DAM_DataAceito"]));
                }
            }
            
            
            return RepoDadosEclesiasticos::getInstance()->salvar($obj);            
        }
        
        public function excluir($arrStrDados){            
            $obj = $this->factory($arrStrDados);            
            return RepoDadosEclesiasticos::getInstance()->excluir($obj);
        }
        
    }
?>