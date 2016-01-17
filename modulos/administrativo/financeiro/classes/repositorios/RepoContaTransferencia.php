<?php
    // codificação utf-8
    class RepoContaTransferencia{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoContaTransferencia();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_TRC_TRANSFERENCIAS_CONTAS AS TRANSFERENCIA ";             
            $strSQL .= "INNER JOIN FIN_COB_CONTAS_BANCARIAS AS CONTA_DE ON (CONTA_DE.COB_ID = TRANSFERENCIA.COB_De_ID) ";            
            $strSQL .= "INNER JOIN FIN_COB_CONTAS_BANCARIAS AS CONTA_PARA ON (CONTA_PARA.COB_ID = TRANSFERENCIA.COB_Para_ID) ";
            $strSQL .= "INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON (USUARIO_CADASTRO.USU_ID = TRANSFERENCIA.USU_Cadastro_ID) ";
            
            $strSQL .= "WHERE TRANSFERENCIA.TRC_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["TRC_ID"])){
                $strSQL .= "AND TRANSFERENCIA.TRC_ID = ".trim($arrStrFiltros["TRC_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["COB_De_ID"])){
                $strSQL .= "AND TRANSFERENCIA.COB_De_ID = ".$arrStrFiltros["COB_De_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["COB_Para_ID"])){
                $strSQL .= "AND TRANSFERENCIA.COB_Para_ID = ".$arrStrFiltros["COB_Para_ID"]." ";
            }
            
            if(isset($arrStrFiltros["TRC_DataTransferenciaInicial"]) && isset($arrStrFiltros["TRC_DataTransferenciaFinal"])){
                $strSQL .="AND TRANSFERENCIA.TRC_DataTransferencia BETWEEN '".$arrStrFiltros["TRC_DataTransferenciaInicial"]." ' AND '".$arrStrFiltros["TRC_DataTransferenciaFinal"]." ' ";
            }
            
            $strSQL .= "ORDER BY TRANSFERENCIA.TRC_DataTransferencia DESC ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            } 
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(ContaTransferencia $obj){
            $strSQL = "INSERT INTO FIN_TRC_TRANSFERENCIAS_CONTAS (";
                $strSQL .= "TRC_DataHoraCadastro, ";
                $strSQL .= "TRC_DataTransferencia, ";
                $strSQL .= "TRC_Valor, ";
                $strSQL .= "COB_De_ID,";
                $strSQL .= "COB_Para_ID, ";
                $strSQL .= "USU_Cadastro_ID ";                               
            $strSQL .= ")VALUES(";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";
                $strSQL .= "'".$obj->getDataTransferencia()."', ";
                $strSQL .= " ".$obj->getValor().", ";
                $strSQL .= " ".$obj->getContaTransferenciaDe()->getId().", ";
                $strSQL .= " ".$obj->getContaTransferenciaPara()->getId().", ";                
                $strSQL .= "".$_SESSION["USUARIO_ID"]." ";                
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(ContaTransferencia $obj){
            $strSQL  = "DELETE FROM FIN_TRC_TRANSFERENCIAS_CONTAS ";            
            $strSQL .= "WHERE TRC_ID = ".$obj->getId();            
            return Db::getInstance()->executar($strSQL);
        }
        
    }
?>