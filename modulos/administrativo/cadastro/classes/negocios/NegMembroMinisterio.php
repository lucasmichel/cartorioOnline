<?php
    // codificação utf-8
    class NegMembroMinisterio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegMembroMinisterio();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){         
           
            $arrStrDados = RepoMembroMinisterio::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        $arrStrDados[$intI]["MMI_Desde"] = $arrObjs[$intI]->getDataDesde();
                        $arrStrDados[$intI]["MMI_Ate"] = $arrObjs[$intI]->getDataAte();
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoMembroMinisterio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new MembroMinisterio();            
            
            $objMembro = new Membro();
            if(isset($arrStrDados["PES_ID"])){
                $objMembro->setId($arrStrDados["PES_ID"]);
            }    
            if(isset($arrStrDados["PES_Nome"])){
                $objMembro->setNome($arrStrDados["PES_Nome"]);
            }    
            $obj->setMembro($objMembro);
            
            $objMinisterio = new Ministerio();
            if(isset($arrStrDados["MIN_ID"])){
                $objMinisterio->setId($arrStrDados["MIN_ID"]);
            }
            if(isset($arrStrDados["MIN_Descricao"])){
                $objMinisterio->setDescricao($arrStrDados["MIN_Descricao"]);
            }            
            $areaMinisterial = new AreaMinisterial();
            if(isset($arrStrDados["AMI_ID"])){
                $areaMinisterial->setId($arrStrDados["AMI_ID"]);
            }
            if(isset($arrStrDados["AMI_Descricao"])){
                $areaMinisterial->setDescricao($arrStrDados["AMI_Descricao"]);
            }
            $objMinisterio->setObjAreaMinisterial($areaMinisterial);            
            $obj->setMinisterio($objMinisterio);
            
            if(isset($arrStrDados["MMI_Desde"])){
                $intTotOcorrencia = substr_count($arrStrDados["MMI_Desde"], "/");                  
                if($intTotOcorrencia > 0){
                    //veio com / então retira
                    $obj->setDataDesde(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MMI_Desde"]));
                }else{                      
                    $intTotOcorrencia2 = substr_count($arrStrDados["MMI_Desde"], "-");  
                    if($intTotOcorrencia2 > 0){                        
                        $obj->setDataDesde(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["MMI_Desde"]));
                    }else{
                        $obj->setDataDesde(null);
                    }
                }
            }
            
            if(isset($arrStrDados["MMI_Ate"])){
                $intTotOcorrencia = substr_count($arrStrDados["MMI_Ate"], "/");                  
                if($intTotOcorrencia > 0){
                    //veio com / então retira
                    $obj->setDataAte(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MMI_Ate"]));
                }else{                      
                    $intTotOcorrencia2 = substr_count($arrStrDados["MMI_Ate"], "-");  
                    if($intTotOcorrencia2 > 0){                        
                        $obj->setDataAte(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["MMI_Ate"]));
                    }else{
                        $obj->setDataAte(null);
                    }
                }
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){                        
            return RepoMembroMinisterio::getInstance()->salvar($this->factory($arrStrDados));    
        }
        
        public function excluir($arrStrDados){
            return RepoMembroMinisterio::getInstance()->excluir($this->factory($arrStrDados));    
        }
    }
?>