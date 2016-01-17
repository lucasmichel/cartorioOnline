<?php
    // codificação utf-8
    class RepoLivroAuxiliar{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoLivroAuxiliar();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            
            $strColunasConsultadas = "*, USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
            $strColunasConsultadas.= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id ";

            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }                        
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM LIR_LIA_LIVRO_AUXILIAR AS AUXILIAR ";            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = AUXILIAR.USU_UsuarioCadastroID) ";
            
            $strSQL .= "WHERE AUXILIAR.LIA_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["LIA_ID"])){
                $strSQL .= "AND AUXILIAR.LIA_ID = ".$arrStrFiltros["LIA_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["LIA_NumeroLivro"])){
                $strSQL .= "AND AUXILIAR.LIA_NumeroLivro LIKE  '%".trim($arrStrFiltros["LIA_NumeroLivro"])."%' ";
            }            
            
            if(!empty($arrStrFiltros["LIA_DataHoraCadastro"])){
                $strSQL .= "AND AUXILIAR.LIA_DataHoraCadastro BETWEEN '".trim($arrStrFiltros["LIA_DataHoraCadastro"])." 00:00:00' AND '".trim($arrStrFiltros["LIA_DataHoraCadastro"])." 23:59:59' ";                
            }         
            
            if(!empty($arrStrFiltros["LIA_DataHoraCadastroIncio"])){
                $strSQL .= "AND AUXILIAR.LIA_DataHoraCadastro BETWEEN '".trim($arrStrFiltros["LIA_DataHoraCadastroIncio"])." 00:00:00' AND '".trim($arrStrFiltros["LIA_DataHoraCadastroFim"])." 23:59:59' ";                
            }         
            
            
            
            if(!empty($arrStrFiltros["USU_UsuarioCadastroID"])){
                $strSQL .= "AND AUXILIAR.USU_UsuarioCadastroID  = '".trim($arrStrFiltros["USU_UsuarioCadastroID"])."' ";
            }
            
            if(isset($arrStrFiltros["ANO"])){
                $strSQL .= "AND YEAR(AUXILIAR.LIA_DataHoraCadastro) = '".trim($arrStrFiltros["ANO"])."' ";
            }
            
            $strSQL .= "ORDER BY AUXILIAR.LIA_ID DESC ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(LivroAuxiliar $obj){
            $strSQL = "INSERT INTO LIR_LIA_LIVRO_AUXILIAR";            
            $strSQL.= "(";
            $strSQL.= "LIA_NumeroLivro,";
            $strSQL.= "LIA_DataHoraCadastro,";
            $strSQL.= "USU_UsuarioCadastroID";            
            $strSQL.= ")";
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " '".$obj->getNumero()."', ";            
            $strSQL.= " '".$obj->getDataHoraCadastro()."', ";            
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId()." ";            
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(LivroAuxiliar $obj){
            $strSQL = " UPDATE LIR_LIA_LIVRO_AUXILIAR SET ";            
            $strSQL.= " LIA_NumeroLivro = ".$obj->getNumero();
            $strSQL.= " WHERE LIA_ID = ".$obj->getId();
            //throw new Exception ($strSQL);
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(LivroAuxiliar $obj){
            $strSQL  = "DELETE FROM LIR_LIA_LIVRO_AUXILIAR ";            
            $strSQL .= "WHERE LIA_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        
        
        
        public function montarLivro($arrStrFiltros){
            
            $strColunasConsultadas = " * ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }
            
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM LIR_LIA_LIVRO_AUXILIAR AS LIVRO ";
            
            $strSQL .= " INNER JOIN LIR_FAU_FOLHA_AUXILIAR AS FOLHA ON(FOLHA.LIA_ID = LIVRO.LIA_ID) ";
            $strSQL .= " INNER JOIN LIR_LAU_LINHA_AUXILIAR AS LINHA ON(LINHA.FAU_ID = FOLHA.FAU_ID) ";
            
            $strSQL .= "WHERE LIVRO.LIP_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["LIP_ID"])){
                $strSQL .= "AND PREVIO.LIP_ID = ".$arrStrFiltros["LIP_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["LIP_DataHoraCadastroIncio"])){
                $strSQL .= "AND LIVRO.LIP_DataHoraCadastro BETWEEN '".trim($arrStrFiltros["LIP_DataHoraCadastroIncio"])." 00:00:00' AND '".trim($arrStrFiltros["LIP_DataHoraCadastroFim"])." 23:59:59' ";
            }
            if(!empty($arrStrFiltros["FPR_DataFolhaIncio"])){
                $strSQL .= "AND FOLHA.FPR_DataFolha BETWEEN '".trim($arrStrFiltros["FPR_DataFolhaIncio"])."' AND '".trim($arrStrFiltros["FPR_DataFolhaFim"])."' ";
            }
            if(!empty($arrStrFiltros["LPR_Data"])){
                $strSQL .= "AND FOLHA.LPR_Data BETWEEN '".trim($arrStrFiltros["LPR_DataIncio"])."' AND '".trim($arrStrFiltros["LPR_DataFim"])."' ";
            }
            
            //$strSQL .= "ORDER BY PREVIO.LIP_ID DESC ";
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }

    }
?>