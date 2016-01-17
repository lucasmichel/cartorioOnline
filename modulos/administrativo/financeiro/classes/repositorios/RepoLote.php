<?php
    // codificação utf-8
    class RepoLote{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoLote();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(LOTE.LOT_ID) AS Total";
            }   
            $strSQL  = " SELECT ".$strColunasConsultadas." FROM FIN_LOT_LOTES AS LOTE ";
            $strSQL .= " WHERE LOTE.LOT_ID IS NOT NULL ";
            if(!empty($arrStrFiltros["LOT_ID"])){
                $strSQL .= " AND LOTE.LOT_ID = ".$arrStrFiltros["LOT_ID"]." ";
            }
            if(!empty($arrStrFiltros["LOT_Descricao"])){
                $strSQL .= " AND LOTE.LOT_Descricao = ".$arrStrFiltros["LOT_Descricao"]." ";
            }
            $strSQL .= " ORDER BY LOTE.LOT_ID ASC ";
            if(!empty($arrStrFiltros["limit"]) && !empty($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Lote $obj){
            $strSQL  = "INSERT INTO FIN_LOT_LOTES(";
                $strSQL .= " LOT_Descricao ";                
            $strSQL .= ")VALUES(";            
                $strSQL .= " '".$obj->getDescricao()."' ";                               
            $strSQL .= ")";
            return Db::getInstance()->executar($strSQL);            
        }
        
        public function alterar(Lote $obj){
            $strSQL  = "UPDATE FIN_LOT_LOTES SET ";
            $strSQL .= "LOT_Descricao = '".$obj->getDescricao()."' ";
            $strSQL .= "WHERE LOT_ID = ".$obj->getId(). " "; 
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(Lote $obj){
            $strSQL  = "DELETE FROM FIN_LOT_LOTES ";            
            $strSQL .= "WHERE LOT_ID = ".$obj->getId();            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>