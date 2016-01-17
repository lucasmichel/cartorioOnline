<?php
    // codificação utf-8
    class NegFuncionario{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFuncionario();
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
            
            $arrStrDados = RepoFuncionario::getInstance()->consultar($arrStrFiltros);   
            
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        /*para repassar os dados formatados*/
                        $arrStrDados[$intI]["PES_CPF"] = DocumentacaoHelper::getInstance()->formatarCPFCNPJ($arrObjs[$intI]->getCPF());
                        $arrObjs[$intI]->setCPF($arrStrDados[$intI]["PES_CPF"]);
                        
                        $arrStrDados[$intI]["FUN_Salario"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["FUN_Salario"]);                        
                        $arrObjs[$intI]->setSalario($arrStrDados[$intI]["FUN_Salario"]);
                        
                        $arrStrDados[$intI]["FUN_DataAdmissao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["FUN_DataAdmissao"]);  
                        $arrObjs[$intI]->setDataAdmissao($arrStrDados[$intI]["FUN_DataAdmissao"]); 
                        
                        $arrStrDados[$intI]["FUN_DataSaida"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["FUN_DataSaida"]);  
                        $arrObjs[$intI]->setDataSaida($arrStrDados[$intI]["FUN_DataSaida"]); 
                        
                        $arrStrDados[$intI]["PES_DataNascimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataNascimento"]);                        
                        $arrObjs[$intI]->setDataNascimento($arrStrDados[$intI]["PES_DataNascimento"]);
                        
                        $arrStrDados[$intI]["PES_DataFalecimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataFalecimento"]);  
                        $arrObjs[$intI]->setDataFalecimento($arrStrDados[$intI]["PES_DataFalecimento"]);
                        
                        // resgata os telefones do funcionário
                        $foneConsulta["PES_ID"] = $arrStrDados[$intI]["PES_ID"];                        
                        $arrDadosFone = NegPessoaTelefone::getInstance()->consultar($foneConsulta);
                        
                        if($arrDadosFone != null){
                            if(count($arrDadosFone) > 0){
                                $arrDadosFone = $arrDadosFone["objects"];

                                $foneRes = null;
                                $foneCel = null;
                                
                                if(isset($arrDadosFone[1])){
                                    $foneRes = new PessoaTelefone();
                                    $foneRes = $arrDadosFone[1];
                                }

                                if(isset($arrDadosFone[0])){
                                    $foneCel = new PessoaTelefone();
                                    $foneCel = $arrDadosFone[0];
                                }

                                $arrStrDados[$intI]["PES_TelefoneResidencial"] = "";
                                $arrStrDados[$intI]["PES_TelefoneCelular"] = ""; 
                                
                                if($foneRes != null){
                                    $arrStrDados[$intI]["PES_TelefoneResidencial"] = $foneRes->getNumero();
                                }
                                
                                if($foneCel != null){
                                    $arrStrDados[$intI]["PES_TelefoneCelular"] = $foneCel->getNumero(); 
                                }
                            }
                        }
                        
                        // resgata os emails do funcionário
                        $emailConsulta["PES_ID"] = $arrStrDados[$intI]["PES_ID"];                        
                        $arrDadosEma = NegPessoaEmail::getInstance()->consultar($emailConsulta);
                        
                        if($arrDadosEma != null){
                            if(count($arrDadosEma) > 0){
                                $arrDadosEma = $arrDadosEma["objects"] ;

                                $email1 = null;
                                $email2 = null;
                                
                                if(isset($arrDadosEma[1])){
                                    $email1 = new PessoaEmail();
                                    $email1 = $arrDadosEma[1];
                                }

                                if(isset($arrDadosEma[0])){
                                    $email2 = new PessoaEmail();
                                    $email2 = $arrDadosEma[0];
                                }

                                if($email1 != null){
                                    $arrStrDados[$intI]["PES_EmailPrimario"] = $email1->getEmail();
                                }
                                
                                if($email2 != null){
                                    $arrStrDados[$intI]["PES_EmailSecundario"] = $email2->getEmail();
                                }
                            }
                           
                        }                        
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados; 
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFuncionario::getInstance()->consultar($arrStrFiltros);                     
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            
            return $arrObjsRetorno;
        }

        protected function factory($arrStrDados){            
            $obj = NegPessoa::getInstance()->factory($arrStrDados, "Funcionario");  
                        
            // MEMBRO
            $objMembro = new Membro();            
            if(!empty($arrStrDados["PES_Membro_ID"])){
                $objMembro->setId($arrStrDados["PES_Membro_ID"]);
                $obj->setMembroFuncionario($objMembro);
            }else{
                $obj->setMembroFuncionario(null);
            }
                        
            if(!empty($arrStrDados["FUN_Funcao"])){
                $obj->setFuncao($arrStrDados["FUN_Funcao"]);
            }
            
            if(!empty($arrStrDados["FUN_CargaHoraria"])){
                $obj->setCargaHoraria($arrStrDados["FUN_CargaHoraria"]);
            }else{
                $obj->setCargaHoraria(0);
            }
            if(!empty($arrStrDados["FUN_HorarioEntrada"])){
                $obj->setHorarioEntrada($arrStrDados["FUN_HorarioEntrada"]);
            }
            if(!empty($arrStrDados["FUN_HorarioSaida"])){
                $obj->setHorarioSaida($arrStrDados["FUN_HorarioSaida"]);
            }
            if(!empty($arrStrDados["FUN_CNHNumero"])){
                $obj->setCnhNumero($arrStrDados["FUN_CNHNumero"]);
            }
            if(!empty($arrStrDados["FUN_CarteiraTrabalhoNumero"])){
                $obj->setCarteiraTrabalhoNumero($arrStrDados["FUN_CarteiraTrabalhoNumero"]);
            }            
            return $obj;
        }
        
        public function salvar($arrStrDados){  
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if(isset($arrStrDados["PES_CPF"])){
                $obj->setCPF(StringHelper::getInstance()->removerCaracteresParaBanco($arrStrDados["PES_CPF"]));
            }
            
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
            
            if(isset($arrStrDados["PES_DataNascimento"])){
                $obj->setDataNascimento(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PES_DataNascimento"]));
            }
            
            if(isset($arrStrDados["PES_DataFalecimento"])){
                $obj->setDataFalecimento(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PES_DataFalecimento"]));
            }
            
            if(isset($arrStrDados["FUN_DataAdmissao"])){
                $obj->setDataAdmissao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["FUN_DataAdmissao"]));
            }
            
            if(isset($arrStrDados["FUN_DataSaida"])){
                $obj->setDataSaida(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["FUN_DataSaida"]));
            }
            
            $obj->setSalario(0);
            
            if(isset($arrStrDados["FUN_Salario"])){                
                $obj->setSalario(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["FUN_Salario"]));                    
            }
            
            $foto = "";
            //conserva a foto pra não passar pra maiuscula
            if(isset($arrStrDados["PES_ArquivoFoto"])){
                $foto = $arrStrDados["PES_ArquivoFoto"];
            }
            $obj->setFoto($foto);
            
            if($obj->getId() == ""){                
                // se vier PES_Membro_ID utilizar ele no id de membro e setar o id de funcionario                 
                if($obj->getMembroFuncionario() != null){                    
                    $obj->setIdFuncionario($obj->getMembroFuncionario()->getId());
                    
                    //passa o id e salva o funcionario
                    if (RepoFuncionario::getInstance()->salvar($obj) == false){
                        return false;
                    }else{
                        return true;
                    }
                }else{                    
                    //se não vier PES_Membro_ID então salva a pessoa e o funcionario                    
                    $idNovaPessoa = RepoPessoa::getInstance()->salvar($obj);
                    
                    if($idNovaPessoa > 0){
                        $obj->setIdFuncionario($idNovaPessoa);
                        
                        if ( RepoFuncionario::getInstance()->salvar($obj)){
                            if(isset($arrStrDados["PES_TelefoneResidencial"])){       
                                if($arrStrDados["PES_TelefoneResidencial"] != ""){
                                    $foneRes["PES_ID"] = $idNovaPessoa;                                 
                                    $foneRes["TEL_Numero"] = $arrStrDados["PES_TelefoneResidencial"];                                 
                                    NegPessoaTelefone::getInstance()->salvar($foneRes);
                                }
                            }

                            if(isset($arrStrDados["PES_TelefoneCelular"])){
                                if($arrStrDados["PES_TelefoneCelular"] != ""){
                                    $foneCel["PES_ID"] = $idNovaPessoa;                                 
                                    $foneCel["TEL_Numero"] = $arrStrDados["PES_TelefoneCelular"];                                 
                                    NegPessoaTelefone::getInstance()->salvar($foneCel);
                                }
                            }
                            
                            
                            if(isset($arrStrDados["PES_EmailPrimario"])){
                                if($arrStrDados["PES_EmailPrimario"] != ""){
                                    $emailPrim["PES_ID"] = $idNovaPessoa;                                 
                                    $emailPrim["EMA_Email"] = $arrStrDados["PES_EmailPrimario"];                                 
                                    NegPessoaEmail::getInstance()->salvar($emailPrim);
                                }
                            }
                            
                            if(isset($arrStrDados["PES_EmailSecundario"])){
                                if($arrStrDados["PES_EmailSecundario"] != ""){
                                    $emailSec["PES_ID"] = $idNovaPessoa;                                 
                                    $emailSec["EMA_Email"] = $arrStrDados["PES_EmailSecundario"];                                 
                                    NegPessoaEmail::getInstance()->salvar($emailSec);
                                }
                            }
                               
                            
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }                
            }else{                 
                // editar                
                if($obj->getMembroFuncionario() != null){//edita se for um funcionario membro
                    $obj->setIdFuncionario($obj->getMembroFuncionario()->getId());
                    //passa o id e salva o funcionario
                    if (RepoFuncionario::getInstance()->alterar($obj) == false){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    //edita se funcionario deixar ou não de ser membro
                    
                    //verifica se é um funcionario com pessoa ou um funcionario que era um membro
                    
                    $arrStrFiltros["PES_ID"] = $obj->getId();                    
                    $arrOBJ = $this->consultar($arrStrFiltros);                    
                    //se vier objeto MembroFuncionario então tem que cadastrar uma nova pessoa se não altera o que ja tiver
                    if($arrOBJ["objects"][0]->getMembroFuncionario() != null){
                        //cadastra nova pessoa                        
                        $idNovaPessoa = RepoPessoa::getInstance()->salvar($obj);                
                        if($idNovaPessoa > 0){
                            $obj->setIdFuncionario($idNovaPessoa);
                            if (RepoFuncionario::getInstance()->alterar($obj) == false){
                                return false;
                            }else{
                                
                                
                                //exclui os Telefones
                                $arrDadosExcluirFone["PES_ID"] = $obj->getId();
                                NegPessoaTelefone::getInstance()->excluir($arrDadosExcluirFone);
                                //salva os que estão vindo novamente   
                                
                                if(isset($arrStrDados["PES_TelefoneResidencial"])){                                
                                    if($arrStrDados["PES_TelefoneResidencial"] != ""){
                                        $foneRes["PES_ID"] = $obj->getId();
                                        $foneRes["TEL_Numero"] = $arrStrDados["PES_TelefoneResidencial"];                                 
                                        NegPessoaTelefone::getInstance()->salvar($foneRes);
                                    }
                                }

                                if(isset($arrStrDados["PES_TelefoneCelular"])){                                
                                    if($arrStrDados["PES_TelefoneCelular"] != ""){
                                        $foneCel["PES_ID"] = $obj->getId();
                                        $foneCel["TEL_Numero"] = $arrStrDados["PES_TelefoneCelular"];                                 
                                        NegPessoaTelefone::getInstance()->salvar($foneCel);
                                    }
                                }
                                //
                                
                                
                                
                                //exclui os Emails
                                $arrDadosExcluirEmails["PES_ID"] = $obj->getId();                
                                NegPessoaEmail::getInstance()->excluir($arrDadosExcluirEmails);
                                //salva os que estão vindo novamente  
                                if(isset($arrStrDados["PES_EmailPrimario"])){
                                    if($arrStrDados["PES_EmailPrimario"] != ""){
                                        $emailPrim["PES_ID"] = $obj->getId();
                                        $emailPrim["EMA_Email"] = $arrStrDados["PES_EmailPrimario"];                                 
                                        NegPessoaEmail::getInstance()->salvar($emailPrim);
                                    }
                                }

                                if(isset($arrStrDados["PES_EmailSecundario"])){
                                    if($arrStrDados["PES_EmailSecundario"] != ""){
                                        $emailSec["PES_ID"] = $obj->getId();
                                        $emailSec["EMA_Email"] = $arrStrDados["PES_EmailSecundario"];                                 
                                        NegPessoaEmail::getInstance()->salvar($emailSec);
                                    }
                                }
                                //
                                
                                return true;
                            }
                        }else{
                            return false;
                        }
                        
                    }else{                        
                        //altera
                        
                        if(RepoPessoa::getInstance()->alterar($obj)){                     
                            $obj->setIdFuncionario($obj->getId());
                            if (RepoFuncionario::getInstance()->alterar($obj) == false){
                                return false;
                            }else{
                                
                                 //exclui os Telefones
                                $arrDadosExcluirFone["PES_ID"] = $obj->getId();
                                NegPessoaTelefone::getInstance()->excluir($arrDadosExcluirFone);
                                //salva os que estão vindo novamente                
                                if($arrStrDados["PES_TelefoneResidencial"] != ""){
                                    $foneRes["PES_ID"] = $obj->getId();                                 
                                    $foneRes["TEL_Numero"] = $arrStrDados["PES_TelefoneResidencial"];                                 
                                    NegPessoaTelefone::getInstance()->salvar($foneRes);
                                }

                                if($arrStrDados["PES_TelefoneCelular"] != ""){
                                    $foneCel["PES_ID"] = $obj->getId();                                 
                                    $foneCel["TEL_Numero"] = $arrStrDados["PES_TelefoneCelular"];                                 
                                    NegPessoaTelefone::getInstance()->salvar($foneCel);
                                }
                                //
                                
                                
                                
                                //exclui os Emails
                                $arrDadosExcluirEmails["PES_ID"] = $obj->getId();                
                                NegPessoaEmail::getInstance()->excluir($arrDadosExcluirEmails);
                                //salva os que estão vindo novamente                
                                if($arrStrDados["PES_EmailPrimario"] != ""){
                                    $emailPrim["PES_ID"] = $obj->getId();
                                    $emailPrim["EMA_Email"] = $arrStrDados["PES_EmailPrimario"];                                 
                                    NegPessoaEmail::getInstance()->salvar($emailPrim);
                                }

                                if($arrStrDados["PES_EmailSecundario"] != ""){
                                    $emailSec["PES_ID"] = $obj->getId();
                                    $emailSec["EMA_Email"] = $arrStrDados["PES_EmailSecundario"];                                 
                                    NegPessoaEmail::getInstance()->salvar($emailSec);
                                }
                                //
                                
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                }
            }
        }
        
        
        /*public function excluir($arrStrDados){            
            $obj = new Funcionario();
            $obj->setId($arrStrDados["PES_ID"]);
            
            $arrDadosExcluirEmails["PES_ID"] = $obj->getId();                
            NegPessoaEmail::getInstance()->excluir($arrDadosExcluirEmails);
            
            $arrDadosExcluirFone["PES_ID"] = $obj->getId();
            NegPessoaTelefone::getInstance()->excluir($arrDadosExcluirFone);
                    
            RepoFuncionario::getInstance()->excluir($obj);
            
            return RepoPessoa::getInstance()->excluir($obj);
        }*/
        
    }
?>
