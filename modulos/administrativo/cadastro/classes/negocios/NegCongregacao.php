<?php
    // codificação utf-8
    class NegCongregacao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegCongregacao();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoCongregacao::getInstance()->consultar($arrStrFiltros);
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
                    $arrStrDadosTotal = RepoCongregacao::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Congregacao();            
            if(isset($arrStrDados["UNI_ID"])){
                $obj->setId($arrStrDados["UNI_ID"]);
            }            
            if(isset($arrStrDados["UNI_Descricao"])){
                $obj->setDescricao($arrStrDados["UNI_Descricao"]);
            }
            if(isset($arrStrDados["UNI_Telefone"])){
                $obj->setTelefone($arrStrDados["UNI_Telefone"]);
            }
            if(isset($arrStrDados["UNI_Fax"])){
                $obj->setFax($arrStrDados["UNI_Fax"]);
            }
            
            $objEndereco = new Endereco();
            
            if(isset($arrStrDados["UNI_EnderecoCep"])){
                $objEndereco->setCep($arrStrDados["UNI_EnderecoCep"]);
            }
            
            if(isset($arrStrDados["UNI_EnderecoLogradouro"])){
                $objEndereco->setLogradouro($arrStrDados["UNI_EnderecoLogradouro"]);
            }
            
            if(isset($arrStrDados["UNI_EnderecoNumero"])){
                $objEndereco->setNumero($arrStrDados["UNI_EnderecoNumero"]);
            }
            
            if(isset($arrStrDados["UNI_EnderecoComplemento"])){
                $objEndereco->setComplemento($arrStrDados["UNI_EnderecoComplemento"]);
            }
            
            if(isset($arrStrDados["UNI_EnderecoBairro"])){
                $objEndereco->setBairro($arrStrDados["UNI_EnderecoBairro"]);
            }
             
            if(isset($arrStrDados["UNI_EnderecoCidade"])){
                $objEndereco->setCidade($arrStrDados["UNI_EnderecoCidade"]);
            }
            
            if(isset($arrStrDados["UNI_EnderecoUf"])){
                $objEndereco->setUf($arrStrDados["UNI_EnderecoUf"]);
            }
            
            if(isset($arrStrDados["UNI_EnderecoPontoReferencia"])){
                $objEndereco->setPontoReferencia($arrStrDados["UNI_EnderecoPontoReferencia"]);
            }           
            $obj->setEndereco($objEndereco);
            
            if(isset($arrStrDados["UNI_Observacao"])){
                $obj->setObservacao($arrStrDados["UNI_Observacao"]);  
            }            
            if(isset($arrStrDados["UNI_Responsavel"])){
                $obj->setResponsavel($arrStrDados["UNI_Responsavel"]);   
            }
            if(isset($arrStrDados["UNI_Status"])){
                $obj->setStatus($arrStrDados["UNI_Status"]);                   
            }else{
                $obj->setStatus("A");
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            
            if($obj->getId() == ""){                
                return RepoCongregacao::getInstance()->salvar($obj);
            }else{ 
                return RepoCongregacao::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){  
            $obj = new Congregacao();
            $obj->setId($arrStrDados["UNI_ID"][0]);
            return RepoCongregacao::getInstance()->excluir($obj);
            
        }
    }
?>