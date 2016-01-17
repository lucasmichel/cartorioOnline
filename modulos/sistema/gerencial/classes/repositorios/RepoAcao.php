<?php
    // codificação utf-8
    class RepoAcao{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){            
            if(self::$objInstance == null){
                self::$objInstance = new RepoAcao();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(ACO_ID) AS Total ";
            }
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_ACO_ACOES ";
            $strSQL .= "WHERE ACO_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["ACO_IDDiferente"])){
                $strSQL .= "AND ACO_ID <> ".trim($arrStrFiltros["ACO_IDDiferente"])." ";
            }

            if(!empty($arrStrFiltros["ACO_DescricaoExiste"])){
                $strSQL .= "AND ACO_Descricao = '".$arrStrFiltros["ACO_DescricaoExiste"]."' ";
            }

            if(!empty($arrStrFiltros["ACO_ID"])){
                $strSQL .= "AND ACO_ID = ".trim($arrStrFiltros["ACO_ID"])." ";
            }
            
            // quando precisar consultar as ações de um formulário            
            if(!empty($arrStrFiltros["FRM_ID"])){
                $strSQL .= "AND ACO_ID IN (SELECT ACO_ID FROM CAD_FAC_FORMULARIOS_ACOES ";
                $strSQL .= "WHERE FRM_ID = ".trim($arrStrFiltros["FRM_ID"]).") ";
            }

            if(!empty($arrStrFiltros["ACO_Descricao"])){
                $strSQL .= "AND ACO_Descricao LIKE '%".trim($arrStrFiltros["ACO_Descricao"])."%' ";
            }

            if(!empty($arrStrFiltros["ACO_Status"])){
                $strSQL .= "AND ACO_Status = '".$arrStrFiltros["ACO_Status"]."' ";
            }
            $strSQL .= " ORDER BY ACO_Descricao";
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function consultarAcoesPermitidas($arrStrFiltros){
            $strSQL  = "SELECT ACO_ID FROM ";            
            if($arrStrFiltros["PER_Tipo"] == "G"){ // permissão por grupo                
                $strSQL .= "CAD_GPE_GRUPOS_PERMISSOES WHERE GRU_ID = ".$arrStrFiltros["GRU_ID"]." ";
            }else{
                $strSQL .= "CAD_UPE_USUARIOS_PERMISSOES WHERE USU_ID = ".$arrStrFiltros["USU_ID"]." ";
            }
            $strSQL .= "AND FRM_ID = ".$arrStrFiltros["FRM_ID"]." "; 
            return Db::getInstance()->select($strSQL);
        }
    }
?>