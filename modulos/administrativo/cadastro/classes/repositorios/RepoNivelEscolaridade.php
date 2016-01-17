<?php
    // codificação utf-8
    class RepoNivelEscolaridade{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoNivelEscolaridade();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = " * ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(*) AS Total ";
            }
            
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM CAD_NES_NIVEIS_ESCOLARIDADE ";            
            $strSQL .= "WHERE NES_ID IS NOT NULL ";

            if(isset($arrStrFiltros["NES_ID"])){
                $strSQL .= " AND NES_ID = ".trim($arrStrFiltros["NES_ID"])." ";
            }

            if(isset($arrStrFiltros["NES_IDDiferente"])){
                $strSQL .= " AND NES_ID <> ".trim($arrStrFiltros["NES_IDDiferente"])." ";
            }

            if(isset($arrStrFiltros["NES_Descricao"])){
                $strSQL .= "AND NES_Descricao LIKE '%".trim($arrStrFiltros["NES_Descricao"])."%' ";
            }
            
            if(isset($arrStrFiltros["NES_DescricaoExiste"])){
                $strSQL .= "AND NES_Descricao = '".trim($arrStrFiltros["NES_DescricaoExiste"])."' ";
            }

            if(isset($arrStrFiltros["NES_Status"])){
                $strSQL .= " AND NES_Status = '".$arrStrFiltros["NES_Status"]."' ";
            }

            $strSQL .= " ORDER BY NES_Descricao DESC ";
            //echo $strSQL;
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            //echo $strSQL;
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar($obj){            
            $strSQL = "INSERT INTO CAD_NES_NIVEIS_ESCOLARIDADE (NES_Descricao, NES_ExigeFormacao, NES_Status) ";
            $strSQL.= "VALUES('".$obj->getDescricao()."', '".$obj->getExigeFormacao()."', '".$obj->getStatus()."')";            
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar($obj){
            $strSQL = "UPDATE CAD_NES_NIVEIS_ESCOLARIDADE SET ";
            $strSQL.= "NES_Descricao = '".$obj->getDescricao()."', NES_ExigeFormacao = '".$obj->getExigeFormacao()."', NES_Status = '".$obj->getStatus()."' ";
            $strSQL.= "WHERE NES_ID = ".$obj->getId()." ";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM CAD_NES_NIVEIS_ESCOLARIDADE WHERE NES_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>