<?php
    // codificação utf-8
    class RepoMembroMinisterio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoMembroMinisterio();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_MMI_MEMBROS_X_MINISTERIOS AS MEMBRO_MINISTERIO ";             
            
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID = MEMBRO_MINISTERIO.PES_ID)";            
            $strSQL .= "INNER JOIN  CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = MEMBRO.PES_ID) ";         
            
            $strSQL .= "INNER JOIN  ADM_MIN_MINISTERIOS AS MINISTERIO ON (MINISTERIO.MIN_ID = MEMBRO_MINISTERIO.MIN_ID) ";              
            $strSQL .= "LEFT JOIN  ADM_AMI_AREAS_MINISTERIAIS AS AREA_MINISTRIAL ON (AREA_MINISTRIAL.AMI_ID = MINISTERIO.AMI_ID) ";  
            
            
            
            $strSQL .= "WHERE MEMBRO_MINISTERIO.PES_ID IS NOT NULL ";            
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND MEMBRO_MINISTERIO.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }            
            if(!empty($arrStrFiltros["MIN_ID"])){
                $strSQL .= "AND MEMBRO_MINISTERIO.MIN_ID = ".trim($arrStrFiltros["MIN_ID"])." ";
            }            
            $strSQL .= "ORDER BY MEMBRO_MINISTERIO.MIN_ID DESC";            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }     
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(MembroMinisterio $obj){            
            $strDesde = "(NULL)";
            $strAte = "(NULL)";
            if($obj->getDataDesde() != null){
                $strDesde = "'".$obj->getDataDesde()."'";
            }            
            if($obj->getDataAte() != null){
                $strAte = "'".$obj->getDataAte()."'";
            }            
            $strSQL = "INSERT INTO ADM_MMI_MEMBROS_X_MINISTERIOS (";
                $strSQL .= "PES_ID, ";                
                $strSQL .= "MIN_ID, ";                
                $strSQL .= " MMI_Desde, ";
                $strSQL .= " MMI_Ate ";
                
            $strSQL .= ")VALUES(";
            $strSQL .= " ".$obj->getMembro()->getId().", ";            
            $strSQL .= " ".$obj->getMinisterio()->getId().", ";            
            $strSQL .= " ".$strDesde.", ";            
            $strSQL .= " ".$strAte." ";            
            $strSQL .= ")";      
            
            
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(MembroMinisterio $obj){
            $strSQL  = "DELETE FROM ADM_MMI_MEMBROS_X_MINISTERIOS WHERE ";
            $strSQL .= "PES_ID = ".$obj->getMembro()->getId()." ";
            
            //throw new Exception($strSQL);


            return Db::getInstance()->executar($strSQL);
        }
    }
?>