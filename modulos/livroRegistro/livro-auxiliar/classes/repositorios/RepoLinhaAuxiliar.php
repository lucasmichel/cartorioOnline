<?php
    // codificação utf-8
    class RepoLinhaAuxiliar{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoLinhaAuxiliar();
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
            $strSQL .= $strColunasConsultadas." FROM LIR_LAU_LINHA_AUXILIAR AS LINHA ";
            
            $strSQL .= " INNER JOIN LIR_FAU_FOLHA_AUXILIAR AS FOLHA ON(FOLHA.FAU_ID = LINHA.FAU_ID) ";                        
            $strSQL .= " INNER JOIN LIR_LIA_LIVRO_AUXILIAR AS LIVRO ON(LIVRO.LIA_ID = FOLHA.LIA_ID) ";
            
            $strSQL .= " INNER JOIN LIR_TIL_TIPO_LINHA AS TIPO_LINHA ON(TIPO_LINHA.TIL_ID = LINHA.TIL_ID) ";
            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = LINHA.USU_UsuarioCadastroID) ";
            $strSQL .= " LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON(USUARIO_ALTERACAO.USU_ID = LINHA.USU_UsuarioAlteracaoID) ";            
            $strSQL .= "WHERE LINHA.LAU_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["LAU_ID"])){
                $strSQL .= "AND LINHA.LAU_ID = ".$arrStrFiltros["LAU_ID"]." ";
            }
            if(!empty($arrStrFiltros["LIA_ID"])){
                $strSQL .= "AND LIVRO.LIA_ID = ".$arrStrFiltros["LIA_ID"]." ";
            }
            if(!empty($arrStrFiltros["FAU_ID"])){
                $strSQL .= "AND FOLHA.FAU_ID = ".$arrStrFiltros["FAU_ID"]." ";
            }
            if(!empty($arrStrFiltros["TIL_ID"])){
                $strSQL .= "AND LINHA.TIL_ID = ".$arrStrFiltros["TIL_ID"]." ";
            }
            if(!empty($arrStrFiltros["TIL_Tipo"])){
                $strSQL .= "AND TIPO_LINHA.TIL_Tipo = '".$arrStrFiltros["TIL_Tipo"]."' ";
            }
            
            
            
            if(!empty($arrStrFiltros["LAU_Descricao"])){
                $strSQL .= "AND LINHA.LAU_Descricao LIKE  '%".trim($arrStrFiltros["LAU_Descricao"])."%' ";
            }
            if(!empty($arrStrFiltros["LAU_Guia"])){
                $strSQL .= "AND LINHA.LAU_Guia LIKE  '%".trim($arrStrFiltros["LAU_Guia"])."%' ";
            }
            if(!empty($arrStrFiltros["LAU_ProtocoloRecepcao"])){
                $strSQL .= "AND LINHA.LAU_ProtocoloRecepcao LIKE  '%".trim($arrStrFiltros["LAU_ProtocoloRecepcao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["LAU_Cpf"])){
                $strSQL .= "AND LINHA.LAU_Cpf = '".trim($arrStrFiltros["LAU_Cpf"])."' ";
            }
            if(!empty($arrStrFiltros["LAU_Data"])){
                $strSQL .= "AND LINHA.LAU_Data = '".trim($arrStrFiltros["LAU_Data"])."' ";
            }
            if(!empty($arrStrFiltros["LAU_Valor"])){
                $strSQL .= "AND LINHA.LAU_Valor = ".trim($arrStrFiltros["LAU_Valor"])." ";
            }
            
            $strSQL .= "ORDER BY FOLHA.LIA_ID, LINHA.FAU_ID ";
            
            /*if(isset($arrStrFiltros["FAU_ID"])){
                var_dump($arrStrFiltros);
                var_dump($strSQL);
                die();
            }*/
            

            

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            //var_dump($strSQL);
            //var_dump($arrStrFiltros);die();
            
                       
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(LinhaAuxiliar $obj){            
            if($obj->getQuantidade() == ""){
                $quantidade = 0;
            }else{
                $quantidade = $obj->getQuantidade();
            }
            
            $strSQL = "INSERT INTO LIR_LAU_LINHA_AUXILIAR";
            $strSQL.= "(";
            $strSQL.= "FAU_ID,";
            $strSQL.= "TIL_ID,";
            
            $strSQL.= "LAU_Descricao,";
            $strSQL.= "LAU_Guia,";            
            $strSQL.= "LAU_ProtocoloRecepcao,";
            $strSQL.= "LAU_Quantidade,";
            $strSQL.= "LAU_Cpf,";
            $strSQL.= "LAU_Data,";
            $strSQL.= "LAU_Valor,";
            
            $strSQL.= "LAU_DataHoraCadastro,";            
            $strSQL.= "USU_UsuarioCadastroID ";
            $strSQL.= ")";            
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " ".$obj->getFolhaAuxiliar()->getId().", ";            
            $strSQL.= " ".$obj->getTipoLinha()->getId().", ";
            
            $strSQL.= " '".$obj->getDescricao()."', ";
            $strSQL.= " '".$obj->getGuia()."', ";
            $strSQL.= " '".$obj->getProtocoloRecepcao()."', ";
            $strSQL.= " ".$quantidade.", ";
            $strSQL.= " '".$obj->getCpf()."', ";
            $strSQL.= " '".$obj->getData()."', ";
            $strSQL.= " ".$obj->getValor().", ";
            
            $strSQL.= " '".$obj->getDataHoraCadastro()."', ";            
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId()." ";
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(LinhaAuxiliar $obj){
            
            if($obj->getQuantidade() == ""){
                $quantidade = 0;
            }else{
                $quantidade = $obj->getQuantidade();
            }
            
            $strSQL = "UPDATE LIR_LAU_LINHA_AUXILIAR SET ";     
            
            
            $strSQL.= "FAU_ID = ".$obj->getFolhaAuxiliar()->getId().", ";
            $strSQL.= "TIL_ID = ".$obj->getTipoLinha()->getId().", ";
            
            $strSQL.= "LAU_Descricao = '".$obj->getDescricao()."', ";
            $strSQL.= "LAU_Guia = '".$obj->getGuia()."', ";
            $strSQL.= "LAU_ProtocoloRecepcao = '".$obj->getProtocoloRecepcao()."', ";
            $strSQL.= "LAU_Quantidade = ".$quantidade.", ";
            $strSQL.= "LAU_Cpf = '".$obj->getCpf()."', ";
            $strSQL.= "LAU_Data = '".$obj->getData()."', ";
            $strSQL.= "LAU_Valor = ".$obj->getValor().", ";
            
            $strSQL.= "LAU_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."', ";            
            $strSQL.= "USU_UsuarioAlteracaoID = ".$obj->getUsuarioAlteracao()->getId()." ";
            
            $strSQL.= "WHERE LAU_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
        
        public function excluir(LinhaAuxiliar $obj){
            $strSQL = "DELETE FROM LIR_LAU_LINHA_AUXILIAR  ";
            $strSQL.= "WHERE LAU_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
    }
?>