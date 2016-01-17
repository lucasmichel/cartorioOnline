<?php
    // codificação utf-8
    class RepoEstadoCivil{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoEstadoCivil();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = " * ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(*) AS Total ";
            }
            
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM CAD_ECV_ESTADOS_CIVIS ";            
            $strSQL .= "WHERE ECV_ID IS NOT NULL ";

            if(isset($arrStrFiltros["ECV_ID"])){
                $strSQL .= " AND ECV_ID = ".trim($arrStrFiltros["ECV_ID"])." ";
            }

            if(isset($arrStrFiltros["ECV_IDDiferente"])){
                $strSQL .= " AND ECV_ID <> ".trim($arrStrFiltros["ECV_IDDiferente"])." ";
            }

            if(isset($arrStrFiltros["ECV_Descricao"])){
                $strSQL .= "AND ECV_Descricao LIKE '%".trim($arrStrFiltros["ECV_Descricao"])."%' ";
            }
            
            if(isset($arrStrFiltros["ECV_DescricaoExiste"])){
                $strSQL .= "AND ECV_Descricao = '".trim($arrStrFiltros["ECV_DescricaoExiste"])."' ";
            }

            if(isset($arrStrFiltros["ECV_Status"])){
                $strSQL .= " AND ECV_Status = '".$arrStrFiltros["ECV_Status"]."' ";
            }

            $strSQL .= " ORDER BY ECV_Descricao ASC ";
            //echo $strSQL;
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar($obj){            
            $strSQL = "INSERT INTO CAD_ECV_ESTADOS_CIVIS (ECV_Descricao, ECV_ExigeConjuge, ECV_Status) ";
            $strSQL.= "VALUES('".$obj->getDescricao()."', '".$obj->getExigeConjuge()."', '".$obj->getStatus()."')";            
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar($obj){
            $strSQL = "UPDATE CAD_ECV_ESTADOS_CIVIS SET ";
            $strSQL.= "ECV_Descricao = '".$obj->getDescricao()."', ECV_ExigeConjuge = '".$obj->getExigeConjuge()."', ECV_Status = '".$obj->getStatus()."' ";
            $strSQL.= "WHERE ECV_ID = ".$obj->getId()." ";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM CAD_ECV_ESTADOS_CIVIS WHERE ECV_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>