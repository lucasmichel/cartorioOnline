<?php
    // codificação utf-8
    class RepoPlanoConta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoPlanoConta();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $strColunasConsultadas = "*";
            
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_PLA_PLANOS_CONTAS ";
            $strSQL .= "WHERE PLA_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["PLA_ID"])){
                $strSQL .= "AND PLA_ID = ".$arrStrFiltros["PLA_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["PLA_Descricao"])){
                $strSQL .= "AND PLA_Descricao LIKE '%".$arrStrFiltros["PLA_Descricao"]."%' ";
            }
            
            if(isset($arrStrFiltros["PLA_CodigoContabil_EDICAO"])){
                $strSQL .= "AND PLA_CodigoContabil = '".$arrStrFiltros["PLA_CodigoContabil_EDICAO"]."' ";
                $strSQL .= "AND PLA_ID <> ".$arrStrFiltros["PLA_ID_EDICAO"]." ";
            }
            
            if(isset($arrStrFiltros["PLA_CodigoContabil"])){
                $strSQL .= "AND PLA_CodigoContabil = '".$arrStrFiltros["PLA_CodigoContabil"]."' ";
            }
            
            if(!empty($arrStrFiltros["PLA_Movimentacao"])){
                $strSQL .= "AND PLA_Movimentacao = '".$arrStrFiltros["PLA_Movimentacao"]."' ";
            }
            
            if(!empty($arrStrFiltros["PLA_Tipo"])){
                $strSQL .= "AND PLA_Tipo = '".$arrStrFiltros["PLA_Tipo"]."' ";
            }
            
            if(!empty($arrStrFiltros["PLA_Status"])){
                $strSQL .= "AND PLA_Status = '".$arrStrFiltros["PLA_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY PLA_CodigoContabil ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(PlanoConta $obj){
            $strPai = "(NULL)";
            
            if($obj->getPai() != ""){
                $strPai = $obj->getPai();
            }
            
            $strSQL  = "INSERT INTO FIN_PLA_PLANOS_CONTAS(";                         
                $strSQL .= "PLA_Descricao, ";
                $strSQL .= "PLA_CodigoContabil, "; 
                $strSQL .= "PLA_Movimentacao, ";
                $strSQL .= "PLA_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID, ";
                $strSQL .= "PLA_Tipo, ";
                $strSQL .= "PLA_Status,";
                $strSQL .= "PLA_CodigoContabilPai";
            $strSQL .= ")VALUES(";                
                $strSQL .= "'".$obj->getDescricao()."', ";
                $strSQL .= "'".$obj->getCodigoContabil()."', ";  
                $strSQL .= "'".$obj->getMovimento()."', ";  
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";  
                $strSQL .= $_SESSION["USUARIO_ID"].", ";
                $strSQL .= "'".$obj->getTipo()."', ";
                $strSQL .= "'".$obj->getStatus()."', ";
                $strSQL .= "'".$strPai."' ";
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(PlanoConta $obj){
            $strPai = "(NULL)";
            
            if($obj->getPai() != ""){
                $strPai = $obj->getPai();
            }
            
            $strSQL  = "UPDATE FIN_PLA_PLANOS_CONTAS SET ";
            $strSQL .= "PLA_Descricao = '".$obj->getDescricao()."', ";
            $strSQL .= "PLA_CodigoContabil = '".$obj->getCodigoContabil()."', ";
            $strSQL .= "PLA_Movimentacao = '".$obj->getMovimento()."', ";
            $strSQL .= "PLA_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
            $strSQL .= "USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"].", ";
            $strSQL .= "PLA_Tipo = '".$obj->getTipo()."', ";
            $strSQL .= "PLA_Status = '".$obj->getStatus()."', ";
            $strSQL .= "PLA_CodigoContabilPai = '".$strPai."' ";
            $strSQL .= "WHERE PLA_ID = ".$obj->getId();
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(PlanoConta $obj){
            $strSQL = "DELETE FROM FIN_PLA_PLANOS_CONTAS WHERE PLA_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>