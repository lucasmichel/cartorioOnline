<?php
    // codificação utf-8
    class RepoTipoCarta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoTipoCarta();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_TCA_TIPOS_CARTAS "; 
            $strSQL .= "WHERE TCA_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["TCA_ID"])){
                $strSQL .= "AND TCA_ID = ".trim($arrStrFiltros["TCA_ID"])." ";
            }

            if(!empty($arrStrFiltros["TCA_Descricao"])){
                $strSQL .= "AND TCA_Descricao LIKE  '%".trim($arrStrFiltros["TCA_Descricao"])."%' ";
            }            
            
            if(!empty($arrStrFiltros["TCA_Texto"])){
                $strSQL .= "AND TCA_Texto LIKE  '%".trim($arrStrFiltros["TCA_Texto"])."%' ";
            }            
            
            if(!empty($arrStrFiltros["TCA_Status"])){
                $strSQL .= "AND TCA_Status = '".$arrStrFiltros["TCA_Status"]."' ";
            }            
            
            $strSQL .= "ORDER BY TCA_ID DESC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(TipoCarta $obj){
            $strSQL = "INSERT INTO ADM_TCA_TIPOS_CARTAS (";
                $strSQL .= "TCA_Descricao, ";                
                $strSQL .= "TCA_Texto, ";                
                $strSQL .= "TCA_Status ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";            
            $strSQL .= "'".$obj->getTexto()."', ";            
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(TipoCarta $obj){
            $strSQL  = "UPDATE ADM_TCA_TIPOS_CARTAS SET ";
            $strSQL .= "TCA_Descricao = '".$obj->getDescricao()."', ";            
            $strSQL .= "TCA_Texto = '".$obj->getTexto()."', ";            
            $strSQL .= "TCA_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE TCA_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(TipoCarta $obj){
            $strSQL  = "DELETE FROM ADM_TCA_TIPOS_CARTAS ";            
            $strSQL .= "WHERE TCA_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
    }
?>