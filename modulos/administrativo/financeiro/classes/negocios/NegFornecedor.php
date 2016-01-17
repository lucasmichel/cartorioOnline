<?php
    // codificação utf-8
    class NegFornecedor{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFornecedor();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){  
            if(isset($arrStrFiltros["FOR_PesquisaFiltro"])){
                if($arrStrFiltros["FOR_PesquisaFiltro"] == "NOME"){
                    $arrStrFiltros["FOR_NomeFantasia"] = $arrStrFiltros["FOR_PesquisaDescricao"];
                }else{
                    if($arrStrFiltros["FOR_PesquisaFiltro"] == "CNPJ" || $arrStrFiltros["FOR_PesquisaFiltro"] == "CPF"){
                        $arrStrFiltros["FOR_CNPJ"] = $arrStrFiltros["FOR_PesquisaDescricao"];
                    }
                }
            }            
            $arrStrDados = RepoFornecedor::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        if(trim($arrStrDados[$intI]["FOR_DataFundacao"]) != ""){
                            $arrStrDados[$intI]["FOR_DataFundacao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["FOR_DataFundacao"]);
                        }
                    }
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"] = $arrObjs;
                    $arrObjsRetorno["rows"]    = $arrStrDados;
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFornecedor::getInstance()->consultar($arrStrFiltros);                     
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Fornecedor();
            if(isset($arrStrDados["FOR_ID"])){
                $obj->setId($arrStrDados["FOR_ID"]);
            }
            $objBanco = new Banco();
            if(isset($arrStrDados["BAN_ID"])){
                $objBanco->setId($arrStrDados["BAN_ID"]);
            }            
            if(isset($arrStrDados["BAN_Descricao"])){
                $objBanco->setDescricao($arrStrDados["BAN_Descricao"]);
            }            
            $obj->setBanco($objBanco);
            
            $membro = new Membro();
            if(isset($arrStrDados["PES_ID"])){
                if($arrStrDados["PES_ID"]>0){                
                    $arrConsultaMembro["PES_ID"] = $arrStrDados["PES_ID"];
                    $arrDadosMembro = FachadaCadastro::getInstance()->consultarMembro($arrConsultaMembro);
                    if($arrDadosMembro!=null){
                        $membro = $arrDadosMembro["objects"][0];
                    }
                }
            }
            $obj->setMembro($membro);
            
            if(isset($arrStrDados["FOR_NomeFantasia"])){
                $obj->setNomeFantasia($arrStrDados["FOR_NomeFantasia"]);
            }
            if(isset($arrStrDados["FOR_RazaoSocial"])){
                $obj->setRazaoSocial($arrStrDados["FOR_RazaoSocial"]);
            }
            if(isset($arrStrDados["FOR_CNPJ"])){
                $obj->setCNPJ($arrStrDados["FOR_CNPJ"]);
            }
            if(isset($arrStrDados["FOR_InscricaoEstadual"])){
                $obj->setInscricaoEstadual($arrStrDados["FOR_InscricaoEstadual"]);
            }
            if(isset($arrStrDados["FOR_DataFundacao"])){
                $obj->setDataFundacao($arrStrDados["FOR_DataFundacao"]);                  
            }
            if(isset($arrStrDados["FOR_RamoAtividade"])){
                $obj->setRamoAtividade($arrStrDados["FOR_RamoAtividade"]);
            }
            if(isset($arrStrDados["FOR_Agencia"])){
                $obj->setAgencia($arrStrDados["FOR_Agencia"]);
            }
            if(isset($arrStrDados["FOR_Conta"])){
                $obj->setConta($arrStrDados["FOR_Conta"]);
            }            
            if(isset($arrStrDados["FOR_Site"])){
                $obj->setSite($arrStrDados["FOR_Site"]);
            }
            if(isset($arrStrDados["FOR_Observacao"])){
                $obj->setObservacao($arrStrDados["FOR_Observacao"]);
            }            
            $objEndereco = new Endereco();            
            if(isset($arrStrDados["FOR_EnderecoLogradouro"])){
                $objEndereco->setLogradouro($arrStrDados["FOR_EnderecoLogradouro"]);
            }
            if(isset($arrStrDados["FOR_EnderecoNumero"])){
                $objEndereco->setNumero($arrStrDados["FOR_EnderecoNumero"]);
            }
            if(isset($arrStrDados["FOR_EnderecoComplemento"])){
                $objEndereco->setComplemento($arrStrDados["FOR_EnderecoComplemento"]);
            }
            if(isset($arrStrDados["FOR_EnderecoBairro"])){
                $objEndereco->setBairro($arrStrDados["FOR_EnderecoBairro"]);
            }
            if(isset($arrStrDados["FOR_EnderecoCidade"])){
                $objEndereco->setCidade($arrStrDados["FOR_EnderecoCidade"]);
            }
            if(isset($arrStrDados["FOR_EnderecoUf"])){
                $objEndereco->setUf($arrStrDados["FOR_EnderecoUf"]);
            }
            if(isset($arrStrDados["FOR_EnderecoCep"])){
                $objEndereco->setCep($arrStrDados["FOR_EnderecoCep"]);
            }
            if(isset($arrStrDados["FOR_EnderecoPontoReferencia"])){
                $objEndereco->setPontoReferencia($arrStrDados["FOR_EnderecoPontoReferencia"]);
            }
            if(isset($arrStrDados["FOR_Status"])){  
                $obj->setStatus($arrStrDados["FOR_Status"]);
            }else{
                $obj->setStatus("A");
            }
            if(isset($arrStrDados["FOR_Tipo"])){
                $obj->setTipo($arrStrDados["FOR_Tipo"]);
            }else{
                $obj->setTipo("PJ");
            }
            $obj->setEndereco($objEndereco);
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            if($obj->getId() == ""){
                $intFornecedorID = RepoFornecedor::getInstance()->salvar($obj);                
                if($intFornecedorID > 0){
                    // grava os telefones
                    if(isset($arrStrDados["DADOS_FORNECEDOR"]["FONES"])){
                        if(count($arrStrDados["DADOS_FORNECEDOR"]["FONES"]) > 0){
                            foreach ($arrStrDados["DADOS_FORNECEDOR"]["FONES"] as $arrStrFone) {
                                $arrStrFone["FOR_ID"] = $intFornecedorID;                                 
                                NegFornecedorTelefone::getInstance()->salvar($arrStrFone);
                            }
                        }
                    }
                    // grava os e-mails
                    if(isset($arrStrDados["DADOS_FORNECEDOR"]["EMAILS"])){
                        if(count($arrStrDados["DADOS_FORNECEDOR"]["EMAILS"]) > 0){
                            foreach ($arrStrDados["DADOS_FORNECEDOR"]["EMAILS"] as $arrStrEmail) {
                                $arrStrEmail["FOR_ID"] = $intFornecedorID;                                 
                                NegFornecedorEmail::getInstance()->salvar($arrStrEmail);
                            }
                        }
                    }
                    return true;
                }else{
                    return false;
                }
            }else{
                
                
                //exclui os Telefones
                $arrDadosExcluirFone["FOR_ID"] = $obj->getId();
                NegFornecedorTelefone::getInstance()->excluir($arrDadosExcluirFone);
                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_FORNECEDOR"]["FONES"])){
                    foreach ($arrStrDados["DADOS_FORNECEDOR"]["FONES"] as $fone) {
                        $fone["FOR_ID"] = $obj->getId();
                        NegFornecedorTelefone::getInstance()->salvar($fone);
                    }
                }
                
                //exclui os Emails
                $arrDadosExcluirEmails["FOR_ID"] = $obj->getId();                
                NegFornecedorEmail::getInstance()->excluir($arrDadosExcluirEmails);
                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_FORNECEDOR"]["EMAILS"])){
                    foreach ($arrStrDados["DADOS_FORNECEDOR"]["EMAILS"] as $email) {
                        $email["FOR_ID"] = $obj->getId();                                              
                        NegFornecedorEmail::getInstance()->salvar($email);
                    }
                }
                
                if(RepoFornecedor::getInstance()->alterar($obj)){                    
                    return true;
                }else{
                    return true;
                }
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new Fornecedor();
            $obj->setId($arrStrDados["FOR_ID"][0]);            
            //exclui os Telefones
            $arrDadosExcluirFone["FOR_ID"] = $obj->getId();
            NegFornecedorTelefone::getInstance()->excluir($arrDadosExcluirFone);            
            //exclui os Emails
            $arrDadosExcluirEmails["FOR_ID"] = $obj->getId();                
            NegFornecedorEmail::getInstance()->excluir($arrDadosExcluirEmails);            
            return RepoFornecedor::getInstance()->excluir($obj);
        }
    }
?>