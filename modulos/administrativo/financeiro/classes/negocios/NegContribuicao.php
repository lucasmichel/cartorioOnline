<?php
    // codificação utf-8
    class NegContribuicao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegContribuicao();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){                 
            $arrStrDados = RepoContribuicao::getInstance()->consultar($arrStrFiltros);            
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    $douTotalContribuicoes = 0;
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){ 
                        $douTotalContribuicoes += doubleval($arrStrDados[$intI]["CTB_Valor"]);                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        // formata��es
                        $arrStrDados[$intI]["CTB_DataContribuicao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["CTB_DataContribuicao"]);
                        $arrStrDados[$intI]["CTB_Valor"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["CTB_Valor"]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;                    
                    $arrObjsRetorno["totalContribuicoes"] = NumeroHelper::getInstance()->formatarMoeda($douTotalContribuicoes);
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoContribuicao::getInstance()->consultar($arrStrFiltros);
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new Contribuicao();
            
            if(isset($arrStrDados["CTB_ID"])){
                $obj->setId($arrStrDados["CTB_ID"]);
            }  
            
            $objCentroCusto = new CentroCusto();            
            if(isset($arrStrDados["CEN_ID"])){
                $objCentroCusto->setId($arrStrDados["CEN_ID"]);            
            }
            if(isset($arrStrDados["CEN_Descricao"])){
                $objCentroCusto->setDescricao($arrStrDados["CEN_Descricao"]);            
            }            
            $obj->setCentroCusto($objCentroCusto);  
            
            $objContaBancaria = new ContaBancaria();
            if(isset($arrStrDados["COB_ID"])){
                $objContaBancaria->setId($arrStrDados["COB_ID"]);            
            }            
            if(isset($arrStrDados["COB_Descricao"])){
                $objContaBancaria->setDescricao($arrStrDados["COB_Descricao"]);            
            }            
            $obj->setContaBancaria($objContaBancaria);
            
            $objPessoa = new Pessoa();
            if(isset($arrStrDados["PES_ID"])){
                $objPessoa->setId($arrStrDados["PES_ID"]);            
            }            
            if(isset($arrStrDados["PES_Nome"])){
                $objPessoa->setNome($arrStrDados["PES_Nome"]);            
            }           
            $obj->setPessoa($objPessoa);
            
            $objFormaPagamento = new FormaPagamento();
            if(isset($arrStrDados["FPG_ID"])){
                $objFormaPagamento->setId($arrStrDados["FPG_ID"]);            
            }            
            if(isset($arrStrDados["FPG_Descricao"])){
                $objFormaPagamento->setDescricao($arrStrDados["FPG_Descricao"]);            
            }            
            $obj->setFormaPagamento($objFormaPagamento);
            
            $objPlanoConta = new PlanoConta();
            if(isset($arrStrDados["PLA_ID"])){
                $objPlanoConta->setId($arrStrDados["PLA_ID"]);            
            }            
            if(isset($arrStrDados["PLA_Descricao"])){
                $objPlanoConta->setDescricao($arrStrDados["PLA_Descricao"]);            
            }            
            $obj->setPlanoConta($objPlanoConta);
            
            $objLote = new Lote();
            if(isset($arrStrDados["LOT_ID"])){
                $objLote->setId($arrStrDados["LOT_ID"]);            
            }            
            if(isset($arrStrDados["LOT_Descricao"])){
                $objLote->setDescricao($arrStrDados["LOT_Descricao"]);            
            }            
            $obj->setLote($objLote);
            
            if(isset($arrStrDados["CTB_DataContribuicao"])){
                $obj->setData($arrStrDados["CTB_DataContribuicao"]);            
            } 
            
            if(isset($arrStrDados["CTB_Referencia"])){
                $obj->setReferencia($arrStrDados["CTB_Referencia"]);            
            } 
            
            if(isset($arrStrDados["CTB_Valor"])){                
                $obj->setValor($arrStrDados["CTB_Valor"]);                    
            }            
            if(isset($arrStrDados["CTB_Observacao"])){
                $obj->setObservacao($arrStrDados["CTB_Observacao"]);            
            } 
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            $obj->setData(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($obj->getData()));
            $obj->setValor(NumeroHelper::getInstance()->formatarNumeroParaBanco($obj->getValor()));
            
            if($obj->getId() == ""){                
                return RepoContribuicao::getInstance()->salvar($obj);            
            }else{
                return RepoContribuicao::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){             
            $obj = new Contribuicao();
            $obj->setId($arrStrDados["CTB_ID"][0]);                    
            return RepoContribuicao::getInstance()->excluir($obj);
        }
    }
?>