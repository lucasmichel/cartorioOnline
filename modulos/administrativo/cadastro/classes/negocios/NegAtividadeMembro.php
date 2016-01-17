<?php
    // codificação utf-8
    class NegAtividadeMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegAtividadeMembro();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){         
           
            $arrStrDados = RepoAtividadeMembro::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        $arrStrDados[$intI]["ATM_Desde"] = $arrObjs[$intI]->getDataDesde();
                        $arrStrDados[$intI]["ATM_Ate"] = $arrObjs[$intI]->getDataAte();
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoAtividadeMembro::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new AtividadeMembro();            
            
            $objMembro = new Membro();
            if(isset($arrStrDados["PES_ID"])){
                $objMembro->setId($arrStrDados["PES_ID"]);
            }    
            if(isset($arrStrDados["PES_Nome"])){
                $objMembro->setNome($arrStrDados["PES_Nome"]);
            }    
            $obj->setMembro($objMembro);
            
            $objAtividade = new Atividade();
            if(isset($arrStrDados["ATV_ID"])){
                $objAtividade->setId($arrStrDados["ATV_ID"]);
            }
            if(isset($arrStrDados["ATV_Descricao"])){
                $objAtividade->setDescricao($arrStrDados["ATV_Descricao"]);
            }
            if(isset($arrStrDados["ATV_ExigeData"])){
                $objAtividade->setExigeData($arrStrDados["ATV_ExigeData"]);
            }            
            if(isset($arrStrDados["ATV_Status"])){
                $objAtividade->setStatus($arrStrDados["ATV_Status"]);
            }            
            $obj->setAtividade($objAtividade);
            
            if(isset($arrStrDados["ATM_Desde"])){
                $intTotOcorrencia = substr_count($arrStrDados["ATM_Desde"], "/");                  
                if($intTotOcorrencia > 0){
                    //veio com / então retira
                    $obj->setDataDesde(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["ATM_Desde"]));
                }else{                      
                    $intTotOcorrencia2 = substr_count($arrStrDados["ATM_Desde"], "-");  
                    if($intTotOcorrencia2 > 0){                        
                        $obj->setDataDesde(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["ATM_Desde"]));
                    }else{
                        $obj->setDataDesde(null);
                    }
                }
            }
            
            if(isset($arrStrDados["ATM_Ate"])){
                $intTotOcorrencia = substr_count($arrStrDados["ATM_Ate"], "/");                  
                if($intTotOcorrencia > 0){
                    //veio com / então retira
                    $obj->setDataAte(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["ATM_Ate"]));
                }else{                      
                    $intTotOcorrencia2 = substr_count($arrStrDados["ATM_Ate"], "-");  
                    if($intTotOcorrencia2 > 0){                        
                        $obj->setDataAte(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["ATM_Ate"]));
                    }else{
                        $obj->setDataAte(null);
                    }
                }
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){                        
            return RepoAtividadeMembro::getInstance()->salvar($this->factory($arrStrDados));    
        }
        
        public function excluir($arrStrDados){
            return RepoAtividadeMembro::getInstance()->excluir($this->factory($arrStrDados));    
        }
    }
?>