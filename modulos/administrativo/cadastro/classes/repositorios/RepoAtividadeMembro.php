<?php
    // codificação utf-8
    class RepoAtividadeMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoAtividadeMembro();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_ATM_ATIVIDADES_MEMBROS AS ATIVIDADE_MEMBRO ";             
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID = ATIVIDADE_MEMBRO.PES_ID)";
            $strSQL .= "INNER JOIN  CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = MEMBRO.PES_ID) ";            
            $strSQL .= "INNER JOIN  ADM_ATV_ATIVIDADES AS ATIVIDADE ON (ATIVIDADE.ATV_ID = ATIVIDADE_MEMBRO.ATV_ID) ";            
            $strSQL .= "WHERE ATIVIDADE_MEMBRO.PES_ID IS NOT NULL ";            
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND ATIVIDADE_MEMBRO.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }            
            if(!empty($arrStrFiltros["ATV_ID"])){
                $strSQL .= "AND ATIVIDADE_MEMBRO.ATV_ID = ".trim($arrStrFiltros["ATV_ID"])." ";
            }            
            $strSQL .= "ORDER BY ATIVIDADE_MEMBRO.ATV_ID DESC";            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }     
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(AtividadeMembro $obj){            
            $strDesde = "(NULL)";
            $strAte = "(NULL)";
            if($obj->getDataDesde() != null){
                $strDesde = "'".$obj->getDataDesde()."'";
            }            
            if($obj->getDataAte() != null){
                $strAte = "'".$obj->getDataAte()."'";
            }            
            $strSQL = "INSERT INTO ADM_ATM_ATIVIDADES_MEMBROS (";
                $strSQL .= "PES_ID, ";                
                $strSQL .= "ATV_ID, ";                
                $strSQL .= " ATM_Desde, ";
                $strSQL .= " ATM_Ate ";
                
            $strSQL .= ")VALUES(";
            $strSQL .= " ".$obj->getMembro()->getId().", ";            
            $strSQL .= " ".$obj->getAtividade()->getId().", ";            
            $strSQL .= " ".$strDesde.", ";            
            $strSQL .= " ".$strAte." ";            
            $strSQL .= ")";      
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(AtividadeMembro $obj){
            $strSQL  = "DELETE FROM ADM_ATM_ATIVIDADES_MEMBROS WHERE ";
            $strSQL .= "PES_ID = ".$obj->getMembro()->getId()." ";            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>