<?php
    // codificação utf-8
    class RepoLinhaPrevio{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoLinhaPrevio();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            
            //$strColunasConsultadas = "LINHA.*, USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
            $strColunasConsultadas = " *, USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
            $strColunasConsultadas.= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id, ";

            $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_Login AS Usuario_Alteracao, ";
            $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_ID AS Usuario_Alteracao_Id "; 
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }                        
            $strSQL  = "SELECT ";
            $strSQL .= $strColunasConsultadas." FROM LIR_LPR_LINHA_PREVIO AS LINHA ";
            
            $strSQL .= " INNER JOIN LIR_FPR_FOLHA_PREVIO AS FOLHA ON(FOLHA.FPR_ID = LINHA.FPR_ID) ";                        
            $strSQL .= " INNER JOIN LIR_LIP_LIVRO_PREVIO AS LIVRO ON(LIVRO.LIP_ID = FOLHA.LIP_ID) ";
            
            $strSQL .= " INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON(USUARIO_CADASTRO.USU_ID = LINHA.USU_UsuarioCadastroID) ";
            $strSQL .= " LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON(USUARIO_ALTERACAO.USU_ID = LINHA.USU_UsuarioAlteracaoID) ";            
            $strSQL .= "WHERE LINHA.LPR_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["LIP_ID"])){
                $strSQL .= "AND FOLHA.LIP_ID = ".$arrStrFiltros["LIP_ID"]." ";
            }
            if(!empty($arrStrFiltros["LPR_ID"])){
                $strSQL .= "AND LINHA.LPR_ID = ".$arrStrFiltros["LPR_ID"]." ";
            }
            if(!empty($arrStrFiltros["FPR_ID"])){
                $strSQL .= "AND LINHA.FPR_ID = ".$arrStrFiltros["FPR_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["LPR_Descricao"])){
                $strSQL .= "AND LINHA.LPR_Descricao LIKE  '%".trim($arrStrFiltros["LPR_Descricao"])."%' ";
            }
            if(!empty($arrStrFiltros["LPR_Guia"])){
                $strSQL .= "AND LINHA.LPR_Guia LIKE  '%".trim($arrStrFiltros["LPR_Guia"])."%' ";
            }
            if(!empty($arrStrFiltros["LPR_ProtocoloRecepcao"])){
                $strSQL .= "AND LINHA.LPR_ProtocoloRecepcao LIKE  '%".trim($arrStrFiltros["LPR_ProtocoloRecepcao"])."%' ";
            }
            if(!empty($arrStrFiltros["LPR_Nome"])){
                $strSQL .= "AND LINHA.LPR_Nome LIKE  '%".trim($arrStrFiltros["LPR_Nome"])."%' ";
            }
            
            if(!empty($arrStrFiltros["LPR_Cpf"])){
                $strSQL .= "AND LINHA.LPR_Cpf = '".trim($arrStrFiltros["LPR_Cpf"])."' ";
            }
            if(!empty($arrStrFiltros["LPR_Data"])){
                $strSQL .= "AND LINHA.LPR_Data = '".trim($arrStrFiltros["LPR_Data"])."' ";
            }
            if(!empty($arrStrFiltros["LPR_Valor"])){
                $strSQL .= "AND LINHA.LPR_Valor = ".trim($arrStrFiltros["LPR_Valor"])." ";
            }
            
            //linha
            if(!empty($arrStrFiltros["LPR_DataIncio"])){
                $strSQL .= "AND LINHA.LPR_Data BETWEEN '".trim($arrStrFiltros["LPR_DataIncio"])."' AND '".trim($arrStrFiltros["LPR_DataFim"])."' ";
            }
            
            
            $strSQL .= "ORDER BY FOLHA.FPR_ID, LINHA.LPR_ID DESC ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            //throw new Exception($strSQL);
            return Db::getInstance()->select($strSQL);
        }

        public function salvar(LinhaPrevio $obj){            
            if($obj->getTipoLinha() !== null){
                $idTipoLinha = $obj->getTipoLinha()->getId();
            }else{
                $idTipoLinha = '(NULL)';                
            }
            
            if($obj->getQuantidade() == ""){
                $quantidade = 0;
            }else{
                $quantidade = $obj->getQuantidade();
            }
            
            $strSQL = "INSERT INTO LIR_LPR_LINHA_PREVIO";
            $strSQL.= "(";
            $strSQL.= "FPR_ID,";
            $strSQL.= "TIL_ID,";
            
            $strSQL.= "LPR_Descricao,";
            $strSQL.= "LPR_Guia,";            
            $strSQL.= "LPR_Nome,";
            $strSQL.= "LPR_Cpf,";
            $strSQL.= "LPR_ProtocoloRecepcao,";
            
            $strSQL.= "LPR_Quantidade,";
            $strSQL.= "LPR_Data,";
            $strSQL.= "LPR_Valor,";
            
            $strSQL.= "LPR_DataHoraCadastro,";            
            $strSQL.= "USU_UsuarioCadastroID, ";
            $strSQL.= "LPR_StatusConclusao ";
            $strSQL.= ")";            
            $strSQL.= "VALUES";
            $strSQL.= "(";
            $strSQL.= " ".$obj->getFolhaPrevio()->getId().", ";            
            $strSQL.= " ".$idTipoLinha.", ";
            
            $strSQL.= " '".$obj->getDescricao()."', ";
            $strSQL.= " '".$obj->getGuia()."', ";
            $strSQL.= " '".$obj->getNome()."', ";
            $strSQL.= " '".$obj->getCpf()."', ";
            $strSQL.= " '".$obj->getProtocoloRecepcao()."', ";
            
            $strSQL.= " ".$quantidade.", ";            
            $strSQL.= " '".$obj->getData()."', ";
            $strSQL.= " ".$obj->getValor().", ";
            
            $strSQL.= " '".$obj->getDataHoraCadastro()."', ";            
            $strSQL.= " ".$obj->getUsuarioCadastro()->getId().", ";
            $strSQL.= " '".$obj->getStatusConclusao()."' ";
            $strSQL.= ")";
            return Db::getInstance()->executar($strSQL);
        }

        public function alterar(LinhaPrevio $obj){
            if($obj->getTipoLinha() !== null){
                $idTipoLinha = $obj->getTipoLinha()->getId();
            }else{
                $idTipoLinha = '(NULL)';                
            }
            if($obj->getQuantidade() == ""){
                $quantidade = 0;
            }else{
                $quantidade = $obj->getQuantidade();
            }
            
            $strSQL = "UPDATE LIR_LPR_LINHA_PREVIO SET ";     
            
            
            $strSQL.= "FPR_ID = ".$obj->getFolhaPrevio()->getId().", ";
            $strSQL.= "TIL_ID = ".$idTipoLinha.", ";
            
            $strSQL.= "LPR_Descricao = '".$obj->getDescricao()."', ";            
            $strSQL.= "LPR_Guia = '".$obj->getGuia()."', ";
            $strSQL.= "LPR_ProtocoloRecepcao = '".$obj->getProtocoloRecepcao()."', ";
            $strSQL.= "LPR_Nome = '".$obj->getNome()."', ";
            $strSQL.= "LPR_Cpf = '".$obj->getCpf()."', ";            
            $strSQL.= "LPR_Quantidade = ".$quantidade.", ";
            
            $strSQL.= "LPR_Data = '".$obj->getData()."', ";
            $strSQL.= "LPR_Valor = ".$obj->getValor().", ";
            
            $strSQL.= "LPR_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."', ";            
            $strSQL.= "USU_UsuarioAlteracaoID = ".$obj->getUsuarioAlteracao()->getId()." ";
            
            $strSQL.= "WHERE LPR_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
        
        
        
        public function alterarStatusConclusao(LinhaPrevio $obj){
            $strSQL = "UPDATE LIR_LPR_LINHA_PREVIO SET ";     
            $strSQL.= "LPR_StatusConclusao = 'S', ";            
            $strSQL.= "LPR_DataHoraStatusConclusao = NOW(), ";            
            $strSQL.= "USU_StatusConclusao_ID = ".$_SESSION["USUARIO_ID"]." ";            
            $strSQL.= "WHERE LPR_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
        
        
        
        public function excluir(LinhaPrevio $obj){
            $strSQL = "DELETE FROM LIR_LPR_LINHA_PREVIO  ";
            $strSQL.= "WHERE LPR_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL); 
        }
    }
?>