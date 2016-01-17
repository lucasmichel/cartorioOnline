<?php
    // codificação utf-8
    class NegMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegMembro();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            if(isset($arrStrFiltros["PES_CPF"])){                        
                $arrStrFiltros["PES_CPF"] = StringHelper::getInstance()->removerCaracteresParaBanco($arrStrFiltros["PES_CPF"]);            
            }
            if(isset($arrStrFiltros["PES_CPF_EDICAO"])){                        
                $arrStrFiltros["PES_CPF_EDICAO"] = StringHelper::getInstance()->removerCaracteresParaBanco($arrStrFiltros["PES_CPF_EDICAO"]);            
            }            
            $arrStrDados = RepoMembro::getInstance()->consultar($arrStrFiltros);  
                        
            $arrObjsRetorno = null;
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);   
                        
                        /*para repassar os dados formatados*/
                        if(isset($arrStrDados[$intI]["PES_CPF"])){
                            $arrStrDados[$intI]["PES_CPF"] = DocumentacaoHelper::getInstance()->formatarCPFCNPJ($arrObjs[$intI]->getCPF());
                            $arrObjs[$intI]->setCPF($arrStrDados[$intI]["PES_CPF"]);
                        }
                        
                        if(isset($arrStrDados[$intI]["PES_DataNascimento"])){
                            $arrStrDados[$intI]["PES_DataNascimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataNascimento"]);                        
                            $arrObjs[$intI]->setDataNascimento($arrStrDados[$intI]["PES_DataNascimento"]);
                        }
                        
                        if(isset($arrStrDados[$intI]["MEM_DataInativacao"])){
                            if(trim($arrStrDados[$intI]["MEM_DataInativacao"]) != ""){
                                $arrStrDados[$intI]["MEM_DataInativacao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["MEM_DataInativacao"]);                        
                                $arrObjs[$intI]->setDataInativacao($arrStrDados[$intI]["MEM_DataInativacao"]);
                            }
                        }
                        
                        if(isset($arrStrDados[$intI]["MEM_DataDescricaoInativacao"])){
                            if(trim($arrStrDados[$intI]["MEM_DataDescricaoInativacao"]) != ""){
                                $arrStrDados[$intI]["MEM_DataDescricaoInativacao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["MEM_DataDescricaoInativacao"]);                        
                                $arrObjs[$intI]->setDataDescricaoInativacao($arrStrDados[$intI]["MEM_DataDescricaoInativacao"]);
                            }
                        }
                        //retorna a idade..
                        $arrStrDados[$intI]["PES_Idade"] = $arrObjs[$intI]->getIdade();
                        
                        //retorna o status de atualização do membro..                        
                        $arrStrDados[$intI]["PES_StatusAtualizacao"] = $arrObjs[$intI]->getStatusAtualizacao();
                        
                        //BUSCA A DATA DE BATISMO
                        $arrfiltrodadoEcle["PES_ID"] = $arrObjs[$intI]->getId();
                        $arrfiltrodadoEcle["DAM_Tipo"] = "BATISMO";
                        $arrObjEcle = NegDadosEclesiasticos::getInstance()->consultar($arrfiltrodadoEcle);
                        if($arrObjEcle != null){
                            $arrObjEcle = $arrObjEcle["objects"];
                            $objDadoEcle = new DadosEclesiasticos();
                            $objDadoEcle = $arrObjEcle[0];
                            //$arrStrDados[$intI]["DAM_Data"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($objDadoEcle->getData());
                            $arrStrDados[$intI]["DAM_Data"] = $objDadoEcle->getData();
                            
                        }else{
                            $arrStrDados[$intI]["DAM_Data"] = "";
                        }
                        //BUSCA A DATA DE BATISMO                       
                        
                        if(isset($arrStrDados[$intI]["PES_DataFalecimento"])){
                            $arrStrDados[$intI]["PES_DataFalecimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataFalecimento"]);  
                            $arrObjs[$intI]->setDataFalecimento($arrStrDados[$intI]["PES_DataFalecimento"]);
                        }
                        
                        if(isset($arrStrDados[$intI]["PES_DataCasamento"])){
                            $arrStrDados[$intI]["PES_DataCasamento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataCasamento"]);                        
                            $arrObjs[$intI]->setDataCasamento($arrStrDados[$intI]["PES_DataCasamento"]);
                        }
                        //se vier PES_MesAniversario formata o nome pro formato correto
                        if(isset($arrStrFiltros["PES_MesAniversario"])){                            
                            $arrObjs[$intI]->setNome(StringHelper::getInstance()->normalizarNome($arrStrDados[$intI]["PES_Nome"]));
                        }
                        
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados; 
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoMembro::getInstance()->consultar($arrStrFiltros);                     
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                    
                }
            }            
            return $arrObjsRetorno;
        }

        protected function factory($arrStrDados){
            $obj = NegPessoa::getInstance()->factory($arrStrDados, "Membro"); 
            
            // ÁREA DE ATUAÇÃO
            $objAreaAtuacao = new AreaAtuacao();            
            if(isset($arrStrDados["AAT_ID"])){                
                $objAreaAtuacao->setId($arrStrDados["AAT_ID"]);
            }                
            if(isset($arrStrDados["AAT_Descricao"])){
                $objAreaAtuacao->setDescricao($arrStrDados["AAT_Descricao"]);
            }
            if(isset($arrStrDados["AAT_Status"])){
                $objAreaAtuacao->setStatus($arrStrDados["AAT_Status"]);
            }                       
            $obj->setAreaDeAtuacao($objAreaAtuacao);
                        
            // STATUS DO MEMBRO
            $objStatusMembro = new StatusMembro();            
            if(isset($arrStrDados["MES_ID"])){
                $objStatusMembro->setId($arrStrDados["MES_ID"]);
                
                if(isset($arrStrDados["MES_Descricao"])){
                    $objStatusMembro->setDescricao($arrStrDados["MES_Descricao"]);
                }
            }
            $obj->setStatusMembro($objStatusMembro);            
            
            // congregacao
            $objCongregacao = new Congregacao();
            if(isset($arrStrDados["UNI_ID"])){
                $objCongregacao->setId($arrStrDados["UNI_ID"]);                
                if(isset($arrStrDados["UNI_Descricao"])){
                    $objCongregacao->setDescricao($arrStrDados["UNI_Descricao"]);
                }else{
                    $objCongregacao->setDescricao("SEDE");
                }
            }else{
                $objCongregacao->setDescricao("SEDE");
            }
            $obj->setCongregacao($objCongregacao);            
                        
            // RENDA SALARIAL
            $objRendaSalarial = new RendaSalario();
            if(isset($arrStrDados["ARS_ID"])){
                $objRendaSalarial->setId($arrStrDados["ARS_ID"]);
                
                if(isset($arrStrDados["ARS_Descricao"])){
                    $objRendaSalarial->setDescricao($arrStrDados["ARS_Descricao"]);
                }                
            }
            $obj->setRendaSalario($objRendaSalarial);            
                        
            if(isset($arrStrDados["MEM_EmpresaNome"])){
                $obj->setEmpresaNome($arrStrDados["MEM_EmpresaNome"]);
            }
            if(isset($arrStrDados["MEM_EmpresaTelefoneComercial"])){
                $obj->setEmpresaTelefoneComercial($arrStrDados["MEM_EmpresaTelefoneComercial"]);
            }
            if(isset($arrStrDados["MEM_EmpresaTelefoneFax"])){
                $obj->setEmpresaTelefoneFax($arrStrDados["MEM_EmpresaTelefoneFax"]);
            }
            
            // ENDEREÇO MEMBRO
            $objEnderecoEmpresa = new Endereco();
            if(isset($arrStrDados["MEM_EmpresaEnderecoCep"])){
                $objEnderecoEmpresa->setCep($arrStrDados["MEM_EmpresaEnderecoCep"]);
            }            
            if(isset($arrStrDados["MEM_EmpresaEnderecoLogradouro"])){
                $objEnderecoEmpresa->setLogradouro($arrStrDados["MEM_EmpresaEnderecoLogradouro"]);
            }
            if(isset($arrStrDados["MEM_EmpresaEnderecoNumero"])){
                $objEnderecoEmpresa->setNumero($arrStrDados["MEM_EmpresaEnderecoNumero"]);
            }
            if(isset($arrStrDados["MEM_EmpresaEnderecoComplemento"])){
                $objEnderecoEmpresa->setComplemento($arrStrDados["MEM_EmpresaEnderecoComplemento"]);
            }
            if(isset($arrStrDados["MEM_EmpresaEnderecoPontoReferencia"])){
                $objEnderecoEmpresa->setPontoReferencia($arrStrDados["MEM_EmpresaEnderecoPontoReferencia"]);
            }
            if(isset($arrStrDados["MEM_EmpresaEnderecoBairro"])){
                $objEnderecoEmpresa->setBairro($arrStrDados["MEM_EmpresaEnderecoBairro"]);
            }                        
            if(isset($arrStrDados["MEM_EmpresaEnderecoCidade"])){
                $objEnderecoEmpresa->setCidade($arrStrDados["MEM_EmpresaEnderecoCidade"]);
            }            
            if(isset($arrStrDados["MEM_EmpresaEnderecoUf"])){
                $objEnderecoEmpresa->setUf($arrStrDados["MEM_EmpresaEnderecoUf"]);   
            }                    
            $obj->setEnderecoEmpresa($objEnderecoEmpresa);
            
            if(isset($arrStrDados["MEM_TemEmprego"])){
                $obj->setTemEmprego($arrStrDados["MEM_TemEmprego"]);
            }else{
                $obj->setTemEmprego("N");
            }
            
            if(isset($arrStrDados["MEM_Profissao"])){
                $obj->setProfissao($arrStrDados["MEM_Profissao"]);
            }
            
            if(isset($arrStrDados["MEM_NumeroFicha"])){
                $obj->setNumeroFicha($arrStrDados["MEM_NumeroFicha"]);
            }
            
            if(isset($arrStrDados["MEM_Tipo"])){
                $obj->setTipo($arrStrDados["MEM_Tipo"]);
            }
            
            
            // inativação
            if(isset($arrStrDados["PES_Falecimento"])){
                if(isset($arrStrDados["MEM_DataInativacao"])){
                    $obj->setDataInativacao($arrStrDados["MEM_DataInativacao"]);
                }
                if(isset($arrStrDados["MEM_MotivoInativacao"])){
                    $obj->setMotivoInativacao($arrStrDados["MEM_MotivoInativacao"]);
                }
                if(isset($arrStrDados["MEM_DescricaoInativacao"])){
                    $obj->setDescricaoInativacao($arrStrDados["MEM_DescricaoInativacao"]);
                }
                if(isset($arrStrDados["MEM_DataDescricaoInativacao"])){
                    $obj->setDataDescricaoInativacao($arrStrDados["MEM_DataDescricaoInativacao"]);
                }
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
             
            $obj->setCPF(StringHelper::getInstance()->removerCaracteresParaBanco($arrStrDados["PES_CPF"]));
            
            // verifica se já existe uma matrícula para 
            // o membro, se existir o sistema não gera
            // só irá gerar se não existir
            if(trim($obj->getMatricula()) == ""){                    
                $dataAtual = Date("Y-m-d H:m:s");
                $strAno    = substr($dataAtual, 0, 4);
                $intMes    = (int) substr($dataAtual, 5, 2);

                if($intMes<= 06){
                    $strSimestre = "1";
                }else{
                    $strSimestre = "2";
                }

                // gera a hora em milissegundos
                $m = explode(' ',microtime());
                list($totalSeconds, $extraMilliseconds) =  array($m[1], (int)round($m[0]*1000,3));
                $datHora = date("H:i:s", $totalSeconds) . ":$extraMilliseconds";
                
                //retira a pontuação da hora
                $strHoraSemPontuacao = str_replace(":", "", $datHora);
                
                // concatena pra gerar a matricula       
                $strMatricula = $strAno.".".$strSimestre.".".$strHoraSemPontuacao;
                $obj->setMatricula($strMatricula);                    
            }
            
            // conserva a string da foto
            // para que não seja convertida para maúscula
            $obj->setFoto($arrStrDados["PES_ArquivoFoto"]);
            $obj->setDataNascimento(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PES_DataNascimento"]));
                       
            // conversão de datas não obrigatórias
            if(isset($arrStrDados["PES_DataCasamento"])){
                if(trim($arrStrDados["PES_DataCasamento"]) != ""){
                    $obj->setDataCasamento(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PES_DataCasamento"]));
                }
            }
            
            if(isset($arrStrDados["MEM_DataConversao"])){
                if(trim($arrStrDados["MEM_DataConversao"]) != ""){
                    $obj->setDataConversao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MEM_DataConversao"]));
                }
            }
            
            if(isset($arrStrDados["MEM_DataReconciliacao"])){
                if(trim($arrStrDados["MEM_DataReconciliacao"]) != ""){
                    $obj->setDataReconciliacao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MEM_DataReconciliacao"]));
                }
            }
            
            if(isset($arrStrDados["MEM_DataBatismo"])){
                if(trim($arrStrDados["MEM_DataBatismo"]) != ""){
                    $obj->setDataBatismo(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MEM_DataBatismo"]));
                }
            }
            
            if(isset($arrStrDados["PES_DataFalecimento"])){
                $obj->setDataFalecimento(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PES_DataFalecimento"]));
            }
            
            if(isset($arrStrDados["PES_Falecimento"])){
                if(isset($arrStrDados["MEM_DataInativacao"])){
                    if(trim($arrStrDados["MEM_DataInativacao"]) != ""){
                        $obj->setDataInativacao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MEM_DataInativacao"]));
                    }
                }
                if(isset($arrStrDados["MEM_DataDescricaoInativacao"])){
                    if(trim($arrStrDados["MEM_DataDescricaoInativacao"]) != ""){
                        $obj->setDataDescricaoInativacao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MEM_DataDescricaoInativacao"]));
                    }
                }
            }
            
            if($obj->getId() == ""){
                $intPessoaID = RepoPessoa::getInstance()->salvar($obj);                
                if($intPessoaID > 0){
                    // guarda o id da pessoa
                    $obj->setId($intPessoaID);                    
                    if (!RepoMembro::getInstance()->salvar($obj)){                    
                        return false;
                    }else{
                         // grava os familiares
                         if(isset($arrStrDados["DADOS_MEMBRO"]["FAMILIARES"])){
                             if(count($arrStrDados["DADOS_MEMBRO"]["FAMILIARES"]) > 0){
                                foreach ($arrStrDados["DADOS_MEMBRO"]["FAMILIARES"] as $arrStrFamilia) {
                                    $arrStrFamilia["PES_Primario_ID"] = $intPessoaID;
                                    NegFamilia::getInstance()->salvar($arrStrFamilia);
                                }
                             }
                         }    
                         // grava as atividades
                         if(isset($arrStrDados["DADOS_MEMBRO"]["ATIVIDADES"])){
                             if(count($arrStrDados["DADOS_MEMBRO"]["ATIVIDADES"]) > 0){
                                foreach ($arrStrDados["DADOS_MEMBRO"]["ATIVIDADES"] as $arrStrAtividade) {
                                    $arrStrAtividade["PES_ID"] = $intPessoaID;
                                    $arrStrAtividade["ATM_Status"] = "A";
                                    NegAtividadeMembro::getInstance()->salvar($arrStrAtividade);
                                }
                             }
                         }
                         
                         // grava os dados eclesiásticos
                        if(isset($arrStrDados["DADOS_MEMBRO"]["ECLESIASTICO"])){
                            if(count($arrStrDados["DADOS_MEMBRO"]["ECLESIASTICO"]) > 0){                                
                                foreach ($arrStrDados["DADOS_MEMBRO"]["ECLESIASTICO"] as $arrStrEcle) {
                                    $arrStrEcle["PES_ID"] = $intPessoaID;                                 
                                    NegDadosEclesiasticos::getInstance()->salvar($arrStrEcle);
                                }
                            }
                        }
                         
                        // grava os telefones
                        if(isset($arrStrDados["DADOS_MEMBRO"]["FONES"])){
                            if(count($arrStrDados["DADOS_MEMBRO"]["FONES"]) > 0){
                                foreach ($arrStrDados["DADOS_MEMBRO"]["FONES"] as $arrStrFone) {
                                    $arrStrFone["PES_ID"] = $intPessoaID;                                 
                                    NegPessoaTelefone::getInstance()->salvar($arrStrFone);
                                }
                            }
                        }
                         
                        // grava os e-mails
                        if(isset($arrStrDados["DADOS_MEMBRO"]["EMAILS"])){
                            if(count($arrStrDados["DADOS_MEMBRO"]["EMAILS"]) > 0){
                                foreach ($arrStrDados["DADOS_MEMBRO"]["EMAILS"] as $arrStrEmail) {
                                    $arrStrEmail["PES_ID"] = $intPessoaID;                                 
                                    NegPessoaEmail::getInstance()->salvar($arrStrEmail);
                                }
                            }
                        }
                         
                        // grava os processos de desligamento
                        if(isset($arrStrDados["DADOS_MEMBRO"]["DESLIGAMENTO"])){
                            if(count($arrStrDados["DADOS_MEMBRO"]["DESLIGAMENTO"]) > 0){
                                foreach ($arrStrDados["DADOS_MEMBRO"]["DESLIGAMENTO"] as $arrStrDesligamento) {
                                    $arrStrDesligamento["PES_ID"] = $intPessoaID;                                 
                                    NegMotivosDesligamentoMembro::getInstance()->salvar($arrStrDesligamento);
                                }
                            }
                        }
                        
                        // grava os ministérios
                        if(isset($arrStrDados["DADOS_MEMBRO"]["MINISTERIOS"])){
                            if(count($arrStrDados["DADOS_MEMBRO"]["MINISTERIOS"]) > 0){
                                foreach ($arrStrDados["DADOS_MEMBRO"]["MINISTERIOS"] as $arrStrMinisterio) {
                                    $arrStrMinisterio["PES_ID"] = $intPessoaID;                                 
                                    NegMembroMinisterio::getInstance()->salvar($arrStrMinisterio);
                                }
                            }
                        }
                        
                        return true;
                    }
                }else{
                    return false;
                }
            }else{                
                // exclui as atividades
                $arrDadosExcluirAtividade["PES_ID"] = $obj->getId();
                NegAtividadeMembro::getInstance()->excluir($arrDadosExcluirAtividade); 
                
                // salva os que estão vindo novamente
                if(isset($arrStrDados["DADOS_MEMBRO"]["ATIVIDADES"])){
                    foreach ($arrStrDados["DADOS_MEMBRO"]["ATIVIDADES"] as $atividade) {
                        $atividade["PES_ID"] = $obj->getId();                        
                        NegAtividadeMembro::getInstance()->salvar($atividade);
                    }
                }  
                
                //exclui os familiares
                $arrDadosExcluirFamiliares["PES_Primario_ID"] = $obj->getId();
                NegFamilia::getInstance()->excluir($arrDadosExcluirFamiliares); 
                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_MEMBRO"]["FAMILIARES"])){
                    foreach ($arrStrDados["DADOS_MEMBRO"]["FAMILIARES"] as $familia) {
                        $familia["PES_Primario_ID"] = $obj->getId();                        
                        NegFamilia::getInstance()->salvar($familia);
                    }
                }
                
                //exclui os dados eclesiasticos
                $arrDadosExcluirEclesiastico["PES_ID"] = $obj->getId();
                NegDadosEclesiasticos::getInstance()->excluir($arrDadosExcluirEclesiastico);                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_MEMBRO"]["ECLESIASTICO"])){                    
                    foreach ($arrStrDados["DADOS_MEMBRO"]["ECLESIASTICO"] as $ecle) {
                        $ecle["PES_ID"] = $obj->getId();                        
                        NegDadosEclesiasticos::getInstance()->salvar($ecle);
                    }
                }
                
                //exclui os Telefones
                $arrDadosExcluirFone["PES_ID"] = $obj->getId();
                NegPessoaTelefone::getInstance()->excluir($arrDadosExcluirFone);
                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_MEMBRO"]["FONES"])){
                    foreach ($arrStrDados["DADOS_MEMBRO"]["FONES"] as $fone) {
                        $fone["PES_ID"] = $obj->getId();
                        NegPessoaTelefone::getInstance()->salvar($fone);
                    }
                }
                
                
                //exclui os Emails
                $arrDadosExcluirEmails["PES_ID"] = $obj->getId();                
                NegPessoaEmail::getInstance()->excluir($arrDadosExcluirEmails);
                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_MEMBRO"]["EMAILS"])){
                    foreach ($arrStrDados["DADOS_MEMBRO"]["EMAILS"] as $email) {
                        $email["PES_ID"] = $obj->getId();                                              
                        NegPessoaEmail::getInstance()->salvar($email);
                    }
                }
                                
                //exclui os processo de desligamento
                $arrDadosExcluirDesligamento["PES_ID"] = $obj->getId();                
                NegMotivosDesligamentoMembro::getInstance()->excluir($arrDadosExcluirDesligamento);
                
                //salva os que estão vindo novamente                
                if(isset($arrStrDados["DADOS_MEMBRO"]["DESLIGAMENTO"])){
                    foreach ($arrStrDados["DADOS_MEMBRO"]["DESLIGAMENTO"] as $desligamento) {
                        $desligamento["PES_ID"] = $obj->getId();                                              
                        NegMotivosDesligamentoMembro::getInstance()->salvar($desligamento);
                    }
                }
                
                // exclui os ministérios    
                $arrDadosExcluirMinisterio["PES_ID"] = $obj->getId();
                NegMembroMinisterio::getInstance()->excluir($arrDadosExcluirMinisterio); 
                
                // salva os que estão vindo novamente
                if(isset($arrStrDados["DADOS_MEMBRO"]["MINISTERIOS"])){
                    foreach ($arrStrDados["DADOS_MEMBRO"]["MINISTERIOS"] as $ministerio) {
                        $ministerio["PES_ID"] = $obj->getId();                        
                        NegMembroMinisterio::getInstance()->salvar($ministerio);
                    }
                }
                
                if(RepoPessoa::getInstance()->alterar($obj)){                         
                    if (RepoMembro::getInstance()->alterar($obj) == false){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
            }
        }
    }
?>
