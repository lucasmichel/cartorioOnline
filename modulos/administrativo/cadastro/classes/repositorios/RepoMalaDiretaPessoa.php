<?php
    // codificação utf-8
    class RepoMalaDiretaPessoa{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoMalaDiretaPessoa();
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
            
            
            
            if(!empty($arrStrFiltros["TOT_Total_Enviados"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }
            
            if(!empty($arrStrFiltros["TOT_Total_Visualizado"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }
            
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_MDP_MALAS_DIRETAS_PESSOAS AS MALA_PESSOA ";   
            
            $strSQL .= "INNER JOIN CAD_MAD_MALAS_DIRETAS AS MALA ON (MALA.MAD_ID = MALA_PESSOA.MAD_ID) "; 
            $strSQL .= "INNER JOIN CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = MALA_PESSOA.PES_ID) "; 
            
            $strSQL .= "WHERE MALA_PESSOA.MAD_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["TOT_Total_Enviados"])){
                $strSQL .= "AND MALA_PESSOA.MAD_ID = ".trim($arrStrFiltros["MAD_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["TOT_Total_Visualizado"])){
                $strSQL .= "AND MALA_PESSOA.MAD_ID = ".trim($arrStrFiltros["MAD_ID"])." AND MDP_DataHoraLeitura IS NOT NULL ";
            }
            
            
            if(!empty($arrStrFiltros["MDP_ID"])){
                $strSQL .= "AND MALA_PESSOA.MDP_ID = ".trim($arrStrFiltros["MDP_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["MAD_ID"])){
                $strSQL .= "AND MALA_PESSOA.MAD_ID = ".trim($arrStrFiltros["MAD_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND MALA_PESSOA.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }
            
            $strSQL .= "ORDER BY MALA.MAD_ID DESC";            
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(MalaDiretaPessoa $obj){
            $strSQL = "INSERT INTO CAD_MDP_MALAS_DIRETAS_PESSOAS (";
                $strSQL .= "MAD_ID, ";
                $strSQL .= "PES_ID, ";
                $strSQL .= "MDP_DataHoraEnvio ";
                
            $strSQL .= ")VALUES(";            
            $strSQL .= " ".$obj->getMalaDireta()->getId()." , ";            
            $strSQL .= " ".$obj->getPessoa()->getId()." , ";            
            
            $strSQL .= " '".$obj->getDataEnvio()."' ";            
            
            $strSQL .= ")";            
            
            if(Db::getInstance()->executar($strSQL)){
                return Db::getInstance()->getLastId();
            }else{
                return 0;
            }
        }
        
        public function alterar(MalaDiretaPessoa $obj){
            $strSQL  = "UPDATE CAD_MDP_MALAS_DIRETAS_PESSOAS SET ";
            $strSQL .= "MDP_DataHoraLeitura = '".$obj->getDataVisualizacao()."' ";
            $strSQL .= "WHERE MDP_ID = ".$obj->getId()." ";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function registrarVisualizacaoEmail(MalaDiretaPessoa $obj){
            $strSQL  = "UPDATE CAD_MDP_MALAS_DIRETAS_PESSOAS SET ";
            $strSQL .= "MDP_DataHoraLeitura = '".$obj->getDataVisualizacao()."' ";
            $strSQL .= "WHERE MDP_ID = ".$obj->getId()." ";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        /*public function excluir(MalaDireta $obj){            
            $strSQL  = "DELETE FROM CAD_MDP_MALAS_DIRETAS_PESSOAS WHERE MAD_ID = ".$obj->getId()." ";            
            if(Db::getInstance()->executar($strSQL)){
                $strSQL1  = "DELETE FROM ADM_TCA_TIPOS_CARTAS ";            
                $strSQL1 .= "WHERE TCA_ID = ".$obj->getId()." ";             
                return Db::getInstance()->executar($strSQL);
            }  else {
                return false;
            }
        }*/
    }
?>