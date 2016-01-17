<?php
    // codificação utf-8
    class RepoDadosEclesiasticos{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoDadosEclesiasticos();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_DAM_DADOS_ECLESIASTICOS_MEMBROS "; 
            $strSQL .= "WHERE DAM_ID IS NOT NULL ";
            if(!empty($arrStrFiltros["DAM_ID"])){
                $strSQL .= "AND DAM_ID = ".trim($arrStrFiltros["DAM_ID"])." ";
            }
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }            
            if(!empty($arrStrFiltros["DAM_Tipo"])){
                $strSQL .= "AND DAM_Tipo = '".trim($arrStrFiltros["DAM_Tipo"])."' ";
            }            
            $strSQL .= "ORDER BY DAM_ID DESC";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(DadosEclesiasticos $obj){
            
            $data = "(NULL)";
            $dataAceito = "(NULL)";
            
            if($obj->getData() != ""){
                $data = "'".$obj->getData()."'";
            }
            
            if($obj->getDataAceito() != ""){
                $dataAceito = "'".$obj->getDataAceito()."'";
            }
            
            $strSQL = "INSERT INTO ADM_DAM_DADOS_ECLESIASTICOS_MEMBROS (";
                $strSQL .= "PES_ID, ";
                $strSQL .= "DAM_Data, ";
                $strSQL .= "DAM_DataAceito, ";
                $strSQL .= "DAM_IgrejaNome, ";
                $strSQL .= "DAM_IgrejaCidade, ";
                $strSQL .= "DAM_IgrejaUf, ";
                $strSQL .= "DAM_IgrejaPastor, ";
                $strSQL .= "DAM_Ano, ";
                $strSQL .= "DAM_Tipo, ";
                $strSQL .= "DAM_NumeroAta ";                
            $strSQL .= ")VALUES(";
            $strSQL .= " ".$obj->getMembro()->getId().", ";            
            $strSQL .= " ".$data.", ";            
            $strSQL .= " ".$dataAceito.", ";            
            $strSQL .= "'".$obj->getIgrejaNome()."', ";            
            $strSQL .= "'".$obj->getIgrejaCidade()."', ";            
            $strSQL .= "'".$obj->getIgrejaUf()."', ";            
            $strSQL .= "'".$obj->getIgrejaPastor()."', ";            
            $strSQL .= "'".$obj->getAno()."', ";            
            $strSQL .= "'".$obj->getTipo()."', ";            
            $strSQL .= "'".$obj->getNumeroAta()."' ";
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(DadosEclesiasticos $obj){
            $strSQL = "DELETE FROM ADM_DAM_DADOS_ECLESIASTICOS_MEMBROS WHERE PES_ID=".$obj->getMembro()->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>