<?php
    // codificação utf-8
    class RepoCongregacao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoCongregacao();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_UNI_UNIDADES "; 
            $strSQL .= "WHERE UNI_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["UNI_ID"])){
                $strSQL .= "AND UNI_ID = ".trim($arrStrFiltros["UNI_ID"])." ";
            }

            if(!empty($arrStrFiltros["UNI_Descricao"])){
                $strSQL .= "AND UNI_Descricao LIKE  '%".trim($arrStrFiltros["UNI_Descricao"])."%' ";
            }            
              
            if(!empty($arrStrFiltros["UNI_Status"])){
                $strSQL .= "AND UNI_Status = '".$arrStrFiltros["UNI_Status"]."' ";
            }            
            
            $strSQL .= "ORDER BY UNI_Descricao";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar($obj){
            $strSQL = "INSERT INTO ADM_UNI_UNIDADES (";
                $strSQL .= "UNI_Descricao, ";                
                $strSQL .= "UNI_Telefone, ";                
                $strSQL .= "UNI_Fax, ";                
                $strSQL .= "UNI_EnderecoCep, ";                
                $strSQL .= "UNI_EnderecoLogradouro, ";                
                $strSQL .= "UNI_EnderecoNumero, ";                
                $strSQL .= "UNI_EnderecoComplemento, ";                
                $strSQL .= "UNI_EnderecoBairro, ";                
                $strSQL .= "UNI_EnderecoCidade, ";                
                $strSQL .= "UNI_EnderecoUf, ";                
                $strSQL .= "UNI_EnderecoPontoReferencia, ";  
                $strSQL .= "UNI_Observacao, ";
                $strSQL .= "UNI_Responsavel, ";
                $strSQL .= "UNI_Status ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";            
            $strSQL .= "'".$obj->getTelefone()."', ";            
            $strSQL .= "'".$obj->getFax()."', ";
            $strSQL .= "'".$obj->getEndereco()->getCep()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getLogradouro()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getNumero()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getComplemento()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getBairro()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getCidade()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getUf()."', ";            
            $strSQL .= "'".$obj->getEndereco()->getPontoReferencia()."', ";   
            $strSQL .= "'".$obj->getObservacao()."', "; 
            $strSQL .= "'".$obj->getResponsavel()."', "; 
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar($obj){
            $strSQL  = "UPDATE ADM_UNI_UNIDADES SET ";
            $strSQL .= "UNI_Descricao = '".$obj->getDescricao()."', ";
            $strSQL .= "UNI_Telefone='".$obj->getTelefone()."', ";            
            $strSQL .= "UNI_Fax='".$obj->getFax()."', ";
            $strSQL .= "UNI_EnderecoCep='".$obj->getEndereco()->getCep()."', ";            
            $strSQL .= "UNI_EnderecoLogradouro='".$obj->getEndereco()->getLogradouro()."', ";            
            $strSQL .= "UNI_EnderecoNumero='".$obj->getEndereco()->getNumero()."', ";            
            $strSQL .= "UNI_EnderecoComplemento='".$obj->getEndereco()->getComplemento()."', ";            
            $strSQL .= "UNI_EnderecoBairro='".$obj->getEndereco()->getBairro()."', ";            
            $strSQL .= "UNI_EnderecoCidade='".$obj->getEndereco()->getCidade()."', ";            
            $strSQL .= "UNI_EnderecoUf='".$obj->getEndereco()->getUf()."', ";            
            $strSQL .= "UNI_EnderecoPontoReferencia='".$obj->getEndereco()->getPontoReferencia()."', ";  
            $strSQL .= "UNI_Observacao='".$obj->getObservacao()."', ";  
            $strSQL .= "UNI_Responsavel='".$obj->getResponsavel()."', "; 
            $strSQL .= "UNI_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE UNI_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL  = "DELETE FROM ADM_UNI_UNIDADES ";            
            $strSQL .= "WHERE UNI_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
    }
?>