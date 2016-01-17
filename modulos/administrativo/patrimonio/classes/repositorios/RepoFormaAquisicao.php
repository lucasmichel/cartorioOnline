<?php
    // codificação utf-8
    class RepoFormaAquisicao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFormaAquisicao();
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
            
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM PAT_FRA_FORMAS_AQUISICAO ";
            $strSQL .= "WHERE FRA_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["FRA_ID"])){
                $strSQL .= "AND FRA_ID = ".$arrStrFiltros["FRA_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["FRA_DescricaoExistente"])){
                $strSQL .= "AND FRA_Descricao = '".$arrStrFiltros["FRA_DescricaoExistente"]."' ";
            }

            if(!empty($arrStrFiltros["FRA_Descricao"])){
                $strSQL .= "AND FRA_Descricao LIKE '%".$arrStrFiltros["FRA_Descricao"]."%' ";
            }
            
            if(!empty($arrStrFiltros["FRA_Status"])){
                $strSQL .= "AND FRA_Status = '".$arrStrFiltros["FRA_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY FRA_Descricao ";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            //if(!empty($arrStrFiltros["FRA_ID"])) echo $strSQL;
            return Db::getInstance()->select($strSQL);
        }

        public function salvar($objFormaAquisicao){
            $strSQL = "INSERT INTO PAT_FRA_FORMAS_AQUISICAO (FRA_Descricao, FRA_Status) ";
            $strSQL.= "VALUES('".$objFormaAquisicao->getDescricao()."', '".$objFormaAquisicao->getStatus()."')";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar($objFormaAquisicao){
            $strSQL = "UPDATE PAT_FRA_FORMAS_AQUISICAO SET FRA_Descricao = '".$objFormaAquisicao->getDescricao()."', FRA_Status = '".$objFormaAquisicao->getStatus()."' ";
            $strSQL.= "WHERE FRA_ID = ".$objFormaAquisicao->getId();
            //echo $strSQL;
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM PAT_FRA_FORMAS_AQUISICAO WHERE FRA_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>