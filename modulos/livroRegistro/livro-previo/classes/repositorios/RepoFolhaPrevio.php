<?php
    // codificação utf-8
    class RepoFolhaPrevio{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFolhaPrevio();
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
            $strSQL .= $strColunasConsultadas." FROM LIR_FPR_FOLHA_PREVIO AS FOLHA ";                        
            $strSQL .= " INNER JOIN LIR_LIP_LIVRO_PREVIO AS PREVIO ON(PREVIO.LIP_ID = FOLHA.LIP_ID) ";
            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = FOLHA.USU_UsuarioCadastroID) ";            
            $strSQL .= " LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON(USUARIO_ALTERACAO.USU_ID = FOLHA.USU_UsuarioAlteracaoID) ";
            $strSQL .= "WHERE FOLHA.FPR_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["FPR_ID"])){
                $strSQL .= "AND FOLHA.FPR_ID = ".$arrStrFiltros["FPR_ID"]." ";
            }
            if(!empty($arrStrFiltros["LIP_ID"])){
                $strSQL .= "AND FOLHA.LIP_ID = ".$arrStrFiltros["LIP_ID"]." ";
            }
            if(!empty($arrStrFiltros["FAU_NumeroFolha"])){
                $strSQL .= "AND FOLHA.FAU_NumeroFolha LIKE  '%".trim($arrStrFiltros["FAU_NumeroFolha"])."%' ";
            }
            if(!empty($arrStrFiltros["FPR_NumeroFolha"])){
                $strSQL .= "AND FOLHA.FPR_NumeroFolha = '".trim($arrStrFiltros["FPR_NumeroFolha"])."' ";
            }            
            
            //folha
            if(!empty($arrStrFiltros["FPR_DataFolhaIncio"])){
                $strSQL .= "AND FOLHA.FPR_DataFolha BETWEEN '".trim($arrStrFiltros["FPR_DataFolhaIncio"])."' AND '".trim($arrStrFiltros["FPR_DataFolhaFim"])."' ";
            }
            
            $strSQL .= "ORDER BY FOLHA.FPR_ID DESC ";
            
            if(!empty($arrStrFiltros["LIA_ID"])){
                //print_r($strSQL);
            }

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
                       
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(FolhaPrevio $obj){
            /*$intUsuarioAlteraco = "(NULL)";
            if($obj->getUsuarioAlteracao()->getId() > 0){
                $intUsuarioAlteraco = $obj->getUsuarioAlteracao()->getId();
            }*/
            $strSQL = "INSERT INTO LIR_FPR_FOLHA_PREVIO";
            $strSQL.= "(";
            $strSQL.= "LIP_ID , ";
            $strSQL.= "FPR_NumeroFolha,";
            $strSQL.= "FPR_DataFolha,";
            $strSQL.= "FPR_DataHoraCadastro,";            
            $strSQL.= "USU_UsuarioCadastroID ";
            $strSQL.= ")";            
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " ".$obj->getLivroPrevio()->getId().", ";
            $strSQL.= " '".$obj->getNumero()."', ";
            $strSQL.= " '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($obj->getData())."', ";
            $strSQL.= " '".$obj->getDataHoraCadastro()."', ";            
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId()." ";
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(FolhaPrevio $obj){
            $strSQL = "UPDATE LIR_FPR_FOLHA_PREVIO SET ";            
            $strSQL.= "LIP_ID = ".$obj->getLivroPrevio()->getId().", ";
            $strSQL.= "FPR_NumeroFolha = '".$obj->getNumero()."', ";
            $strSQL.= "FPR_DataFolha = '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($obj->getData())."', ";
            $strSQL.= "FPR_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."', ";            
            $strSQL.= "USU_UsuarioAlteracaoID = ".$obj->getUsuarioAlteracao()->getId()." ";
            $strSQL.= "WHERE FPR_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
        
        public function excluir(FolhaPrevio $obj){
            $strSQL  = "DELETE FROM LIR_FPR_FOLHA_PREVIO ";            
            $strSQL .= "WHERE FPR_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
    }
?>