<?php
    // codificação utf-8
    class NegMalaDiretaPessoa{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegMalaDiretaPessoa();
            }
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoMalaDiretaPessoa::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["MDP_DataHoraEnvio"] = $arrObjs[$intI]->getDataEnvio();     
                        $arrStrDados[$intI]["MDP_DataHoraLeitura"] = $arrObjs[$intI]->getDataVisualizacao();     
                    }
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoMalaDiretaPessoa::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }
        
        
        
        private function factory($arrStrDados){
            
            $obj = new MalaDiretaPessoa();                        
            if(isset($arrStrDados["MDP_ID"])){
                $obj->setId($arrStrDados["MDP_ID"]);
            }            
            $malaDireta = new MalaDireta();
            if(isset($arrStrDados["MAD_ID"])){
                $malaDireta->setId($arrStrDados["MAD_ID"]);
            }
            $obj->setMalaDireta($malaDireta);            
            $pessoa = new Pessoa();
            if(isset($arrStrDados["PES_ID"])){
                $arrConsultaPessoa["PES_ID"] = $arrStrDados["PES_ID"];
                $arrObjPessoa = NegPessoa::getInstance()->consultar($arrConsultaPessoa);                
                $pessoa = $arrObjPessoa[0];                
            }
            $obj->setPessoa($pessoa);        
            
            if(!empty($arrStrDados["MDP_DataHoraEnvio"])){           
                $intTotOcorrencia = substr_count($arrStrDados["MDP_DataHoraEnvio"], "/");                
                if($intTotOcorrencia > 0){                    
                    $obj->setDataEnvio(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MDP_DataHoraEnvio"]));
                }else{                                        
                    $obj->setDataEnvio(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["MDP_DataHoraEnvio"]));
                }                
            }else{
                $obj->setDataEnvio(null);
            }
            if(!empty($arrStrDados["MDP_DataHoraLeitura"])){           
                $intTotOcorrencia = substr_count($arrStrDados["MDP_DataHoraLeitura"], "/");                
                if($intTotOcorrencia > 0){                    
                    $obj->setDataVisualizacao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MDP_DataHoraLeitura"]));
                }else{                                        
                    $obj->setDataVisualizacao(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["MDP_DataHoraLeitura"]));
                }                
            }else{
                $obj->setDataVisualizacao(null);
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));                                
            if($obj->getId() == ""){                
                return RepoMalaDiretaPessoa::getInstance()->salvar($obj);
            }else{ 
                return RepoMalaDiretaPessoa::getInstance()->alterar($obj);
            }
        }
        
        public function registrarVisualizacaoEmail($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            return RepoMalaDiretaPessoa::getInstance()->registrarVisualizacaoEmail($obj);
            
        }
        
        public function retornaTotalVisualizadoEnviado($arrStrFiltros){
            
            //total de enviados
            $arrConsulta["MAD_ID"] = $arrStrFiltros["MAD_ID"];
            $arrConsulta["TOT_Total_Enviados"] = true;
            $arrayRetorno["totEnviado"] = RepoMalaDiretaPessoa::getInstance()->consultar($arrConsulta);
            
            $arrConsulta1["MAD_ID"] = $arrStrFiltros["MAD_ID"];
            $arrConsulta1["TOT_Total_Visualizado"] = true;
            $arrayRetorno["totVisualizado"] = RepoMalaDiretaPessoa::getInstance()->consultar($arrConsulta1);            
            
            return $arrayRetorno;
        }
        
    }
?>