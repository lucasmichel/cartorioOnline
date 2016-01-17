<?php
    // codificação utf-8
    class RepoAtividade{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoAtividade();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_ATV_ATIVIDADES "; 
            $strSQL .= "WHERE ATV_ID IS NOT NULL ";
            if(!empty($arrStrFiltros["ATV_ID"])){
                $strSQL .= "AND ATV_ID = ".trim($arrStrFiltros["ATV_ID"])." ";
            }
            if(!empty($arrStrFiltros["ATV_Descricao"])){
                $strSQL .= "AND ATV_Descricao LIKE  '%".trim($arrStrFiltros["ATV_Descricao"])."%' ";
            }            
            if(!empty($arrStrFiltros["ATV_Status"])){
                $strSQL .= "AND ATV_Status = '".$arrStrFiltros["ATV_Status"]."' ";
            }
            $strSQL .= "ORDER BY ATV_Descricao ASC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Atividade $obj){
            $strSQL = "INSERT INTO ADM_ATV_ATIVIDADES (";
                $strSQL .= "ATV_Descricao, ";                
                $strSQL .= "ATV_ExigeData, ";                
                $strSQL .= "ATV_Status ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";            
            $strSQL .= "'".$obj->getExigeData()."', ";            
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(Atividade $obj){
            $strSQL  = "UPDATE ADM_ATV_ATIVIDADES SET ";
            $strSQL .= "ATV_Descricao = '".$obj->getDescricao()."', ";            
            $strSQL .= "ATV_ExigeData = '".$obj->getExigeData()."', ";            
            $strSQL .= "ATV_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE ATV_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM ADM_ATV_ATIVIDADES WHERE ATV_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>