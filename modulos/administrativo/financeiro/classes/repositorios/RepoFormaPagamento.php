<?php
    // codificação utf-8
    class RepoFormaPagamento{
        private static $objInstance;        
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFormaPagamento();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(isset($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }   
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_FPG_FORMAS_PAGAMENTOS ";
            $strSQL .= "WHERE FPG_ID IS NOT NULL ";
            
            if(isset($arrStrFiltros["FPG_ID"])){
                $strSQL .= "AND FPG_ID = ".$arrStrFiltros["FPG_ID"]." ";
            }            
            if(isset($arrStrFiltros["FPG_Descricao"])){
                $strSQL .= "AND FPG_Descricao LIKE '%".$arrStrFiltros["FPG_Descricao"]."%' ";
            }            
            if(isset($arrStrFiltros["FPG_Status"])){
                $strSQL .= "AND FPG_Status = '".$arrStrFiltros["FPG_Status"]."' ";
            }            
            $strSQL .= "ORDER BY FPG_Descricao ";            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(FormaPagamento $obj){
            $strSQL  = "INSERT INTO FIN_FPG_FORMAS_PAGAMENTOS(";
                $strSQL .= "FPG_Descricao, ";                
                $strSQL .= "FPG_Status, ";
                $strSQL .= "FPG_ExigeNumero, ";
                $strSQL .= "FPG_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID ";
            $strSQL .= ")VALUES(";
                $strSQL .= "'".$obj->getDescricao()."', ";                
                $strSQL .= "'".$obj->getStatus()."', ";
                $strSQL .= "'".$obj->getExigeNumero()."', ";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";
                $strSQL .= $_SESSION["USUARIO_ID"];
            $strSQL .= ")";  
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(FormaPagamento $obj){
            $strSQL  = "UPDATE FIN_FPG_FORMAS_PAGAMENTOS SET ";
            $strSQL .= "FPG_Descricao='".$obj->getDescricao()."', ";            
            $strSQL .= "FPG_Status='".$obj->getStatus()."', ";
            $strSQL .= "FPG_ExigeNumero='".$obj->getExigeNumero()."', ";
            $strSQL .= "FPG_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
            $strSQL .= "USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"]." ";
            $strSQL .= "WHERE FPG_ID=".$obj->getId();            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM FIN_FPG_FORMAS_PAGAMENTOS WHERE FPG_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>