<?php
    // codificação utf-8
    class NegPatrimonio {
        private static $objInstance;
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegPatrimonio();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoPatrimonio::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                     $douValorTotalEstimado = 0;
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);                        
                        
                        $douValorTotalEstimado += doubleval($arrStrDados[$intI]["PTM_ValorEstimado"]);
                        
                        if(trim($arrStrDados[$intI]["PTM_DataAquisicao"]) != ""){
                            $arrStrDados[$intI]["PTM_DataAquisicao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PTM_DataAquisicao"]); 
                        }else{
                            $arrStrDados[$intI]["PTM_DataAquisicao"] = "";
                        }
                        
                        if(trim($arrStrDados[$intI]["PTM_DataExpiracaoGarantia"]) != ""){
                            $arrStrDados[$intI]["PTM_DataExpiracaoGarantia"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PTM_DataExpiracaoGarantia"]);                        
                        }else{
                            $arrStrDados[$intI]["PTM_DataExpiracaoGarantia"] = "";
                        }
                        
                        if(trim($arrStrDados[$intI]["PTM_NumeroTombamento"]) != ""){
                            $strTombamento = substr($arrStrDados[$intI]["PTM_NumeroTombamento"], 0, 3).".";
                            $strTombamento .= substr($arrStrDados[$intI]["PTM_NumeroTombamento"], 3, 4).".";
                            $strTombamento .= substr($arrStrDados[$intI]["PTM_NumeroTombamento"], 7, 4)."-";
                            $strTombamento .= substr($arrStrDados[$intI]["PTM_NumeroTombamento"], 11); 
                            
                            $arrStrDados[$intI]["PTM_NumeroTombamento"] = $strTombamento;
                        }
                        
                        $arrStrDados[$intI]["PTM_ValorEstimado"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["PTM_ValorEstimado"]);
                    }
 
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    $arrObjsRetorno["totalValorEstimado"] = NumeroHelper::getInstance()->formatarMoeda($douValorTotalEstimado);
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoPatrimonio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){            
            $obj = new Patrimonio(); 
            
            if(isset($arrStrDados["PTM_ID"])){
                $obj->setId($arrStrDados["PTM_ID"]);  
            }
            
            //obj tipo patrimonio
            $objTipo = new TipoPatrimonio();            
            if(isset($arrStrDados["TIP_ID"])){
                $objTipo->setId($arrStrDados["TIP_ID"]);
            }            
            if(isset($arrStrDados["TIP_Descricao"])){
                $objTipo->setDescricao($arrStrDados["TIP_Descricao"]);
            }             
            $obj->setTipoPatrimonio($objTipo);
            //obj tipo patrimonio
            
            
            //obj forma aquisicao patrimonio
            $objFormaAquisicao = new FormaAquisicao();            
            if(isset($arrStrDados["FRA_ID"])){
                $objFormaAquisicao->setId($arrStrDados["FRA_ID"]);
            }
            if(isset($arrStrDados["FRA_Descricao"])){
                $objFormaAquisicao->setDescricao($arrStrDados["FRA_Descricao"]);
            }            
            $obj->setFormaAquisicao($objFormaAquisicao);
            //obj forma aquisicao patrimonio            
            
            
            //obj usuario cadastro            
            $objUsuario = new Usuario();
            if(isset($arrStrDados["Usuario_Cadastro_Id"])){
                if(isset($arrStrDados["Usuario_Cadastro_Id"])){
                    $objUsuario->setId($arrStrDados["Usuario_Cadastro_Id"]);
                }
                if(isset($arrStrDados["Usuario_Cadastro"])){
                    $objUsuario->setLogin($arrStrDados["Usuario_Cadastro"]);
                }                
            }else{
                $objUsuario->setId($_SESSION["USUARIO_ID"]);
            }
            $obj->setUsuarioCadastro($objUsuario);
            //obj usuario cadastro
            
            
            //obj usuario alteracao
            $objUsuarioAlteracao = new Usuario();
            if(isset($arrStrDados["Usuario_Alteracao_Id"])){
                if(isset($arrStrDados["Usuario_Alteracao_Id"])){
                    $objUsuarioAlteracao->setId($arrStrDados["Usuario_Alteracao_Id"]);
                }
                if(isset($arrStrDados["Usuario_Alteracao"])){
                    $objUsuarioAlteracao->setLogin($arrStrDados["Usuario_Alteracao"]);
                }                
            }else{
                if(isset($_SESSION["USUARIO_ID"])){
                    $objUsuarioAlteracao->setId($_SESSION["USUARIO_ID"]);
                }
            }
            $obj->setUsuarioAlteracao($objUsuarioAlteracao);
            //obj usuario alteracao
            
            
            // item patrimonio
            $objItem = new ItemPatrimonio();            
            if(isset($arrStrDados["ITP_ID"])){
                $objItem->setId($arrStrDados["ITP_ID"]);
            }            
            if(isset($arrStrDados["IPT_Descricao"])){
                $objItem->setDescricao($arrStrDados["IPT_Descricao"]);
            }            
            $obj->setItemPatrimonio($objItem);
            // item patrimonio
            
            
            // item congregacao
            $objCongregacao = new Congregacao();
            $objCongregacao->setId("(NULL)");
            if(isset($arrStrDados["UNI_Localizacao_ID"])){
                if(trim($arrStrDados["UNI_Localizacao_ID"]) != ""){
                    $objCongregacao->setId($arrStrDados["UNI_Localizacao_ID"]);
                }
            }            
            if(isset($arrStrDados["UNI_Descricao"])){
                $objCongregacao->setDescricao($arrStrDados["UNI_Descricao"]);
            }            
            $obj->setCongregacao($objCongregacao);
            // item congregacao
            
            
            if(isset($arrStrDados["PTM_NumeroTombamento"])){
                $strTombamento = substr($arrStrDados["PTM_NumeroTombamento"], 0, 3).".";
                $strTombamento .= substr($arrStrDados["PTM_NumeroTombamento"], 3, 4).".";
                $strTombamento .= substr($arrStrDados["PTM_NumeroTombamento"], 7, 4)."-";
                $strTombamento .= substr($arrStrDados["PTM_NumeroTombamento"], 11); 
                $obj->setNumeroTombamento($strTombamento);  
            }
            
            
            if(isset($arrStrDados["PTM_DataAquisicao"])){
                if($arrStrDados["PTM_DataAquisicao"] == null){
                    $obj->setDataAquisicao(null);
                }
                else{
                    $intTotOcorrencia = substr_count($arrStrDados["PTM_DataAquisicao"], "/");                      
                    if($intTotOcorrencia > 0){
                        $obj->setDataAquisicao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PTM_DataAquisicao"]));
                    }else{
                        $obj->setDataAquisicao(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["PTM_DataAquisicao"]));
                    }
                }
            }
            
            if(isset($arrStrDados["PTM_DataHoraCadastro"])){
                if($arrStrDados["PTM_DataHoraCadastro"] == null){
                    $obj->setDataHoraCadastro(null);
                }
                else{
                    $intTotOcorrencia = substr_count($arrStrDados["PTM_DataHoraCadastro"], "/");
                    if($intTotOcorrencia > 0){
                        $obj->setDataHoraCadastro(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PTM_DataHoraCadastro"]));
                    }else{
                        $obj->setDataHoraCadastro(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["PTM_DataHoraCadastro"]));
                    }
                }
            }
            
            if(isset($arrStrDados["PES_DataHoraAlteracao"])){                
                if($arrStrDados["PES_DataHoraAlteracao"] == null){
                    $obj->setDataHoraAlteracao(null);
                }
                else{                    
                    $intTotOcorrencia = substr_count($arrStrDados["PES_DataHoraAlteracao"], "/");
                    if($intTotOcorrencia > 0){                        
                        $obj->setDataHoraAlteracao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PES_DataHoraAlteracao"]));
                    }else{
                        $obj->setDataHoraAlteracao(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["PES_DataHoraAlteracao"]));
                    }
                }
            }
            
            if(isset($arrStrDados["PTM_DataExpiracaoGarantia"])){                
                if($arrStrDados["PTM_DataExpiracaoGarantia"] == null){
                    $obj->setDataExpiracaoGarantia(null);
                }
                else{                    
                    $intTotOcorrencia = substr_count($arrStrDados["PTM_DataExpiracaoGarantia"], "/");
                    if($intTotOcorrencia > 0){                        
                        $obj->setDataExpiracaoGarantia(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PTM_DataExpiracaoGarantia"]));
                    }else{
                        $obj->setDataExpiracaoGarantia(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["PTM_DataExpiracaoGarantia"]));
                    }
                }
            }
                        
            if(isset($arrStrDados["PTM_Observacao"])){
                $obj->setObservacao($arrStrDados["PTM_Observacao"]);
            }
            
            if(isset($arrStrDados["PTM_Condicao"])){
                $obj->setCondicao($arrStrDados["PTM_Condicao"]);
            }
            
            if(isset($arrStrDados["PTM_ValorEstimado"])){
                //$obj->setValorEstimado(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PTM_ValorEstimado"]));
                $obj->setValorEstimado($arrStrDados["PTM_ValorEstimado"]);
            }
            
            if(isset($arrStrDados["PTM_Numero"])){
                $obj->setNumero($arrStrDados["PTM_Numero"]);
            }
            
            if(isset($arrStrDados["PTM_Descricao"])){
                $obj->setDescricao($arrStrDados["PTM_Descricao"]);
            }
            
            if(isset($arrStrDados["PTM_Quantidade"])){
                $obj->setQuantidade($arrStrDados["PTM_Quantidade"]);
            }
            
            if(isset($arrStrDados["PTM_Foto"])){
                $obj->setFoto($arrStrDados["PTM_Foto"]);
            }
            
            if(isset($arrStrDados["PTM_Fabricante"])){
                $obj->setFabricante($arrStrDados["PTM_Fabricante"]);
            }
            
            // fornecedor
            $objFornecedor = new Fornecedor();
            if(isset($arrStrDados["FOR_ID"])){
                if(trim($arrStrDados["FOR_ID"]) != ""){
                    $objFornecedor->setId($arrStrDados["FOR_ID"]);
                }
            }            
            $obj->setFornecedor($objFornecedor);
            // fornecedor
            
            if(isset($arrStrDados["PTM_NumeroDocumento"])){
                $obj->setNumeroDocumento($arrStrDados["PTM_NumeroDocumento"]);
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            $obj->setFoto($arrStrDados["PTM_Foto"]); 
            $obj->setValorEstimado(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PTM_ValorEstimado"]));
            
            
            if($obj->getId() == ""){                
                return RepoPatrimonio::getInstance()->salvar($obj);
            }else{
                return RepoPatrimonio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){             
            if(is_array($arrStrDados["PTM_ID"])){
                for($intI=0; $intI<count($arrStrDados["PTM_ID"]); $intI++){
                    $obj = new Patrimonio();
                    $obj->setId($arrStrDados["PTM_ID"][$intI]);                    
                    RepoPatrimonio::getInstance()->excluir($obj);
                }
            }             
            return true;
        }
    }
?>