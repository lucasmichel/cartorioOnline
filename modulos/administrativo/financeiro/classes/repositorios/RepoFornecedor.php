<?php
    // codificação utf-8
    class RepoFornecedor{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFornecedor();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = "*";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_FOR_FORNECEDORES AS F "; 
            $strSQL .= "LEFT JOIN FIN_BAN_BANCOS AS B ON (B.BAN_ID=F.BAN_ID) "; 
            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID=F.PES_ID) "; 
            $strSQL .= "LEFT JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID=F.PES_ID) ";             
            $strSQL .= "WHERE F.FOR_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["FOR_ID"])){
                $strSQL .= "AND F.FOR_ID = ".trim($arrStrFiltros["FOR_ID"])." ";
            }

            if(!empty($arrStrFiltros["FOR_Tipo"])){
                $strSQL .= "AND F.FOR_Tipo = '".$arrStrFiltros["FOR_Tipo"]."' ";
            }
            
            if(!empty($arrStrFiltros["FOR_NomeFantasia"])){
                $strSQL .= "AND F.FOR_NomeFantasia LIKE '%".$arrStrFiltros["FOR_NomeFantasia"]."%' ";
            }
            
            if(!empty($arrStrFiltros["FOR_CNPJ"])){
                $strSQL .= "AND F.FOR_CNPJ = '".$arrStrFiltros["FOR_CNPJ"]."' ";
            }
                        
            if(!empty($arrStrFiltros["FOR_Status"])){
                $strSQL .= "AND F.FOR_Status = '".$arrStrFiltros["FOR_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY F.FOR_NomeFantasia";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Fornecedor $obj){
            $strDataFundacao = "(NULL)";
            $strBanco = "(NULL)";
            $strMembro = "(NULL)";
            
            if($obj->getDataFundacao() != null){
                $strDataFundacao = "'".$obj->getDataFundacao()."'";
            }
            
            if($obj->getBanco() != null){
                if(trim($obj->getBanco()->getId()) != ""){
                    $strBanco = $obj->getBanco()->getId();
                }
            }
            
            if($obj->getMembro() != null){
                if(trim($obj->getMembro()->getId()) != ""){
                    $strMembro = $obj->getMembro()->getId();
                }
            }
            
            $strSQL = "INSERT INTO FIN_FOR_FORNECEDORES (";
                $strSQL .= "BAN_ID, PES_ID, FOR_NomeFantasia, FOR_RazaoSocial, FOR_CNPJ, FOR_InscricaoEstadual, FOR_DataFundacao, "; 
                $strSQL .= "FOR_RamoAtividade, FOR_Agencia,FOR_Conta, FOR_Site, FOR_Observacao, ";
                $strSQL .= "FOR_EnderecoCep,FOR_EnderecoLogradouro, FOR_EnderecoNumero, FOR_EnderecoComplemento, ";
                $strSQL .= "FOR_EnderecoPontoReferencia, FOR_EnderecoBairro, FOR_EnderecoCidade, FOR_EnderecoUf, FOR_Tipo, FOR_Status, USU_Cadastro_ID, FOR_DataHoraCadastro ";
            $strSQL .= ")VALUES(";
                $strSQL .= " ".$strBanco.", ".$strMembro.", '".$obj->getNomeFantasia()."', '".$obj->getRazaoSocial()."', ";
                $strSQL .= " '".$obj->getCNPJ()."', '".$obj->getInscricaoEstadual()."', ".$strDataFundacao.", ";
                $strSQL .= " '".$obj->getRamoAtividade()."', '".$obj->getAgencia()."', '".$obj->getConta()."', ";
                $strSQL .= " '".$obj->getSite()."', '".$obj->getObservacao()."', '".$obj->getEndereco()->getCep()."', ";
                $strSQL .= "'".$obj->getEndereco()->getLogradouro()."', '".$obj->getEndereco()->getNumero()."', ";
                $strSQL .= " '".$obj->getEndereco()->getComplemento()."', '".$obj->getEndereco()->getPontoReferencia()."', ";
                $strSQL .= " '".$obj->getEndereco()->getBairro()."', '".$obj->getEndereco()->getCidade()."', '".$obj->getEndereco()->getUf()."',";    
                $strSQL .= " '".$obj->getTipo()."', '".$obj->getStatus()."', ".$_SESSION["USUARIO_ID"].", '".date("Y-m-d H:i:s")."'";
            $strSQL .= ")";     
            
            if(Db::getInstance()->executar($strSQL)){
                return Db::getInstance()->getLastId();
            }else{
                return 0;
            }
        }
        
        public function alterar(Fornecedor $obj){            
            $strDataFundacao = "(NULL)";
            $strBanco = "(NULL)";
            $strMembro = "(NULL)";            
            if($obj->getDataFundacao() != null){
                $strDataFundacao = "'".$obj->getDataFundacao()."'";
            }
            if($obj->getBanco() != null){
                if(trim($obj->getBanco()->getId()) != ""){
                    $strBanco = $obj->getBanco()->getId();
                }
            }
            if($obj->getMembro() != null){
                if(trim($obj->getMembro()->getId()) != ""){
                    $strMembro = $obj->getMembro()->getId();
                }
            }
            $strSQL  = "UPDATE FIN_FOR_FORNECEDORES SET ";
                $strSQL .= " BAN_ID=".$strBanco.", PES_ID=".$strMembro.", FOR_NomeFantasia='".$obj->getNomeFantasia()."', FOR_RazaoSocial='".$obj->getRazaoSocial()."', ";
                $strSQL .= " FOR_CNPJ='".$obj->getCNPJ()."', FOR_InscricaoEstadual='".$obj->getInscricaoEstadual()."', FOR_DataFundacao=".$strDataFundacao.", ";
                $strSQL .= " FOR_RamoAtividade='".$obj->getRamoAtividade()."', FOR_Agencia='".$obj->getAgencia()."', FOR_Conta='".$obj->getConta()."', ";
                $strSQL .= " FOR_Site='".$obj->getSite()."',  FOR_Observacao='".$obj->getObservacao()."', FOR_EnderecoCep='".$obj->getEndereco()->getCep()."', ";
                $strSQL .= " FOR_EnderecoLogradouro='".$obj->getEndereco()->getLogradouro()."', FOR_EnderecoNumero='".$obj->getEndereco()->getNumero()."', ";
                $strSQL .= " FOR_EnderecoComplemento='".$obj->getEndereco()->getComplemento()."', FOR_EnderecoPontoReferencia='".$obj->getEndereco()->getPontoReferencia()."', ";
                $strSQL .= " FOR_EnderecoBairro='".$obj->getEndereco()->getBairro()."', FOR_EnderecoCidade='".$obj->getEndereco()->getCidade()."', FOR_EnderecoUf='".$obj->getEndereco()->getUf()."',";    
                $strSQL .= " FOR_Tipo='".$obj->getTipo()."', FOR_Status='".$obj->getStatus()."', USU_Alteracao_ID=".$_SESSION["USUARIO_ID"].", FOR_DataHoraAlteracao='".date("Y-m-d H:i:s")."' ";
            $strSQL .= "WHERE FOR_ID = ".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM FIN_FOR_FORNECEDORES WHERE FOR_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>