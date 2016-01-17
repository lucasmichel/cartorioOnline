<?php
    // codificação utf-8
    class NegMotivosDesligamentoMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegMotivosDesligamentoMembro();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoMotivoDesligamentoMembro::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["PCD_Data"] = $arrObjs[$intI]->getData();
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoMotivoDesligamentoMembro::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new MotivosDesligamentoMembro();            
            $pessoa = new Pessoa();
            if(isset($arrStrDados["PES_ID"])){
                $pessoa->setId($arrStrDados["PES_ID"]);
            }else{
                $pessoa->setPessoa(null);
            }
            $obj->setPessoa($pessoa);
                        
            if(isset($arrStrDados["PCD_Descricao"])){
                $obj->setDescricao($arrStrDados["PCD_Descricao"]);
            }
            if(isset($arrStrDados["PCD_Data"])){
                $intTotOcorrencia = substr_count($arrStrDados["PCD_Data"], "/");                
                if($intTotOcorrencia > 0){                    
                    $obj->setData(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PCD_Data"]));
                }else{                    
                    $obj->setData(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["PCD_Data"]));
                }                
            }else{
                $obj->setData(null);
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));            
            return RepoMotivoDesligamentoMembro::getInstance()->salvar($obj);
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));            
            return RepoMotivoDesligamentoMembro::getInstance()->excluir($obj);
        }
    }
?>