<?php
    // codificação utf-8
    class RepoDiaSemana{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoDiaSemana();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_DIA_DIAS_SEMANA "; 
            $strSQL .= "WHERE DIA_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["DIA_ID"])){
                $strSQL .= "AND DIA_ID = ".trim($arrStrFiltros["DIA_ID"])." ";
            }

            if(!empty($arrStrFiltros["DIA_Descricao"])){
                $strSQL .= "AND DIA_Descricao LIKE  '%".trim($arrStrFiltros["DIA_Descricao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["DIA_Status"])){
                $strSQL .= "AND DIA_Status = '".$arrStrFiltros["DIA_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY DIA_ID";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
    }
?>