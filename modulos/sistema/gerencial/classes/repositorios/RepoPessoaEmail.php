<?php
    // codificação utf-8
    class RepoPessoaEmail{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoPessoaEmail();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_EMA_EMAILS "; 
            $strSQL .= "WHERE EMA_ID IS NOT NULL ";
            if(!empty($arrStrFiltros["EMA_ID"])){
                $strSQL .= "AND EMA_ID = ".trim($arrStrFiltros["EMA_ID"])." ";
            }
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
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
        
        public function salvar(PessoaEmail $obj){
            $strSQL = "INSERT INTO CAD_EMA_EMAILS (";
                $strSQL .= "PES_ID, ";                
                $strSQL .= "EMA_Email ";
            $strSQL .= ")VALUES(";
            $strSQL .= " ".$obj->getPessoa()->getId().", ";            
            $strSQL .= "'".$obj->getEmail()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(PessoaEmail $obj){
            $strSQL  = "DELETE FROM CAD_EMA_EMAILS ";            
            $strSQL .= "WHERE PES_ID = ".$obj->getPessoa()->getId()." ";            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>