<?php
    // codificação utf-8
    class RepoFolhaAuxiliar{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFolhaAuxiliar();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            
            $strColunasConsultadas = "*, USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
            $strColunasConsultadas.= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id, ";

            $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_Login AS Usuario_Alteracao, ";
            $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_ID AS Usuario_Alteracao_Id "; 
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }                        
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM LIR_FAU_FOLHA_AUXILIAR AS FOLHA ";                        
            $strSQL .= " INNER JOIN LIR_LIA_LIVRO_AUXILIAR AS AUXILIAR ON(AUXILIAR.LIA_ID = FOLHA.LIA_ID) ";
            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = FOLHA.USU_UsuarioCadastroID) ";            
            $strSQL .= " LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON(USUARIO_ALTERACAO.USU_ID = FOLHA.USU_UsuarioAlteracaoID) ";
            $strSQL .= "WHERE FOLHA.FAU_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["FAU_ID"])){
                $strSQL .= "AND FOLHA.FAU_ID = ".$arrStrFiltros["FAU_ID"]." ";
            }
            if(!empty($arrStrFiltros["LIA_ID"])){
                $strSQL .= "AND FOLHA.LIA_ID = ".$arrStrFiltros["LIA_ID"]." ";
            }
            if(!empty($arrStrFiltros["FAU_NumeroFolha"])){
                $strSQL .= "AND FOLHA.FAU_NumeroFolha LIKE  '%".trim($arrStrFiltros["FAU_NumeroFolha"])."%' ";
            }            
            if(!empty($arrStrFiltros["FAU_DataFolha"])){
                $strSQL .= "AND FOLHA.FAU_DataFolha = '".trim($arrStrFiltros["FAU_DataFolha"])."' ";
            }            
            
            $strSQL .= "ORDER BY FOLHA.FAU_ID DESC ";
            
            if(!empty($arrStrFiltros["LIA_ID"])){
                //print_r($strSQL);
            }

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
                       
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(FolhaAuxiliar $obj){
            /*$intUsuarioAlteraco = "(NULL)";
            if($obj->getUsuarioAlteracao()->getId() > 0){
                $intUsuarioAlteraco = $obj->getUsuarioAlteracao()->getId();
            }*/
            $strSQL = "INSERT INTO LIR_FAU_FOLHA_AUXILIAR";
            $strSQL.= "(";
            $strSQL.= "LIA_ID , ";
            $strSQL.= "FAU_NumeroFolha,";
            $strSQL.= "FAU_DataFolha,";
            $strSQL.= "FAU_DataHoraCadastro,";            
            $strSQL.= "USU_UsuarioCadastroID ";
            $strSQL.= ")";            
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " ".$obj->getLivroAuxiliar()->getId().", ";
            $strSQL.= " '".$obj->getNumero()."', ";
            $strSQL.= " '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($obj->getData())."', ";
            $strSQL.= " '".$obj->getDataHoraCadastro()."', ";            
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId()." ";
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(FolhaAuxiliar $obj){
            $strSQL = "UPDATE LIR_FAU_FOLHA_AUXILIAR SET ";            
            $strSQL.= "LIA_ID = ".$obj->getLivroAuxiliar()->getId().", ";
            $strSQL.= "FAU_NumeroFolha = '".$obj->getNumero()."', ";
            $strSQL.= "FAU_DataFolha = '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($obj->getData())."', ";
            $strSQL.= "FAU_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."', ";            
            $strSQL.= "USU_UsuarioAlteracaoID = ".$obj->getUsuarioAlteracao()->getId()." ";
            $strSQL.= "WHERE FAU_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
        
        public function excluir(FolhaAuxiliar $obj){
            $strSQL  = "DELETE FROM LIR_FAU_FOLHA_AUXILIAR ";            
            $strSQL .= "WHERE FAU_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
    }
?>