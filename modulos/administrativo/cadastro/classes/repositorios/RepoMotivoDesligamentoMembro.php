<?php
    // codificação utf-8
    class RepoMotivoDesligamentoMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoMotivoDesligamentoMembro();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = " * ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_PCD_PROCESSOS_DESLIGAMENTO AS PROCESSO "; 
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID = PROCESSO.PES_ID ) ";            
            $strSQL .= "WHERE PROCESSO.PCD_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["PCD_ID"])){
                $strSQL .= "AND PROCESSO.PCD_ID = ".trim($arrStrFiltros["PCD_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND PROCESSO.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }

            if(!empty($arrStrFiltros["PCD_Descricao"])){
                $strSQL .= "AND PROCESSO.PCD_Descricao LIKE  '%".trim($arrStrFiltros["PCD_Descricao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["PCD_Data"])){
                $strSQL .= "AND PROCESSO.PCD_Data = '".$arrStrFiltros["PCD_Data"]."' ";
            }  
            
            $strSQL .= "ORDER BY PROCESSO.PCD_Data DESC";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            } 
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(MotivosDesligamentoMembro $obj){            
            $data = "(NULL)";
            if($obj->getData() != null){
                $data = "'".$obj->getData()."'";
            }
            $strSQL = "INSERT INTO ADM_PCD_PROCESSOS_DESLIGAMENTO (";
                $strSQL .= "PES_ID, "; 
                $strSQL .= "PCD_Descricao, ";
                $strSQL .= "PCD_Data ";
            $strSQL .= ")VALUES(";
                $strSQL .= " ".$obj->getPessoa()->getId().", ";  
                $strSQL .= "'".$obj->getDescricao()."', ";            
            $strSQL .= " ".$data." ";
            
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(MotivosDesligamentoMembro $obj){
            $strSQL  = "DELETE FROM ADM_PCD_PROCESSOS_DESLIGAMENTO ";            
            $strSQL .= "WHERE PES_ID = ".$obj->getPessoa()->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
    }
?>