<?php
    // codificação utf-8
    class RepoMalaDireta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoMalaDireta();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
           $strColunasConsultadas  = "*, USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro,   ";
            $strColunasConsultadas  .= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id,   ";
            
            $strColunasConsultadas  .= "USUARIO_ALTERACAO.USU_Login AS Usuario_Alteracao,   ";
            $strColunasConsultadas  .= "USUARIO_ALTERACAO.USU_ID AS Usuario_Alteracao_Id   ";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_MAD_MALAS_DIRETAS AS MALA ";             
            $strSQL .= "INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON (USUARIO_CADASTRO.USU_ID = MALA.USU_Cadastro_ID) ";            
            $strSQL .= "LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON (USUARIO_ALTERACAO.USU_ID = MALA.USU_Alteracao_ID) ";            
            $strSQL .= "WHERE MALA.MAD_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["MAD_ID"])){
                $strSQL .= "AND MALA.MAD_ID = ".trim($arrStrFiltros["MAD_ID"])." ";
            }

            if(!empty($arrStrFiltros["MAD_Assunto"])){
                $strSQL .= "AND MALA.MAD_Assunto LIKE  '%".trim($arrStrFiltros["MAD_Assunto"])."%' ";
            }            
            if(!empty($arrStrFiltros["MAD_Conteudo"])){
                $strSQL .= "AND MALA.MAD_Conteudo LIKE  '%".trim($arrStrFiltros["MAD_Conteudo"])."%' ";
            }            
            $strSQL .= "ORDER BY MALA.MAD_ID DESC";            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(MalaDireta $obj){
            $strSQL = "INSERT INTO CAD_MAD_MALAS_DIRETAS (";
                $strSQL .= "MAD_Assunto, ";
                $strSQL .= "MAD_DataHoraCadastro, ";
                $strSQL .= "MAD_Conteudo, ";
                $strSQL .= "USU_Cadastro_ID ";
            $strSQL .= ")VALUES(";            
            $strSQL .= "'".$obj->getAssunto()."', ";            
            $strSQL .= "'".$obj->getDataHoraCadastro()."', ";            
            $strSQL .= "'".$obj->getConteudo()."', ";                        
            $strSQL .= " ".$obj->getUsuarioCadastro()->getId()." ";            
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(MalaDireta $obj){
            $strSQL  = "UPDATE CAD_MAD_MALAS_DIRETAS SET ";
            $strSQL .= "MAD_Assunto = '".$obj->getAssunto()."', ";
            $strSQL .= "MAD_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."', ";            
            $strSQL .= "MAD_Conteudo = '".$obj->getConteudo()."', ";            
            $strSQL .= "USU_Alteracao_ID = ".$obj->getUsuarioAlteracao()->getId()." ";            
            $strSQL .= "WHERE MAD_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(MalaDireta $obj){            
            $strSQL  = "DELETE FROM CAD_MDP_MALAS_DIRETAS_PESSOAS WHERE MAD_ID = ".$obj->getId()." ";            
            if(Db::getInstance()->executar($strSQL)){
                $strSQL1  = "DELETE FROM ADM_TCA_TIPOS_CARTAS ";            
                $strSQL1 .= "WHERE TCA_ID = ".$obj->getId()." ";             
                return Db::getInstance()->executar($strSQL);
            }  else {
                return false;
            }
        }
    }
?>