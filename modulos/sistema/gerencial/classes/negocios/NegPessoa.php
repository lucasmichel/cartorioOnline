<?php
    // codificação utf-8
    class NegPessoa{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegPessoa();
            }
            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){            
            if(!empty($arrStrFiltros["PES_CPF"])){ 
                $arrStrFiltros["PES_CPF"] = StringHelper::getInstance()->removerCaracteresParaBanco($arrStrFiltros["PES_CPF"]);                
            }
            
            if(!empty($arrStrFiltros["PES_CPF_EDICAO"])){                
                $arrStrFiltros["PES_CPF_EDICAO"] = StringHelper::getInstance()->removerCaracteresParaBanco($arrStrFiltros["PES_CPF_EDICAO"]);
            }
            
            $arrStrDados = RepoPessoa::getInstance()->consultar($arrStrFiltros);            
            $arrObjs     = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI], "Pessoa");
                    }
                }
            }
            return $arrObjs;
        }
        
        public function consultarJSON($arrStrFiltros){
            $arrStrDados = RepoPessoa::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                }
            }

            return $arrObjsRetorno;
        }

        public function factory($arrStrDados, $strClasseFilha){
            $obj = new $strClasseFilha();  
            
            if(isset($arrStrDados["PES_ID"])){
                $obj->setId($arrStrDados["PES_ID"]);
            }
            
            // nível de escolaridade
            $objNivelEscolaridade = new NivelEscolaridade();            
            if(isset($arrStrDados["NES_ID"])){
                if(isset($arrStrDados["NES_ID"])){
                    $objNivelEscolaridade->setId($arrStrDados["NES_ID"]);
                }
            }
            $obj->setNivelEscolaridade($objNivelEscolaridade);
                        
            // estado civil
            $objEstadoCivil = new EstadoCivil();            
            if(isset($arrStrDados["ECV_ID"])){
                if(isset($arrStrDados["ECV_ID"])){
                    $objEstadoCivil->setId($arrStrDados["ECV_ID"]);
                }
            }            
            $obj->setEstadoCivil($objEstadoCivil);
                        
            if(isset($arrStrDados["PES_Matricula"])){                
                $obj->setMatricula($arrStrDados["PES_Matricula"]);
            }            
            if(isset($arrStrDados["PES_CPF"])){
                $obj->setCpf($arrStrDados["PES_CPF"]);
            }            
            if(isset($arrStrDados["PES_RG"])){
                $obj->setRg($arrStrDados["PES_RG"]);
            }
            if(isset($arrStrDados["PES_RGOrgaoEmissao"])){
                $obj->setRgOrgaoEmissor($arrStrDados["PES_RGOrgaoEmissao"]);
            }
            if(isset($arrStrDados["PES_Formacao"])){
                $obj->setFormacao($arrStrDados["PES_Formacao"]);
            }
            if(isset($arrStrDados["PES_Nome"])){
                $obj->setNome($arrStrDados["PES_Nome"]);
            }
            if(isset($arrStrDados["PES_Sexo"])){
                $obj->setSexo($arrStrDados["PES_Sexo"]);
            }
            if(isset($arrStrDados["PES_DataNascimento"])){
                $obj->setDataNascimento($arrStrDados["PES_DataNascimento"]);             
            }
            if(isset($arrStrDados["PES_GrupoSanguineo"])){
                $obj->setGrupoSanguineo($arrStrDados["PES_GrupoSanguineo"]);
            }
            if(isset($arrStrDados["PES_Doador"])){
                $obj->setDoador($arrStrDados["PES_Doador"]);
            }else{
                $obj->setDoador("N");
            }
            
            // endereço
            $objEndereco = new Endereco();
            if(isset($arrStrDados["PES_EnderecoCep"])){
                $objEndereco->setCep($arrStrDados["PES_EnderecoCep"]);
            }            
            if(isset($arrStrDados["PES_EnderecoLogradouro"])){
                $objEndereco->setLogradouro($arrStrDados["PES_EnderecoLogradouro"]);
            }
            if(isset($arrStrDados["PES_EnderecoNumero"])){
                $objEndereco->setNumero($arrStrDados["PES_EnderecoNumero"]);
            }
            if(isset($arrStrDados["PES_EnderecoComplemento"])){
                $objEndereco->setComplemento($arrStrDados["PES_EnderecoComplemento"]);
            }
            if(isset($arrStrDados["PES_EnderecoPontoReferencia"])){
                $objEndereco->setPontoReferencia($arrStrDados["PES_EnderecoPontoReferencia"]);
            }
            if(isset($arrStrDados["PES_EnderecoBairro"])){
                $objEndereco->setBairro($arrStrDados["PES_EnderecoBairro"]);
            }
            if(isset($arrStrDados["PES_EnderecoCidade"])){
                $objEndereco->setCidade($arrStrDados["PES_EnderecoCidade"]);
            }            
            if(isset($arrStrDados["PES_EnderecoUf"])){                
                $objEndereco->setUf($arrStrDados["PES_EnderecoUf"]);
            }
            $obj->setEndereco($objEndereco);
                                    
            if(isset($arrStrDados["PES_MaeNome"])){            
                $obj->setMaeNome($arrStrDados["PES_MaeNome"]);
            }
            if(isset($arrStrDados["PES_PaiNome"])){            
                $obj->setPaiNome($arrStrDados["PES_PaiNome"]);
            }
            if(isset($arrStrDados["PES_Observacao"])){            
                $obj->setObservacao($arrStrDados["PES_Observacao"]);
            }
            if(isset($arrStrDados["PES_ArquivoFoto"])){            
                $obj->setFoto($arrStrDados["PES_ArquivoFoto"]);
            }            
            if(isset($arrStrDados["PES_DataFalecimento"])){                
                $obj->setDataFalecimento($arrStrDados["PES_DataFalecimento"]);                
            }            
            if(isset($arrStrDados["PES_Naturalidade"])){            
                $obj->setNaturalidade($arrStrDados["PES_Naturalidade"]);
            }            
            if(isset($arrStrDados["PES_Nacionalidade"])){            
                $obj->setNascionalidade($arrStrDados["PES_Nacionalidade"]);
            }            
            if(isset($arrStrDados["PES_Status"])){            
                $obj->setStatus($arrStrDados["PES_Status"]);
            }else{
                $obj->setStatus("A");
            }            
            if(isset($arrStrDados["PES_DataCasamento"])){
                $obj->setDataCasamento($arrStrDados["PES_DataCasamento"]);
            }            
            $obj->setQtdFilhos("0");            
            if(isset($arrStrDados["PES_QuantidadeFilhos"])){   
                if(trim($arrStrDados["PES_QuantidadeFilhos"]) != ""){
                    $obj->setQtdFilhos($arrStrDados["PES_QuantidadeFilhos"]);
                }
            }            
            if(isset($arrStrDados["PES_UfNascimento"])){
                $obj->setUfNascimento($arrStrDados["PES_UfNascimento"]);
            }            
            if(isset($arrStrDados["PES_DataHoraAlteracao"])){
                $obj->setDataHoraAlteracao($arrStrDados["PES_DataHoraAlteracao"]);
            }            
            return $obj;
        }
    }
?>