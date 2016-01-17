<?php
    // codificação utf-8
    class NegContaBancaria{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegContaBancaria();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoContaBancaria::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        // para guardar as formatações no rows
                        $arrStrDados[$intI]["COB_SaldoInicial"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["COB_SaldoInicial"]);            
                        $arrStrDados[$intI]["COB_DataAbertura"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["COB_DataAbertura"]);                        
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoContaBancaria::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new ContaBancaria();
            
            if(isset($arrStrDados["COB_ID"])){
                $obj->setId($arrStrDados["COB_ID"]);
            }
            
            // banco
            $objBanco = new Banco();
            $objBanco->setId($arrStrDados["BAN_ID"]);
            $obj->setBanco($objBanco);
            
            if(isset($arrStrDados["COB_Descricao"])){
                $obj->setDescricao($arrStrDados["COB_Descricao"]);
            }
            
            if(isset($arrStrDados["COB_DataAbertura"])){
                $obj->setDataAbertura($arrStrDados["COB_DataAbertura"]);
            }
            
            if(isset($arrStrDados["COB_Agencia"])){
                $obj->setAgencia($arrStrDados["COB_Agencia"]);
            }
            
            if(isset($arrStrDados["COB_Conta"])){
                $obj->setConta($arrStrDados["COB_Conta"]);
            }
            
            if(isset($arrStrDados["COB_SaldoInicial"])){
                $obj->setSaldoInicial($arrStrDados["COB_SaldoInicial"]);
            }else{
                $obj->setLimite(0);
            }
            
            if(isset($arrStrDados["COB_Observacao"])){
                $obj->setObservacao($arrStrDados["COB_Observacao"]);
            }
            
            if(isset($arrStrDados["COB_Status"])){
                $obj->setStatus($arrStrDados["COB_Status"]);
            }else{
                $obj->setStatus("A");
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            $obj->setSaldoInicial(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["COB_SaldoInicial"])); 
            
            if(isset($arrStrDados["COB_DataAbertura"])){
                if(trim($arrStrDados["COB_DataAbertura"]) != ""){
                    $obj->setDataAbertura(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["COB_DataAbertura"]));
                }
            }
                        
            if($obj->getId() == ""){                
                return RepoContaBancaria::getInstance()->salvar($obj);
            }else{ 
                return RepoContaBancaria::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new ContaBancaria();
            $obj->setId($arrStrDados["COB_ID"][0]);
            return RepoContaBancaria::getInstance()->excluir($obj);
        }
        
        public function getSaldoContaBancaria($arrStrDados){
            $obj = new ContaBancaria();
            $obj->setId($arrStrDados["COB_ID"]);
            $arrRetorno["valor"] = RepoContaBancaria::getInstance()->consultarSaldoContaBancaria($obj);
            $arrRetorno["saldo"] = NumeroHelper::getInstance()->formatarMoeda($arrRetorno["valor"]);
            return $arrRetorno;
        }
    }
?>