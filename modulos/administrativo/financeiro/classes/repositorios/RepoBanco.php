<?php
    // codificação utf-8
    class RepoBanco{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoBanco();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_BAN_BANCOS "; 
            $strSQL .= "WHERE BAN_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["BAN_ID"])){
                $strSQL .= "AND BAN_ID = ".trim($arrStrFiltros["BAN_ID"])." ";
            }

            if(!empty($arrStrFiltros["BAN_Descricao"])){
                $strSQL .= "AND BAN_Descricao LIKE  '%".trim($arrStrFiltros["BAN_Descricao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["BAN_Status"])){
                $strSQL .= "AND BAN_Status = '".$arrStrFiltros["BAN_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY BAN_Descricao";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Banco $obj){
            $strSQL = "INSERT INTO FIN_BAN_BANCOS (";
                $strSQL .= "BAN_Descricao, ";
                $strSQL .= "BAN_Codigo, ";
                $strSQL .= "BAN_Status, ";
                $strSQL .= "BAN_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";
            $strSQL .= "'".$obj->getCodigo()."', ";
                $strSQL .= "'".$obj->getStatus()."', ";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";
                $strSQL .= $_SESSION["USUARIO_ID"];
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(Banco $obj){
            $strSQL  = "UPDATE FIN_BAN_BANCOS SET ";
            $strSQL .= "BAN_Descricao = '".$obj->getDescricao()."', ";
            $strSQL .= "BAN_Codigo = '".$obj->getCodigo()."', ";
            $strSQL .= "BAN_Status = '".$obj->getStatus()."', ";
            $strSQL .= "BAN_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
            $strSQL .= "USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"]." ";
            $strSQL .= "WHERE BAN_ID = ".$obj->getId(); 
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM FIN_BAN_BANCOS WHERE BAN_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>