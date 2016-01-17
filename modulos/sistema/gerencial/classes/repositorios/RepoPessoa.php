<?php
    // codificação utf-8
    class RepoPessoa{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoPessoa();
            }
            return self::$objInstance;
        }
                
        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_PES_PESSOAS ";            
            
            $strSQL .= "WHERE PES_CPF IS NOT NULL ";
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND PES_ID = ".$arrStrFiltros["PES_ID"]." ";
            }            
            if(!empty($arrStrFiltros["PES_CPF"])){
                $strSQL .= "AND PES_CPF = '".$arrStrFiltros["PES_CPF"]."' ";
            }
            
            if(isset($arrStrFiltros["PES_CPF_EDICAO"])){
                $strSQL .= "AND PES_CPF = '".$arrStrFiltros["PES_CPF_EDICAO"]."' ";
                $strSQL .= "AND PES_ID <> ".$arrStrFiltros["PES_ID_EDICAO"]." ";
            }
            
            if(!empty($arrStrFiltros["PES_Nome"])){
                $strSQL .= "AND PES_Nome LIKE '".$arrStrFiltros["PES_Nome"]."%' ";
            }
            if(!empty($arrStrFiltros["USU_Sistema_ID"])){
                $strSQL .= "AND USU_Sistema_ID = ".$arrStrFiltros["USU_Sistema_ID"]." ";
            }
            if(!empty($arrStrFiltros["PES_Status"])){
                $strSQL .= "AND PES_Status='".$arrStrFiltros["PES_Status"]."' ";
            }
            $strSQL .= "ORDER BY PES_Nome ASC ";                   
           
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Pessoa $obj){
            $intIdNIvelEscolaridade = "(NULL)";            
            if($obj->getNivelEscolaridade()->getId() > 0){
                $intIdNIvelEscolaridade = $obj->getNivelEscolaridade()->getId();
            }
            
            $strDataFalcimento = "(NULL)";
            if($obj->getDataFalecimento() != null){
                $strDataFalcimento = "'".$obj->getDataFalecimento()."'";
            }
            
            $intIdEstadoCivil = "(NULL)";
            if($obj->getEstadoCivil()->getId() > 0){
                $intIdEstadoCivil = $obj->getEstadoCivil()->getId();
            }
            
            $strDataCasamento = "(NULL)";
            if($obj->getDataCasamento() != ""){
                $strDataCasamento = "'".$obj->getDataCasamento()."'";
            }
            
            $strSQL = "INSERT INTO CAD_PES_PESSOAS (";
                $strSQL .= "NES_ID, ECV_ID, PES_Matricula, ";
                $strSQL .= "PES_CPF, PES_RG, PES_RGOrgaoEmissao, ";                
                $strSQL .= "PES_Formacao, PES_Nome, ";                
                $strSQL .= "PES_Sexo, PES_DataNascimento, ";                
                $strSQL .= "PES_GrupoSanguineo, PES_Doador, ";
                $strSQL .= "PES_EnderecoCep, PES_EnderecoLogradouro, ";                
                $strSQL .= "PES_EnderecoNumero, PES_EnderecoComplemento, PES_EnderecoPontoReferencia, ";                
                $strSQL .= "PES_EnderecoBairro, PES_EnderecoCidade, PES_EnderecoUf, ";
                $strSQL .= "PES_MaeNome, PES_PaiNome, PES_Observacao, ";
                $strSQL .= "PES_ArquivoFoto, PES_DataFalecimento,  ";
                $strSQL .= "PES_Naturalidade, PES_Nacionalidade, PES_Status, PES_DataHoraCadastro, PES_DataHoraAlteracao, USU_Cadastro_ID, PES_DataCasamento, PES_QuantidadeFilhos, ";
                $strSQL .= "PES_UfNascimento)";
            $strSQL .= "VALUES (";
            $strSQL .= $intIdNIvelEscolaridade.", "
                       .$intIdEstadoCivil.", '"                    
                       .$obj->getMatricula()."', '"                    
                       .$obj->getCpf()."', '"
                       .$obj->getRg()."', '"
                       .$obj->getRgOrgaoEmissor()."', '"
                       .$obj->getFormacao()."', '"
                       .$obj->getNome()."', '"                       
                       .$obj->getSexo()."', '"
                       .$obj->getDataNascimento()."', '"
                       .$obj->getGrupoSanguineo()."', '"
                       .$obj->getDoador()."', '"
                       .$obj->getEndereco()->getCep()."', '"
                       .$obj->getEndereco()->getLogradouro()."', '"
                       .$obj->getEndereco()->getNumero()."', '"
                       .$obj->getEndereco()->getComplemento()."', '"
                       .$obj->getEndereco()->getPontoReferencia()."', '"
                       .$obj->getEndereco()->getBairro()."', '"
                       .$obj->getEndereco()->getCidade()."', '"
                       .$obj->getEndereco()->getUf()."', '"
                       .$obj->getMaeNome()."', '"
                       .$obj->getPaiNome()."', '"
                       .$obj->getObservacao()."', '"
                       .$obj->getFoto()."', "                               
                       .$strDataFalcimento.", '"                                                   
                       .$obj->getNaturalidade()."', '"                               
                       .$obj->getNascionalidade()."', '"
                       .$obj->getStatus()."',  "
                       ."'".date("Y-m-d H:i:s")."' , " 
                       ."'".date("Y-m-d H:i:s")."' , " //Gravar no campo data de atualização no momento do novo cadastro para que o novo membro já cadastre como atualizado.
                       .$_SESSION["USUARIO_ID"].", "
                       .$strDataCasamento.", ".$obj->getQtdFilhos().", '".$obj->getUfNascimento()."')";
            
            if(Db::getInstance()->executar($strSQL)){
                return Db::getInstance()->getLastId();
            }else{
                return 0;
            }
        }
        
        public function alterar(Pessoa $obj){            
            $intIdNIvelEscolaridade = "(NULL)";
            if($obj->getNivelEscolaridade()->getId() > 0){
                $intIdNIvelEscolaridade = $obj->getNivelEscolaridade()->getId();
            }
            $intIdUsuarioSistema = "(NULL)";
            $strDataFalcimento = "(NULL)";
            if($obj->getDataFalecimento() != null){
                $strDataFalcimento = "'".$obj->getDataFalecimento()."'";
            }
            $intIdEstadoCivil = "(NULL)";
            if($obj->getEstadoCivil()->getId() > 0){
                $intIdEstadoCivil = $obj->getEstadoCivil()->getId();
            }
            $strDataCasamento = "(NULL)";
            if($obj->getDataCasamento() != ""){
                $strDataCasamento = "'".$obj->getDataCasamento()."'";
            }
            $strSQL = "UPDATE CAD_PES_PESSOAS SET                      
                      NES_ID = ".$intIdNIvelEscolaridade.",
                      USU_Sistema_ID = ".$intIdUsuarioSistema.",
                      ECV_ID = ".$intIdEstadoCivil.",
                      PES_Matricula = '".$obj->getMatricula()."',
                      PES_CPF = '".$obj->getCpf()."',
                      PES_RG = '".$obj->getRg()."',                      
                      PES_RGOrgaoEmissao = '".$obj->getRgOrgaoEmissor()."',
                      PES_Formacao = '".$obj->getFormacao()."',
                      PES_Nome = '".$obj->getNome()."',                      
                      PES_Sexo = '".$obj->getSexo()."',
                      PES_DataNascimento = '".$obj->getDataNascimento()."',
                      PES_GrupoSanguineo = '".$obj->getGrupoSanguineo()."',
                      PES_Doador = '".$obj->getDoador()."',                      
                      PES_EnderecoCep = '".$obj->getEndereco()->getCep()."',
                      PES_EnderecoLogradouro = '".$obj->getEndereco()->getLogradouro()."',
                      PES_EnderecoNumero = '".$obj->getEndereco()->getNumero()."',
                      PES_EnderecoComplemento = '".$obj->getEndereco()->getComplemento()."',
                      PES_EnderecoPontoReferencia = '".$obj->getEndereco()->getPontoReferencia()."',
                      PES_EnderecoBairro = '".$obj->getEndereco()->getBairro()."',
                      PES_EnderecoCidade = '".$obj->getEndereco()->getCidade()."',
                      PES_EnderecoUf = '".$obj->getEndereco()->getUf()."',
                      PES_MaeNome = '".$obj->getMaeNome()."',
                      PES_PaiNome = '".$obj->getPaiNome()."',
                      PES_Observacao = '".$obj->getObservacao()."',
                      PES_ArquivoFoto = '".$obj->getFoto()."',
                      PES_DataFalecimento = ".$strDataFalcimento.",                                            
                      PES_Naturalidade = '".$obj->getNaturalidade()."',
                      PES_Nacionalidade = '".$obj->getNascionalidade()."',
                      PES_Status = '".$obj->getStatus()."', 
                      PES_DataCasamento = ".$strDataCasamento.", 
                      PES_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', 
                      USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"].", PES_QuantidadeFilhos = ".$obj->getQtdFilhos().", 
                      PES_UfNascimento = '".$obj->getUfNascimento()."' ";
                      
            $strSQL.= "WHERE PES_ID = '".$obj->getId()."'";            
            return Db::getInstance()->executar($strSQL);
        }
        
        /*public function excluir(Pessoa $obj){
            $strSQL = "DELETE FROM CAD_PES_PESSOAS WHERE PES_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }*/
    }
?>