<?php
    // codificação utf-8
    class NegFluxoCaixa{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFluxoCaixa();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){                 
            $arrStrDados = RepoFluxoCaixa::getInstance()->consultar($arrStrFiltros);            
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    $douTotalLancamentos = 0;
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){ 
                        $douTotalLancamentos += doubleval($arrStrDados[$intI]["LCA_Valor"]);                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        // formata��es
                        $arrStrDados[$intI]["LCA_DataMovimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LCA_DataMovimento"]);
                        $arrStrDados[$intI]["LCA_Valor"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["LCA_Valor"]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;                    
                    $arrObjsRetorno["totalLancamentos"] = NumeroHelper::getInstance()->formatarMoeda($douTotalLancamentos);
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFluxoCaixa::getInstance()->consultar($arrStrFiltros);
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            
            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new FluxoCaixa();
            
            if(isset($arrStrDados["LCA_ID"])){
                $obj->setId($arrStrDados["LCA_ID"]);
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
            
            $objPessoa = null;
            $objFornecedor = null;
            
            if(isset($arrStrDados["LCA_TipoOrigem"])){
                if($arrStrDados["LCA_TipoOrigem"] == "P"){
                    $objPessoa = new Pessoa();
                    
                    if(isset($arrStrDados["PES_ID"])){
                        $objPessoa->setId($arrStrDados["PES_ID"]);            
                    }            
                    if(isset($arrStrDados["PES_Nome"])){
                        $objPessoa->setNome($arrStrDados["PES_Nome"]);            
                    }
                }else{
                    $objFornecedor = new Fornecedor();
                    if(isset($arrStrDados["FOR_ID"])){
                        $objFornecedor->setId($arrStrDados["FOR_ID"]);            
                    }            
                    if(isset($arrStrDados["FOR_NomeFantasia"])){
                        $objFornecedor->setNomeFantasia($arrStrDados["FOR_NomeFantasia"]);            
                    } 
                }
            }
                    
            $obj->setPessoa($objPessoa);
            $obj->setFornecedor($objFornecedor);
            
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
            
            if(isset($arrStrDados["LCA_DataMovimento"])){
                $obj->setData($arrStrDados["LCA_DataMovimento"]);            
            } 
            
            if(isset($arrStrDados["LCA_Referencia"])){
                $obj->setReferencia($arrStrDados["LCA_Referencia"]);            
            } 
            
            if(isset($arrStrDados["LCA_Valor"])){                
                $obj->setValor($arrStrDados["LCA_Valor"]);                    
            }            
            if(isset($arrStrDados["LCA_Observacao"])){
                $obj->setObservacao($arrStrDados["LCA_Observacao"]);            
            } 
            if(isset($arrStrDados["LCA_Descricao"])){
                $obj->setHistorico($arrStrDados["LCA_Descricao"]);            
            } 
            if(isset($arrStrDados["LCA_Tipo"])){
                $obj->setTipo($arrStrDados["LCA_Tipo"]);            
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            $obj->setData(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($obj->getData()));
            $obj->setValor(NumeroHelper::getInstance()->formatarNumeroParaBanco($obj->getValor()));
            
            if($obj->getId() == ""){                
                return RepoFluxoCaixa::getInstance()->salvar($obj);            
            }else{
                return RepoFluxoCaixa::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){             
            $obj = new FluxoCaixa();
            $obj->setId($arrStrDados["LCA_ID"][0]);                    
            return RepoFluxoCaixa::getInstance()->excluir($obj);
        }
    }
?>