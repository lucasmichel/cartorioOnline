<?php
    // codificação utf-8
    class RepoFamilia{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFamilia();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){  
            $strColunasConsultadas = " PESSOA_PRIMARIO.PES_Nome AS PES_Nome_Primario, ";
            $strColunasConsultadas .= " PESSOA_SECUNDARIO.PES_Nome AS PES_Nome_Secundario, ";
            $strColunasConsultadas .= " FAMILIA.PES_Primario_ID, FAMILIA.PES_Secundario_ID, FAMILIA.FAM_GrauParentesco, FAMILIA.FAM_Nome  ";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            } 
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_FAM_FAMILIAS AS FAMILIA "; 
            
            // membro primario
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS MEMBRO_PRIMARIO ON (MEMBRO_PRIMARIO.PES_ID = FAMILIA.PES_Primario_ID) ";
            $strSQL .= "INNER JOIN CAD_PES_PESSOAS AS PESSOA_PRIMARIO ON (PESSOA_PRIMARIO.PES_ID = MEMBRO_PRIMARIO.PES_ID) ";
            
            // membro secundario
            $strSQL .= "LEFT JOIN ADM_MEM_MEMBROS AS MEMBRO_SECUNDARIO ON (MEMBRO_SECUNDARIO.PES_ID = FAMILIA.PES_Secundario_ID) ";
            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PESSOA_SECUNDARIO ON (PESSOA_SECUNDARIO.PES_ID = MEMBRO_SECUNDARIO.PES_ID) ";
            $strSQL .= "WHERE FAMILIA.PES_Primario_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["PES_Primario_ID"])){
                $strSQL .= "AND FAMILIA.PES_Primario_ID = ".trim($arrStrFiltros["PES_Primario_ID"])." ";
            }
            if(!empty($arrStrFiltros["PES_Secundario_ID"])){
                $strSQL .= "AND FAMILIA.PES_Secundario_ID = ".trim($arrStrFiltros["PES_Secundario_ID"])." ";
            }
            if(!empty($arrStrFiltros["FAM_GrauParentesco"])){
                $strSQL .= "AND FAMILIA.FAM_GrauParentesco = '".trim($arrStrFiltros["FAM_GrauParentesco"])."' ";
            }
            
            $strSQL .= "ORDER BY FAMILIA.FAM_GrauParentesco DESC";  
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Familia $obj){
            $idPessoaSecundaria = "(NULL)";
            if($obj->getPessoaSecundarioId() > 0){
                $idPessoaSecundaria = $obj->getPessoaSecundarioId();
            }
            
            //verifica se ta vindo o nome com "(NÃO MEMBRO)";            
            $arrNome = explode("(NÃO MEMBRO)", $obj->getPessoaSecundarioNome());
            if( count($arrNome) > 0){
                $txtNomePessoaSecundaria = $arrNome[0];
            }else{
                $txtNomePessoaSecundaria = $obj->getPessoaSecundarioNome();
            }
            
            $strSQL = "INSERT INTO ADM_FAM_FAMILIAS (";
                $strSQL .= "PES_Primario_ID, ";                
                $strSQL .= "PES_Secundario_ID, ";                
                $strSQL .= "FAM_GrauParentesco, ";                
                $strSQL .= "FAM_Nome ";                
            $strSQL .= ")VALUES(";
                $strSQL .= "".$obj->getPessoaPrimarioId().", ";            
                $strSQL .= "".$idPessoaSecundaria.", ";  
                $strSQL .= "'".$obj->getGrauParentesco()."', ";            
                $strSQL .= "'".$txtNomePessoaSecundaria."' ";            
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(Familia $obj){
            $strSQL  = " DELETE FROM ADM_FAM_FAMILIAS ";            
            $strSQL .= " WHERE PES_Primario_ID = ".$obj->getPessoaPrimarioId()." ";                         
            Db::getInstance()->executar($strSQL);
            
            $strSQL1  = " DELETE FROM ADM_FAM_FAMILIAS ";            
            $strSQL1 .= " WHERE PES_Secundario_ID = ".$obj->getPessoaPrimarioId()." ";                         
            return Db::getInstance()->executar($strSQL1);
        }
    }
?>