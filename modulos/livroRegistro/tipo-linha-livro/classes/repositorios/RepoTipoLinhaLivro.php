<?php
    // codificação utf-8
    class RepoTipoLinhaLivro{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoTipoLinhaLivro();
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
            $strSQL .= $strColunasConsultadas." FROM LIR_TIL_TIPO_LINHA AS TIPO_LINHA ";            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = TIPO_LINHA.USU_UsuarioCadastroID) ";
            $strSQL .= " LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON(USUARIO_ALTERACAO.USU_ID = TIPO_LINHA.USU_UsuarioAlteracaoID) ";            
            $strSQL .= "WHERE TIPO_LINHA.TIL_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["TIL_ID"])){
                $strSQL .= "AND TIPO_LINHA.TIL_ID = ".$arrStrFiltros["TIL_ID"]." ";
            }
            
             if(!empty($arrStrFiltros["TIL_Descricao"])){
                $strSQL .= "AND TIPO_LINHA.TIL_Descricao LIKE  '%".trim($arrStrFiltros["TIL_Descricao"])."%' ";
            }            
            if(!empty($arrStrFiltros["TIL_Tipo"])){
                $strSQL .= "AND TIPO_LINHA.TIL_Tipo = '".$arrStrFiltros["TIL_Tipo"]."' ";
            }
            if(!empty($arrStrFiltros["TIL_Status"])){
                $strSQL .= "AND TIPO_LINHA.TIL_Status = '".$arrStrFiltros["TIL_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY TIPO_LINHA.TIL_ID DESC ";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(TipoLinhaLivro $obj){
            $intUsuarioAlteraco = "(NULL)";
            if($obj->getUsuarioAlteracao()->getId() > 0){
                $intUsuarioAlteraco = $obj->getUsuarioAlteracao()->getId();
            }
            $strSQL = "INSERT INTO LIR_TIL_TIPO_LINHA";
            $strSQL.= "(";
            $strSQL.= "TIL_Descricao,";
            $strSQL.= "TIL_Tipo,";
            $strSQL.= "TIL_DataHoraCadastro,";
            $strSQL.= "TIL_Status,";
            $strSQL.= "USU_UsuarioCadastroID ";
            $strSQL.= ")";            
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " '".$obj->getDescricao()."', ";
            $strSQL.= " '".$obj->getTipo()."', ";
            $strSQL.= " '".$obj->getDataHoraCadastro()."', ";
            $strSQL.= " '".$obj->getStatus()."', ";
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId()." ";
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(TipoLinhaLivro $obj){
            $strSQL = "UPDATE LIR_TIL_TIPO_LINHA SET ";            
            $strSQL.= "TIL_Descricao = '".$obj->getDescricao()."', ";
            $strSQL.= "TIL_Tipo = '".$obj->getTipo()."', ";
            $strSQL.= "TIL_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."', ";
            $strSQL.= "TIL_Status = '".$obj->getStatus()."', ";
            $strSQL.= "USU_UsuarioAlteracaoID = ".$obj->getUsuarioAlteracao()->getId()." ";
            $strSQL.= "WHERE TIL_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
    }
?>