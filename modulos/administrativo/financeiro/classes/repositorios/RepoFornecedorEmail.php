<?php
    // codificação utf-8
    class RepoFornecedorEmail{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFornecedorEmail();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_EMA_EMAIL_FORNECEDORES "; 
            $strSQL .= "WHERE EMA_ID IS NOT NULL ";
            if(!empty($arrStrFiltros["EMA_ID"])){
                $strSQL .= "AND EMA_ID = ".trim($arrStrFiltros["EMA_ID"])." ";
            }
            if(!empty($arrStrFiltros["FOR_ID"])){
                $strSQL .= "AND FOR_ID = ".trim($arrStrFiltros["FOR_ID"])." ";
            }
            if(!empty($arrStrFiltros["EMA_Email"])){
                $strSQL .= "AND EMA_Email LIKE  '%".trim($arrStrFiltros["EMA_Email"])."%' ";
            }
            $strSQL .= "ORDER BY EMA_ID DESC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(FornecedorEmail $obj){
            $strSQL = "INSERT INTO FIN_EMA_EMAIL_FORNECEDORES (";
                $strSQL .= "FOR_ID, ";                
                $strSQL .= "EMA_Email ";
            $strSQL .= ")VALUES(";
            $strSQL .= " ".$obj->getFornecedor()->getId().", ";            
            $strSQL .= "'".$obj->getEmail()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(FornecedorEmail $obj){
            $strSQL  = "DELETE FROM FIN_EMA_EMAIL_FORNECEDORES ";            
            $strSQL .= "WHERE FOR_ID = ".$obj->getFornecedor()->getId()." ";            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>