<?php
    // codificação utf-8
    class RepoAreaMinisterial{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoAreaMinisterial();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = " * ";
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(*) AS Total ";
            }
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM ADM_AMI_AREAS_MINISTERIAIS ";            
            $strSQL .= "WHERE AMI_ID IS NOT NULL ";

            if(isset($arrStrFiltros["AMI_ID"])){
                $strSQL .= " AND AMI_ID = ".trim($arrStrFiltros["AMI_ID"])." ";
            }
            /*if(isset($arrStrFiltros["AAT_IDDiferente"])){
                $strSQL .= " AND AAT_ID <> ".trim($arrStrFiltros["AAT_IDDiferente"])." ";
            }*/
            if(isset($arrStrFiltros["AMI_Descricao"])){
                $strSQL .= "AND AMI_Descricao LIKE '%".trim($arrStrFiltros["AMI_Descricao"])."%' ";
            }
            /*if(isset($arrStrFiltros["AAT_DescricaoExiste"])){
                $strSQL .= "AND AAT_Descricao = '".trim($arrStrFiltros["AAT_DescricaoExiste"])."' ";
            }*/
            if(isset($arrStrFiltros["AMI_Status"])){
                $strSQL .= " AND AMI_Status = '".$arrStrFiltros["AMI_Status"]."' ";
            }
            $strSQL .= " ORDER BY AMI_Descricao ASC ";            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(AreaMinisterial $obj){            
            $strSQL = "INSERT INTO ADM_AMI_AREAS_MINISTERIAIS (AMI_Descricao, AMI_Status) ";
            $strSQL.= "VALUES('".$obj->getDescricao()."','".$obj->getStatus()."')";            
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(AreaMinisterial $obj){
            $strSQL = "UPDATE ADM_AMI_AREAS_MINISTERIAIS SET ";
            $strSQL.= "AMI_Descricao = '".$obj->getDescricao()."', AMI_Status = '".$obj->getStatus()."' ";
            $strSQL.= "WHERE AMI_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(AreaMinisterial $obj){
            $strSQL = "DELETE FROM ADM_AMI_AREAS_MINISTERIAIS WHERE AMI_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>