<?php
    // codificação utf-8
    class RepoLivroPrevio{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoLivroPrevio();
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
            $strSQL .= $strColunasConsultadas." FROM LIR_LIP_LIVRO_PREVIO AS PREVIO ";            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = PREVIO.USU_UsuarioCadastroID) ";
            
            $strSQL .= "WHERE PREVIO.LIP_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["LIP_ID"])){
                $strSQL .= "AND PREVIO.LIP_ID = ".$arrStrFiltros["LIP_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["LIP_NumeroLivro"])){
                $strSQL .= "AND PREVIO.LIP_NumeroLivro LIKE  '%".trim($arrStrFiltros["LIP_NumeroLivro"])."%' ";
            }            
            
            if(!empty($arrStrFiltros["LIP_DataHoraCadastro"])){
                $strSQL .= "AND PREVIO.LIP_DataHoraCadastro BETWEEN '".trim($arrStrFiltros["LIP_DataHoraCadastro"])." 00:00:00' AND '".trim($arrStrFiltros["LIA_DataHoraCadastro"])." 23:59:59' ";                
            }         
            
            if(!empty($arrStrFiltros["LIP_DataHoraCadastroIncio"])){
                $strSQL .= "AND PREVIO.LIP_DataHoraCadastro BETWEEN '".trim($arrStrFiltros["LIP_DataHoraCadastroIncio"])." 00:00:00' AND '".trim($arrStrFiltros["LIP_DataHoraCadastroFim"])." 23:59:59' ";                
            }
            
            
            
            
            
            if(!empty($arrStrFiltros["USU_UsuarioCadastroID"])){
                $strSQL .= "AND PREVIO.USU_UsuarioCadastroID  = '".trim($arrStrFiltros["USU_UsuarioCadastroID"])."' ";
            }
            
            if(isset($arrStrFiltros["ANO"])){
                $strSQL .= "AND YEAR(PREVIO.LIP_DataHoraCadastro) = '".trim($arrStrFiltros["ANO"])."' ";
            }
            
            $strSQL .= "ORDER BY PREVIO.LIP_ID DESC ";
            
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(LivroPrevio $obj){
            $strSQL = "INSERT INTO LIR_LIP_LIVRO_PREVIO";            
            $strSQL.= "(";
            $strSQL.= "LIP_NumeroLivro,";
            $strSQL.= "LIP_DataHoraCadastro,";
            $strSQL.= "USU_UsuarioCadastroID";            
            $strSQL.= ")";
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " '".$obj->getNumero()."', ";            
            $strSQL.= " NOW(), ";            
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId()." ";            
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(LivroPrevio $obj){
            $strSQL = " UPDATE LIR_LIP_LIVRO_PREVIO SET ";
            
            $strSQL.= " LIP_NumeroLivro = ".$obj->getNumero();
            $strSQL.= " WHERE LIP_ID = ".$obj->getId();
            //throw new Exception ($strSQL);
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(LivroPrevio $obj){
            $strSQL  = "DELETE FROM LIR_LIP_LIVRO_PREVIO ";            
            $strSQL .= "WHERE LIP_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        
        
        
        public function montarLivro($arrStrFiltros){
            
            $strColunasConsultadas = " LIVRO.LIP_ID ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }
            
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM LIR_LIP_LIVRO_PREVIO AS LIVRO ";
            
            $strSQL .= " INNER JOIN LIR_FPR_FOLHA_PREVIO AS FOLHA ON(FOLHA.LIP_ID = LIVRO.LIP_ID) ";
            $strSQL .= " INNER JOIN LIR_LPR_LINHA_PREVIO AS LINHA ON(LINHA.FPR_ID = FOLHA.FPR_ID) ";
            
            $strSQL .= "WHERE LIVRO.LIP_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["LIP_ID"])){
                $strSQL .= "AND PREVIO.LIP_ID = ".$arrStrFiltros["LIP_ID"]." ";
            }
            
            //livro
            if(!empty($arrStrFiltros["LIP_DataHoraCadastroIncio"])){
                $strSQL .= "AND LIVRO.LIP_DataHoraCadastro BETWEEN '".trim($arrStrFiltros["LIP_DataHoraCadastroIncio"])." 00:00:00' AND '".trim($arrStrFiltros["LIP_DataHoraCadastroFim"])." 23:59:59' ";
            }
            
            //folha
            if(!empty($arrStrFiltros["FPR_DataFolhaIncio"])){
                $strSQL .= "AND FOLHA.FPR_DataFolha BETWEEN '".trim($arrStrFiltros["FPR_DataFolhaIncio"])."' AND '".trim($arrStrFiltros["FPR_DataFolhaFim"])."' ";
            }
            
            //linha
            if(!empty($arrStrFiltros["LPR_DataIncio"])){
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