<?php
    // codificação utf-8
    class NegContaTransferencia{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegContaTransferencia();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            if(isset($arrStrFiltros["TRC_DataTransferenciaInicial"])){
                $arrStrFiltros["TRC_DataTransferenciaInicial"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrFiltros["TRC_DataTransferenciaInicial"]);
            }
            
            if(isset($arrStrFiltros["TRC_DataTransferenciaFinal"])){
                $arrStrFiltros["TRC_DataTransferenciaFinal"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrFiltros["TRC_DataTransferenciaFinal"]);
            }
            
            $arrStrDados = RepoContaTransferencia::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    //$douValorTotalLancamentos = 0;
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        $contOrigem = new ContaBancaria();
                        $contOrigem = $arrObjs[$intI]->getContaTransferenciaDe();
                        $arrStrDados[$intI]["descricaoContaDe"] = $contOrigem->getDescricao();
                        
                        $contDestino = new ContaBancaria();
                        $contDestino = $arrObjs[$intI]->getContaTransferenciaPara();
                        $arrStrDados[$intI]["descricaoContaPara"] = $contDestino->getDescricao();
                        
                        $arrStrDados[$intI]["TRC_Valor"] = NumeroHelper::getInstance()->formatarMoeda($arrObjs[$intI]->getValor());
                        
                        $arrStrDados[$intI]["TRC_DataTransferencia"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["TRC_DataTransferencia"]);                         
                        //$arrStrDados[$intI]["CON_ValorTotal"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["CON_ValorTotal"]);                   
                        
                        
                        
                        
                        
                        //$douValorTotalLancamentos += doubleval($arrStrDados[$intI]["CON_ValorTotal"]);
                        
                        //$arrStrDados[$intI]["CON_ProximoVencimento"] = "-";
                        
                        // identifica o próximo vencimento em aberto
                        /*$arrStrFiltrosProximoVencimento = array();
                        $arrStrFiltrosProximoVencimento["CON_ID"] = $arrStrDados[$intI]["CON_ID"];  
                        $arrStrDadosProximoVencimentoAberto = RepoContaTransferencia::getInstance()->consultarProximoVencimento($arrStrFiltrosProximoVencimento);
                        
                        if($arrStrDadosProximoVencimentoAberto != null){
                            if(count($arrStrDadosProximoVencimentoAberto) > 0){
                                $arrStrDados[$intI]["CON_ProximoVencimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosProximoVencimentoAberto[0]["PCL_DataProximoVencimento"]);
                            }
                        }*/
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoContaTransferencia::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        
        private function factory($arrStrDados){ 
            $obj = new ContaTransferencia();
            
            if(isset($arrStrDados["TRC_ID"])){
                $obj->setId($arrStrDados["TRC_ID"]);
            }
            
            if(isset($arrStrDados["TRC_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["TRC_DataHoraCadastro"]);
            }
            
            if(isset($arrStrDados["TRC_DataTransferencia"])){
                $obj->setDataTransferencia($arrStrDados["TRC_DataTransferencia"]);
            }
            
            if(isset($arrStrDados["TRC_Valor"])){
                $obj->setValor($arrStrDados["TRC_Valor"]);
            }
            
            if(isset($arrStrDados["COB_De_ID"])){
                $arrConsultaContaDe["COB_ID"] = $arrStrDados["COB_De_ID"];
                $arrObjConsultaDe = FachadaFinanceiro::getInstance()->consultarContaBancaria($arrConsultaContaDe);
                if($arrObjConsultaDe != null){
                    $arrObjConsultaDe = $arrObjConsultaDe["objects"];
                    $contaDe = new ContaBancaria();
                    $contaDe = $arrObjConsultaDe[0];
                    $obj->setContaTransferenciaDe($contaDe);
                }else{
                    $obj->setContaTransferenciaDe(null);
                }
            }else{
                $obj->setContaTransferenciaDe(null);
            }
            
            if(isset($arrStrDados["COB_Para_ID"])){
                $arrConsultaContaPara["COB_ID"] = $arrStrDados["COB_Para_ID"];
                $arrObjConsultaPara = FachadaFinanceiro::getInstance()->consultarContaBancaria($arrConsultaContaPara);
                if($arrObjConsultaPara != null){
                    $arrObjConsultaPara = $arrObjConsultaPara["objects"];
                    $contaPara = new ContaBancaria();
                    $contaPara = $arrObjConsultaPara[0];
                    $obj->setContaTransferenciaPara($contaPara);
                }else{
                    $obj->setContaTransferenciaPara(null);
                }
            }else{
                $obj->setContaTransferenciaPara(null);
            }
            
            
            if(isset($arrStrDados["USU_Cadastro_ID"])){
                $arrConsultaUsuarioCadastro["USU_Cadastro_ID"] = $arrStrDados["USU_Cadastro_ID"];
                $arrObjUsuario = FachadaGerencial::getInstance()->consultarUsuario($arrConsultaUsuarioCadastro);
                if($arrObjUsuario != null){
                    $arrObjUsuario = $arrObjUsuario["objects"];
                    $usuario = new Usuario();
                    $usuario = $arrObjUsuario[0];
                    $obj->setUsuarioCadastro($usuario);
                }else{
                    $obj->setUsuarioCadastro(null);
                }
            }else{
                $obj->setUsuarioCadastro(null);
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            $obj->setValor(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["TRC_Valor"]));
            $obj->setDataTransferencia(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["TRC_DataTransferencia"]));
            
            return RepoContaTransferencia::getInstance()->salvar($obj);
        }
        
        public function excluir($arrStrDados){            
            $obj = $this->factory($arrStrDados);                        
            return RepoContaTransferencia::getInstance()->excluir($obj);
        }
    }
?>