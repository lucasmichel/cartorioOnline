<?php
    // codificação utf-8
    class RepoItemPatrimonio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoItemPatrimonio();
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
            $strSQL .= $strColunasConsultadas." FROM PAT_IPT_ITENS_PATRIMONIAIS AS I ";
            $strSQL .= "INNER JOIN PAT_TIP_TIPOS_PATRIMONIOS AS T ON (T.TIP_ID = I.TIP_ID) ";
            $strSQL .= "WHERE IPT_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["IPT_ID"])){
                $strSQL .= "AND IPT_ID = ".$arrStrFiltros["IPT_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["IPT_Descricao"])){
                $strSQL .= "AND IPT_Descricao LIKE  '%".trim($arrStrFiltros["IPT_Descricao"])."%' ";                
            }

            if(!empty($arrStrFiltros["IPT_Status"])){
                $strSQL .= "AND IPT_Status = '".$arrStrFiltros["IPT_Status"]."' ";
            }
            
            if(!empty($arrStrFiltros["TIP_ID"])){
                $strSQL .= "AND I.TIP_ID = ".$arrStrFiltros["TIP_ID"]." ";
            }
            
            $strSQL .= "ORDER BY IPT_Descricao ";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            /*var_dump($arrStrFiltros);
            echo $strSQL;
            die();*/
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(ItemPatrimonio $obj){
            $strSQL = "INSERT INTO PAT_IPT_ITENS_PATRIMONIAIS (IPT_Descricao, IPT_Status, TIP_ID, IPT_PercentualDepreciacao) ";
            $strSQL.= "VALUES('".$obj->getDescricao()."', '".$obj->getStatus()."', ".$obj->getTipoPatrimonio()->getId().", ".$obj->getPercentualDepreciacao().")";
            
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(ItemPatrimonio $obj){
            $strSQL = "UPDATE PAT_IPT_ITENS_PATRIMONIAIS SET IPT_Descricao = '".$obj->getDescricao()."', IPT_Status = '".$obj->getStatus()."', TIP_ID = ".$obj->getTipoPatrimonio()->getId().", IPT_PercentualDepreciacao= ".$obj->getPercentualDepreciacao()." ";
            $strSQL.= "WHERE IPT_ID = ".$obj->getId();
            
            return Db::getInstance()->executar($strSQL); 
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM PAT_IPT_ITENS_PATRIMONIAIS WHERE IPT_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>