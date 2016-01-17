<?php
    // codificação utf-8
    class RepoStatusMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoStatusMembro();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_MES_MEMBROS_STATUS "; 
            $strSQL .= "WHERE MES_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["MES_ID"])){
                $strSQL .= "AND MES_ID = ".trim($arrStrFiltros["MES_ID"])." ";
            }

            if(!empty($arrStrFiltros["MES_Descricao"])){
                $strSQL .= "AND MES_Descricao LIKE  '%".trim($arrStrFiltros["MES_Descricao"])."%' ";
            }            
            if(!empty($arrStrFiltros["MES_Status"])){
                $strSQL .= "AND MES_Status = '".$arrStrFiltros["MES_Status"]."' ";
            }            
            $strSQL .= "ORDER BY MES_Descricao ASC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }   
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(StatusMembro $obj){
            $strSQL = "INSERT INTO ADM_MES_MEMBROS_STATUS (";
                $strSQL .= "MES_Descricao, ";                
                $strSQL .= "MES_Status ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";            
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(StatusMembro $obj){
            $strSQL  = "UPDATE ADM_MES_MEMBROS_STATUS SET ";
            $strSQL .= "MES_Descricao = '".$obj->getDescricao()."', ";            
            $strSQL .= "MES_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE MES_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM ADM_MES_MEMBROS_STATUS WHERE MES_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>