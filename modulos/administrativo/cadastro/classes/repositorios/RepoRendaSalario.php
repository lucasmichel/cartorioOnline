<?php
    // codificação utf-8
    class RepoRendaSalario{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoRendaSalario();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_ARS_RENDAS_SALARIAIS "; 
            $strSQL .= "WHERE ARS_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["ARS_ID"])){
                $strSQL .= "AND ARS_ID = ".trim($arrStrFiltros["ARS_ID"])." ";
            }

            if(!empty($arrStrFiltros["ARS_Descricao"])){
                $strSQL .= "AND ARS_Descricao LIKE  '%".trim($arrStrFiltros["ARS_Descricao"])."%' ";
            }            
            if(!empty($arrStrFiltros["ARS_Status"])){
                $strSQL .= "AND ARS_Status = '".$arrStrFiltros["ARS_Status"]."' ";
            }            
            
            $strSQL .= "ORDER BY ARS_ID DESC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(RendaSalario $obj){
            $strSQL = "INSERT INTO ADM_ARS_RENDAS_SALARIAIS (";
                $strSQL .= "ARS_Descricao, ";                
                $strSQL .= "ARS_Status ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";            
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(RendaSalario $obj){
            $strSQL  = "UPDATE ADM_ARS_RENDAS_SALARIAIS SET ";
            $strSQL .= "ARS_Descricao = '".$obj->getDescricao()."', ";            
            $strSQL .= "ARS_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE ARS_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM ADM_ARS_RENDAS_SALARIAIS WHERE ARS_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>