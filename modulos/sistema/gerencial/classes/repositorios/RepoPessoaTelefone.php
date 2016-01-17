<?php
    // codificação utf-8
    class RepoPessoaTelefone{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoPessoaTelefone();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_TEL_TELEFONES "; 
            $strSQL .= "WHERE TEL_ID IS NOT NULL ";
            if(!empty($arrStrFiltros["TEL_ID"])){
                $strSQL .= "AND TEL_ID = ".trim($arrStrFiltros["TEL_ID"])." ";
            }            
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }
            if(!empty($arrStrFiltros["TEL_Numero"])){
                $strSQL .= "AND TEL_Numero LIKE  '%".trim($arrStrFiltros["TEL_Numero"])."%' ";
            }
            if(!empty($arrStrFiltros["TEL_Operadora"])){
                $strSQL .= "AND TEL_Operadora LIKE  '%".trim($arrStrFiltros["TEL_Operadora"])."%' ";
            }
            if(!empty($arrStrFiltros["TEL_NomeContato"])){
                $strSQL .= "AND TEL_NomeContato LIKE  '%".trim($arrStrFiltros["TEL_NomeContato"])."%' ";
            }
            $strSQL .= "ORDER BY TEL_ID DESC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(PessoaTelefone $obj){
            $strSQL = "INSERT INTO CAD_TEL_TELEFONES (";
                $strSQL .= "PES_ID, ";                
                $strSQL .= "TEL_Numero, ";
                $strSQL .= "TEL_Operadora, ";
                $strSQL .= "TEL_NomeContato ";
            $strSQL .= ")VALUES(";
            $strSQL .= " ".$obj->getPessoa()->getId().", ";            
            $strSQL .= "'".$obj->getNumero()."',";
            $strSQL .= "'".$obj->getOperadora()."',";
            $strSQL .= "'".$obj->getContato()."'";
            $strSQL .= ")";
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(PessoaTelefone $obj){
            $strSQL  = "DELETE FROM CAD_TEL_TELEFONES ";            
            $strSQL .= "WHERE PES_ID = ".$obj->getPessoa()->getId()." ";            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>