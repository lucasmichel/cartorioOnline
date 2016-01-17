<?php
    // codificação utf-8
    class RepoAreaAtuacao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoAreaAtuacao();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = " * ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(*) AS Total ";
            }
            
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM CAD_AAT_AREAS_ATUACAO ";            
            $strSQL .= "WHERE AAT_ID IS NOT NULL ";

            if(isset($arrStrFiltros["AAT_ID"])){
                $strSQL .= " AND AAT_ID = ".trim($arrStrFiltros["AAT_ID"])." ";
            }

            if(isset($arrStrFiltros["AAT_IDDiferente"])){
                $strSQL .= " AND AAT_ID <> ".trim($arrStrFiltros["AAT_IDDiferente"])." ";
            }

            if(isset($arrStrFiltros["AAT_Descricao"])){
                $strSQL .= "AND AAT_Descricao LIKE '%".trim($arrStrFiltros["AAT_Descricao"])."%' ";
            }
            
            if(isset($arrStrFiltros["AAT_DescricaoExiste"])){
                $strSQL .= "AND AAT_Descricao = '".trim($arrStrFiltros["AAT_DescricaoExiste"])."' ";
            }

            if(isset($arrStrFiltros["AAT_Status"])){
                $strSQL .= " AND AAT_Status = '".$arrStrFiltros["AAT_Status"]."' ";
            }

            $strSQL .= " ORDER BY AAT_Descricao ASC ";
            //echo $strSQL;
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            //echo $strSQL;
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(AreaAtuacao $obj){            
            $strSQL = "INSERT INTO CAD_AAT_AREAS_ATUACAO (AAT_Descricao, AAT_Status) ";
            $strSQL.= "VALUES('".$obj->getDescricao()."','".$obj->getStatus()."')";            
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(AreaAtuacao $obj){
            $strSQL = "UPDATE CAD_AAT_AREAS_ATUACAO SET ";
            $strSQL.= "AAT_Descricao = '".$obj->getDescricao()."', AAT_Status = '".$obj->getStatus()."' ";
            $strSQL.= "WHERE AAT_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM CAD_AAT_AREAS_ATUACAO WHERE AAT_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>