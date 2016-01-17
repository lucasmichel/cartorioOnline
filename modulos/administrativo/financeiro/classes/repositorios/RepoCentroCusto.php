<?php
    // codificação utf-8
    class RepoCentroCusto{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoCentroCusto();
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
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_CEN_CENTROS_CUSTO ";
            $strSQL .= "WHERE CEN_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["CEN_ID"])){
                $strSQL .= "AND CEN_ID = ".$arrStrFiltros["CEN_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["CEN_Descricao"])){
                $strSQL .= "AND CEN_Descricao LIKE '%".$arrStrFiltros["CEN_Descricao"]."%' ";
            }
            
            if(!empty($arrStrFiltros["CEN_Status"])){
                $strSQL .= "AND CEN_Status = '".$arrStrFiltros["CEN_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY CEN_Descricao ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(CentroCusto $obj){
            $strSQL  = "INSERT INTO FIN_CEN_CENTROS_CUSTO(";
                $strSQL .= "CEN_Descricao, ";
                $strSQL .= "CEN_Observacao, ";
                $strSQL .= "CEN_Status, ";
                $strSQL .= "CEN_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID ";
            $strSQL .= ")VALUES(";
                $strSQL .= "'".$obj->getDescricao()."', ";
                $strSQL .= "'".$obj->getObservacao()."', ";
                $strSQL .= "'".$obj->getStatus()."', ";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";
                $strSQL .= $_SESSION["USUARIO_ID"];
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(CentroCusto $obj){
            $strSQL  = "UPDATE FIN_CEN_CENTROS_CUSTO SET ";
            $strSQL .= "CEN_Descricao='".$obj->getDescricao()."', ";
            $strSQL .= "CEN_Observacao='".$obj->getObservacao()."', ";
            $strSQL .= "CEN_Status='".$obj->getStatus()."', ";
            $strSQL .= "CEN_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
            $strSQL .= "USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"]." ";
            $strSQL .= "WHERE CEN_ID=".$obj->getId();
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM FIN_CEN_CENTROS_CUSTO WHERE CEN_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>