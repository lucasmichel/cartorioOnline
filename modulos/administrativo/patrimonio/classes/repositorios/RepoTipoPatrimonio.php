<?php
    // codificação utf-8
    class RepoTipoPatrimonio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoTipoPatrimonio();
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
            $strSQL .= $strColunasConsultadas." FROM PAT_TIP_TIPOS_PATRIMONIOS ";
            $strSQL .= "WHERE TIP_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["TIP_ID"])){
                $strSQL .= "AND TIP_ID = ".$arrStrFiltros["TIP_ID"]." ";
            }
            
             if(!empty($arrStrFiltros["TIP_Descricao"])){
                $strSQL .= "AND TIP_Descricao LIKE  '%".trim($arrStrFiltros["TIP_Descricao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["TIP_DescricaoExistente"])){
                $strSQL .= "AND TIP_Descricao = '".$arrStrFiltros["TIP_DescricaoExistente"]."' ";
            }

            if(!empty($arrStrFiltros["TIP_Status"])){
                $strSQL .= "AND TIP_Status = '".$arrStrFiltros["TIP_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY TIP_Descricao ";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            //if(!empty($arrStrFiltros["TIP_ID"])) echo $strSQL;            
            return Db::getInstance()->select($strSQL);
        }

        public function salvar($objTipoPatrimonio){
            $strSQL = "INSERT INTO PAT_TIP_TIPOS_PATRIMONIOS (TIP_Descricao, TIP_Status) ";
            $strSQL.= "VALUES('".$objTipoPatrimonio->getDescricao()."', '".$objTipoPatrimonio->getStatus()."')";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar($objTipoPatrimonio){
            $strSQL = "UPDATE PAT_TIP_TIPOS_PATRIMONIOS SET TIP_Descricao = '".$objTipoPatrimonio->getDescricao()."', TIP_Status = '".$objTipoPatrimonio->getStatus()."' ";
            $strSQL.= "WHERE TIP_ID = ".$objTipoPatrimonio->getId();
            //echo $strSQL;
            return Db::getInstance()->executar($strSQL); 
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM PAT_TIP_TIPOS_PATRIMONIOS WHERE TIP_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>