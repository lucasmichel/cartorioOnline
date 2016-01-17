<?php
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    
    // variáveis utilizadas neste arquivo
    // estas variáveis são padrões do sistema
    $arrStrJson            = null;
    $arrStrJson["sucesso"] = "false";  
    $strAcao               = $_POST["ACO_Descricao"]; // requisições recebidas pela interface
    
    // caso seja retornado uma exceção esta flag deve ser alterada
    // para true. Dessa forma o sistema o sistema exibirá a div correspondente
    // a exceção, será uma DIV diferente do padrão.
    $arrStrJson["excecao"] = "false";      
    
    try{
        if($strAcao == "Consultar"){            
            if(isset($_POST["pesquisarPor"])){
                if($_POST["pesquisarPor"] == "nome"){
                    $_POST["PES_Nome"] = $_POST["pesquisarCampo"];
                }
                if($_POST["pesquisarPor"] == "cpf"){
                    $_POST["PES_CPF"] = $_POST["pesquisarCampo"];
                }
                if($_POST["pesquisarPor"] == "matricula"){
                    $_POST["PES_Matricula"] = $_POST["pesquisarCampo"];
                }   
            }
            $arrObjs = FachadaCadastro::getInstance()->consultarMembro($_POST);
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){  
            // guarda a sessão no array $_POST que irá para o negócio
            // e lá será tratado
            if(isset($_SESSION["DADOS_MEMBRO"])){
                $_POST["DADOS_MEMBRO"] = $_SESSION["DADOS_MEMBRO"];                
            }
            if(FachadaCadastro::getInstance()->salvarMembro($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }        
        elseif($strAcao == "ConsultarProfissoes"){               
            $arrObjs = FachadaGerencial::getInstance()->consultarAreaAtuacaoProfissional($_POST);
            if($arrObjs != null){    
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }        
        }        
        elseif($strAcao == "ConsultarCPFCadastro"){            
            $arrObjs = FachadaGerencial::getInstance()->consultarPessoa($_POST);
            if($arrObjs == null){    
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }
        
        elseif($strAcao == "ConsultarAtividades"){               
            $arrObjs = FachadaCadastro::getInstance()->consultarAtividadeMembro($_POST);
            if($arrObjs != null){    
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }        
        }
        
        elseif($strAcao == "AdicionarAtividade"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"])){
                $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"] = array();
                $_SESSION["DADOS_MEMBRO"]["ATIVIDADES_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["ATIVIDADES_NUMERACAO"]++;
            }
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES_NUMERACAO"];            
            $arrStrDados["ATV_ID"] = $_POST["ATV_ID"];
            $arrStrDados["ATV_Descricao"] = $_POST["ATV_Descricao"];
            $arrStrDados["ATM_Desde"] = trim($_POST["ATM_Desde"]);
            $arrStrDados["ATM_Ate"] = trim($_POST["ATM_Ate"]);            
            
            $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][] = $arrStrDados;            
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarAtividade"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
    
        elseif($strAcao == "ExcluirAividade"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparAtividade"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"])){
                unset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "PreencherSessionAtividade"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsulta["PES_ID"] = $_POST["PES_ID"];                
            }
            
            $arrObjs = FachadaCadastro::getInstance()->consultarAtividadeMembro($arrFiltroConsulta); 
            
            if($arrObjs != null){                
                unset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]); 
                
                $arrObjAtividade = array();
                $arrObjAtividade = $arrObjs["objects"];
                
                for($intI = 0; $intI<count($arrObjAtividade); $intI++){                    
                    $obj = new AtividadeMembro();
                    $obj = $arrObjAtividade[$intI];                    
                    $arrStrDados["ID"] = $intI+1;            
                    $arrStrDados["ATV_ID"] = $obj->getAtividade()->getId();
                    $arrStrDados["ATV_Descricao"] = $obj->getAtividade()->getDescricao();
                    $arrStrDados["ATM_Desde"] = $obj->getDataDesde();
                    $arrStrDados["ATM_Ate"] = $obj->getDataAte();
                    $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][] = $arrStrDados;
                    $_SESSION["DADOS_MEMBRO"]["ATIVIDADES_NUMERACAO"] = $intI+1;
                }    
                
                $arrStrJson["sucesso"]  = "true";        
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }
        
        elseif($strAcao == "BuscarAtividade"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ID"] == trim($_POST["ID"])){                                                                 
                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ID"];                        
                        $arrStrDados["ATV_ID"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ATV_ID"];
                        $arrStrDados["ATV_Descricao"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ATV_Descricao"];
                        $arrStrDados["ATM_Desde"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ATM_Desde"];
                        $arrStrDados["ATM_Ate"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ATM_Ate"];
                        
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        elseif($strAcao == "SalvarEditarAtividade"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI]["ID"];                        
                        $arrStrDados["ATV_ID"] = trim($_POST["ATV_ID"]);
                        $arrStrDados["ATV_Descricao"] = trim(strtoupper($_POST["ATV_Descricao"]));
                        $arrStrDados["ATM_Desde"] = trim($_POST["ATM_Desde"]);
                        $arrStrDados["ATM_Ate"] = trim($_POST["ATM_Ate"]);                        
                        $_SESSION["DADOS_MEMBRO"]["ATIVIDADES"][$intI] = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;
                        
                    }
                }
            }            
        }
        
        
        
        
        
        
        
        
        
        
        
        elseif($strAcao == "AdicionarEclesiastico"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"])){
                $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"] = array();
                $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO_NUMERACAO"]++;
            }
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO_NUMERACAO"];            
            $arrStrDados["DAM_Data"] = trim($_POST["DAM_Data"]);
            $arrStrDados["DAM_DataAceito"] = trim($_POST["DAM_DataAceito"]);
            $arrStrDados["DAM_IgrejaNome"] = trim(strtoupper($_POST["DAM_IgrejaNome"]));
            $arrStrDados["DAM_IgrejaCidade"] = trim(strtoupper($_POST["DAM_IgrejaCidade"]) );
            $arrStrDados["DAM_IgrejaUf"] = trim(strtoupper($_POST["DAM_IgrejaUf"]) );
            $arrStrDados["DAM_IgrejaPastor"] = trim(strtoupper($_POST["DAM_IgrejaPastor"]));
            $arrStrDados["DAM_Ano"] = trim($_POST["DAM_Ano"]);
            $arrStrDados["DAM_Tipo"] = trim(strtoupper($_POST["DAM_Tipo"]));
            $arrStrDados["DAM_NumeroAta"] = trim(strtoupper($_POST["DAM_NumeroAta"]));            
            $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][] = $arrStrDados;
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        elseif($strAcao == "ListarEclesiastico"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        elseif($strAcao == "ExcluirEclesiastico"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]);
                        break;
                    }
                }
            }
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        elseif($strAcao == "LimparEclesiastico"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"])){
                unset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]);                
            } 
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        elseif($strAcao == "PreencherSessionEclesiastico"){  
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsulta["PES_ID"] = $_POST["PES_ID"];                
            }
            $arrObjs = FachadaCadastro::getInstance()->consultarDadosEclesiasticos($arrFiltroConsulta);            
            if($arrObjs != null){                
                unset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]); // garante que sempre irá iniciar zerado                
                $arrObjEcle = $arrObjs["objects"];
                for($intI = 0; $intI<count($arrObjEcle); $intI++){                    
                    $obj = new DadosEclesiasticos();
                    $obj = $arrObjEcle[$intI];
                    
                    $arrStrDados["ID"] = $intI+1;                                             
                    $arrStrDados["DAM_Data"] = $obj->getData();
                    $arrStrDados["DAM_DataAceito"] = $obj->getDataAceito();
                    $arrStrDados["DAM_IgrejaNome"] = $obj->getIgrejaNome();
                    $arrStrDados["DAM_IgrejaCidade"] = $obj->getIgrejaCidade();
                    $arrStrDados["DAM_IgrejaUf"] = $obj->getIgrejaUf();
                    $arrStrDados["DAM_IgrejaPastor"] = $obj->getIgrejaPastor();
                    $arrStrDados["DAM_Ano"] = $obj->getAno();
                    $arrStrDados["DAM_Tipo"] = $obj->getTipo();
                    $arrStrDados["DAM_NumeroAta"] = $obj->getNumeroAta();
                    $arrStrDados["DAM_Ano"] = $obj->getAno();
                    
                    $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][] = $arrStrDados;
                    $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO_NUMERACAO"] = $intI+1;                    
                }
                $arrStrJson["sucesso"]  = "true";        
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }
        
        elseif($strAcao == "BuscarDadoEclesiastico"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["ID"] == trim($_POST["ID"])){                                         
                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["ID"];
                        $arrStrDados["DAM_Data"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_Data"];
                        $arrStrDados["DAM_DataAceito"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_DataAceito"];
                        $arrStrDados["DAM_IgrejaNome"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_IgrejaNome"];
                        $arrStrDados["DAM_IgrejaCidade"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_IgrejaCidade"];
                        $arrStrDados["DAM_IgrejaUf"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_IgrejaUf"];
                        $arrStrDados["DAM_IgrejaPastor"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_IgrejaPastor"];                        
                        $arrStrDados["DAM_Ano"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_Ano"];
                        $arrStrDados["DAM_Tipo"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_Tipo"];
                        $arrStrDados["DAM_NumeroAta"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_NumeroAta"];
                        $arrStrDados["DAM_Ano"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["DAM_Ano"];
                        
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        
        elseif($strAcao == "SalvarEditarDadoEclesiastico"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI]["ID"];                        
                        $arrStrDados["DAM_Data"] = trim($_POST["DAM_Data"]);
                        $arrStrDados["DAM_DataAceito"] = trim($_POST["DAM_DataAceito"]);
                        $arrStrDados["DAM_IgrejaNome"] = trim(strtoupper($_POST["DAM_IgrejaNome"]));
                        $arrStrDados["DAM_IgrejaCidade"] = trim(strtoupper($_POST["DAM_IgrejaCidade"]));
                        $arrStrDados["DAM_IgrejaUf"] = trim(strtoupper($_POST["DAM_IgrejaUf"]));
                        $arrStrDados["DAM_IgrejaPastor"] = trim(strtoupper($_POST["DAM_IgrejaPastor"]));
                        $arrStrDados["DAM_Ano"] = trim($_POST["DAM_Ano"]);
                        $arrStrDados["DAM_Tipo"] = trim(strtoupper($_POST["DAM_Tipo"]));
                        $arrStrDados["DAM_NumeroAta"] = trim(strtoupper($_POST["DAM_NumeroAta"]));
                        $arrStrDados["DAM_Ano"] = trim($_POST["DAM_Ano"]);                        
                        $_SESSION["DADOS_MEMBRO"]["ECLESIASTICO"][$intI] = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;
                        
                    }
                }
            }            
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        elseif($strAcao == "AdicionarFamiliar"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"])){
                $_SESSION["DADOS_MEMBRO"]["FAMILIARES"] = array();
                $_SESSION["DADOS_MEMBRO"]["FAMILIARES_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["FAMILIARES_NUMERACAO"]++;
            }
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["FAMILIARES_NUMERACAO"];            
            $arrStrDados["PES_Secundario_ID"] = $_POST["PES_Secundario_ID"];            
            $arrStrDados["FAM_GrauParentesco"] = trim($_POST["FAM_GrauParentesco"]);            
            $arrStrDados["PES_Nome_Secundario"] =  mb_strtoupper(trim($_POST["PES_Nome_Secundario"]), 'UTF-8');
            $_SESSION["DADOS_MEMBRO"]["FAMILIARES"][] = $arrStrDados;
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "ListarFamiliar"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["FAMILIARES"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }elseif($strAcao == "ExcluirFamiliar"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["FAMILIARES"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "LimparFamiliar"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"])){
                unset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "PreencherSessionFamiliar"){ 
            $arrFiltroConsulta = array();
            
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsulta["PES_Primario_ID"] = $_POST["PES_ID"];
            }
            
            $arrObjs = FachadaCadastro::getInstance()->consultarFamiliaMembro($arrFiltroConsulta);
            
            if($arrObjs != null){
                unset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]); // garante que sempre começará vazio
                $arrObjs = $arrObjs["objects"];
                                
                for($intI = 0; $intI<count($arrObjs); $intI++){  
                    $arrStrDados["ID"] = $intI+1;            
                    $arrStrDados["PES_Secundario_ID"] = $arrObjs[$intI]->getPessoaSecundarioId();
                    $arrStrDados["PES_Nome_Secundario"] = $arrObjs[$intI]->getPessoaSecundarioNome();
                    $arrStrDados["FAM_GrauParentesco"] = $arrObjs[$intI]->getGrauParentesco();                   
                    
                    // controle da sessão
                    $_SESSION["DADOS_MEMBRO"]["FAMILIARES"][] = $arrStrDados;
                    $_SESSION["DADOS_MEMBRO"]["FAMILIARES_NUMERACAO"] = $intI+1;
                }
                
                $arrStrJson["sucesso"]  = "true";        
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }elseif($strAcao == "ConsultarFamilia"){ 
            $arrFiltroConsulta = array();
            
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsulta["PES_Primario_ID"] = $_POST["PES_ID"];
            }
            
            $arrObjs = FachadaCadastro::getInstance()->consultarFamiliaMembro($arrFiltroConsulta);
            
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }
        elseif($strAcao == "validarRelacionamentoFamiliar"){            
            if($_POST["FAM_GrauParentesco"] == "CÔNJUGE"){
                //VERIFICA SE JÁ TEM CONJUGE
                if(FachadaCadastro::getInstance()->validarRelacionamentoFamiliar($_POST)){                
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }else{                
                if($_POST["FAM_GrauParentesco"] == "MÃE"){                    
                    //VERIFICA SE JA TEM MÃE
                    if(isset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"])){                        
                        for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]); $intI++){
                            if($_SESSION["DADOS_MEMBRO"]["FAMILIARES"][$intI]["FAM_GrauParentesco"] == "MÃE"){                                 
                                throw new Exception ("Já existe uma mãe adicionada");
                            }
                        }
                    }            
                } 
                if ($_POST["FAM_GrauParentesco"] == "PAI"){
                    //VERIFICA SE JA TEM PAI
                    if(isset($_SESSION["DADOS_MEMBRO"]["FAMILIARES"])){
                        for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["FAMILIARES"]); $intI++){
                            if($_SESSION["DADOS_MEMBRO"]["FAMILIARES"][$intI]["FAM_GrauParentesco"] == "PAI"){
                                throw new Exception ("Já existe um pai adicionado");
                            }
                        }
                    }
                }                
                $arrStrJson["sucesso"]  = "true";        
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();                                
            }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        elseif($strAcao == "AdicionarFone"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["FONES"])){
                $_SESSION["DADOS_MEMBRO"]["FONES"] = array();
                $_SESSION["DADOS_MEMBRO"]["FONES_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["FONES_NUMERACAO"]++;
            }
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["FONES_NUMERACAO"];            
            $arrStrDados["TEL_Operadora"] = trim($_POST["TEL_Operadora"]);
            $arrStrDados["TEL_Numero"] = trim($_POST["TEL_Numero"]);
            $arrStrDados["TEL_NomeContato"] = trim(strtoupper($_POST["TEL_NomeContato"]));
            $_SESSION["DADOS_MEMBRO"]["FONES"][] = $arrStrDados;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarFone"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["FONES"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["FONES"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["FONES"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        
        elseif($strAcao == "ExcluirFone"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["FONES"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["FONES"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["FONES"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparFone"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["FONES"])){
                unset($_SESSION["DADOS_MEMBRO"]["FONES"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionFone"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsultaFone["PES_ID"] = $_POST["PES_ID"];
            }
            $arrObjs = FachadaGerencial::getInstance()->consultarTelefonePessoa($arrFiltroConsultaFone);
            if($arrObjs != null){                
                unset($_SESSION["DADOS_MEMBRO"]["FONES"]);                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"];                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objFone = new PessoaTelefone();
                            $objFone = $arrObjs[$intI];                                     
                            $arrStrDados["ID"] = $intI+1;
                            $arrStrDados["TEL_Operadora"] = $objFone->getOperadora();
                            $arrStrDados["TEL_Numero"] = $objFone->getNumero();
                            $arrStrDados["TEL_NomeContato"] = $objFone->getContato();
                            $_SESSION["DADOS_MEMBRO"]["FONES"][] = $arrStrDados;
                            $_SESSION["DADOS_MEMBRO"]["FONES_NUMERACAO"] = $intI+1;                            
                        }
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();                        
                    }else{
                        $arrStrJson["sucesso"]  = "false";
                    }
                }else{
                    $arrStrJson["sucesso"]  = "false";
                }
            }
        }
        
        
        elseif($strAcao == "BuscarFone"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["FONES"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){                                         
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["ID"];
                        $arrStrDados["TEL_Operadora"] = $_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["TEL_Operadora"];
                        $arrStrDados["TEL_Numero"] = $_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["TEL_Numero"];
                        $arrStrDados["TEL_NomeContato"] = $_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["TEL_NomeContato"];                        
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        
        elseif($strAcao == "SalvarEditarFone"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["FONES"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){
                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["FONES"][$intI]["ID"];            
                        $arrStrDados["TEL_Operadora"] = trim($_POST["TEL_Operadora"]);
                        $arrStrDados["TEL_Numero"] = trim($_POST["TEL_Numero"]);
                        $arrStrDados["TEL_NomeContato"] = trim(strtoupper($_POST["TEL_NomeContato"]));
                        $_SESSION["DADOS_MEMBRO"]["FONES"][$intI] = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;
                        
                    }
                }
            }            
        }
        
        
        
        
        
        
        
        
        
        

        
        
        
        elseif($strAcao == "AdicionarEmail"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["EMAILS"])){
                $_SESSION["DADOS_MEMBRO"]["EMAILS"] = array();
                $_SESSION["DADOS_MEMBRO"]["EMAILS_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["EMAILS_NUMERACAO"]++;
            }            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["EMAILS_NUMERACAO"];            
            $arrStrDados["EMA_Email"] = trim(strtoupper($_POST["EMA_Email"]));            
            $_SESSION["DADOS_MEMBRO"]["EMAILS"][] = $arrStrDados;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarEmails"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["EMAILS"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["EMAILS"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["EMAILS"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        
        elseif($strAcao == "ExcluirEmail"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["EMAILS"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["EMAILS"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparEmail"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["EMAILS"])){
                unset($_SESSION["DADOS_MEMBRO"]["EMAILS"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionEmails"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsultaEmail["PES_ID"] = $_POST["PES_ID"];
            }
            $arrObjs = FachadaGerencial::getInstance()->consultarEmailPessoa($arrFiltroConsultaEmail);
            if($arrObjs != null){                
                unset($_SESSION["DADOS_MEMBRO"]["EMAILS"]);                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"];                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objEmail = new PessoaEmail();
                            $objEmail = $arrObjs[$intI];                                     
                            $arrStrDados["ID"] = $intI+1;
                            $arrStrDados["EMA_Email"] = $objEmail->getEmail();
                            $_SESSION["DADOS_MEMBRO"]["EMAILS"][] = $arrStrDados;
                            $_SESSION["DADOS_MEMBRO"]["EMAILS_NUMERACAO"] = $intI+1;
                        }                
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();                        
                    }else{
                        $arrStrJson["sucesso"]  = "false";
                    }
                }else{
                    $arrStrJson["sucesso"]  = "false";
                }
            }
        }
        
        
        elseif($strAcao == "BuscarEmail"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["EMAILS"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]["ID"];
                        $arrStrDados["EMA_Email"] = $_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]["EMA_Email"];
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        elseif($strAcao == "SalvarEditarEmail"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["EMAILS"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI]["ID"];            
                        $arrStrDados["EMA_Email"] = trim(strtoupper($_POST["EMA_Email"]));
                        $_SESSION["DADOS_MEMBRO"]["EMAILS"][$intI] = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;
                        
                    }
                }
            }
            
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        elseif($strAcao == "AdicionarProcessoDesligamento"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"])){
                $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"] = array();
                $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO_NUMERACAO"]++;
            }  
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO_NUMERACAO"];
            $arrStrDados["PCD_Data"] = trim(strtoupper($_POST["PCD_Data"])); 
            $arrStrDados["PCD_Descricao"] = trim(strtoupper($_POST["PCD_Descricao"]));            
            $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"][] = $arrStrDados;
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "ListarProcessoDesligamento"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]) > 0){
                    $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"] = array_values(ordenarArrayPorData($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]));
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }elseif($strAcao == "ExcluirProcessoDesligamento"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]);
                        break;
                    }
                }
            }
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "LimparProcessoDesligamento"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"])){
                unset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]);                
            }  
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }elseif($strAcao == "PreencherSessionProcessoDesligamento"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsultaEmail["PES_ID"] = $_POST["PES_ID"];
            }
            
            $arrObjs = FachadaCadastro::getInstance()->consultarMotivoDesligamentoMembro($arrFiltroConsultaEmail);
            
            if($arrObjs != null){                
                unset($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]); 
                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"]; 
                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objMotivoDesligamento = new MotivosDesligamentoMembro();
                            $objMotivoDesligamento = $arrObjs[$intI];
                                                        
                            $arrStrDados = array();
                            $arrStrDados["ID"] = $intI+1;                            
                            $arrStrDados["PCD_Data"] = $objMotivoDesligamento->getData();
                            $arrStrDados["PCD_Descricao"] = $objMotivoDesligamento->getDescricao();
                            
                            $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"][] = $arrStrDados;
                            $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO_NUMERACAO"] = $intI+1;
                        }                
                        
                        // $_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"] = array_values(ordenarArrayPorData($_SESSION["DADOS_MEMBRO"]["DESLIGAMENTO"]));                        
                        
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();                        
                    }else{
                        $arrStrJson["sucesso"]  = "false";
                    }
                }else{
                    $arrStrJson["sucesso"]  = "false";
                }
            }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        elseif($strAcao == "AdicionarMinisterio"){                         
            if(!isset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"])){
                $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"] = array();
                $_SESSION["DADOS_MEMBRO"]["MINISTERIOS_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_MEMBRO"]["MINISTERIOS_NUMERACAO"]++;
            }
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS_NUMERACAO"];            
            $arrStrDados["MIN_ID"] = $_POST["MIN_ID"];
            $arrStrDados["MIN_Descricao"] = $_POST["MIN_Descricao"];
            $arrStrDados["MMI_Desde"] = trim($_POST["MMI_Desde"]);
            $arrStrDados["MMI_Ate"] = trim($_POST["MMI_Ate"]);                        
            $arrStrDados["AMI_ID"] = trim($_POST["AMI_ID"]);            
            $arrStrDados["AMI_Descricao"] = trim($_POST["AMI_Descricao"]);            
            
            $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][] = $arrStrDados;            
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarMinisterio"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"])){                
                if(count($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
    
        elseif($strAcao == "ExcluirMinisterio"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]); $intI++){
                    if($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]);                
                        sort($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparMinisterio"){        
            if(isset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"])){
                unset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionMinisterio"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsulta["PES_ID"] = $_POST["PES_ID"];                
            }
            $arrObjs = FachadaCadastro::getInstance()->consultarMembroMinisterio($arrFiltroConsulta);            
            if($arrObjs != null){                
                unset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]); 
                $arrObjMinisterio = array();
                $arrObjMinisterio = $arrObjs["objects"];
                
                for($intI = 0; $intI<count($arrObjMinisterio); $intI++){                    
                    $obj = new MembroMinisterio();
                    $obj = $arrObjMinisterio[$intI];                    
                    $arrStrDados["ID"] = $intI+1;            
                    $arrStrDados["MIN_ID"] = $obj->getMinisterio()->getId();
                    $arrStrDados["MIN_Descricao"] = $obj->getMinisterio()->getDescricao();
                    $arrStrDados["MMI_Desde"] = $obj->getDataDesde();
                    $arrStrDados["MMI_Ate"] = $obj->getDataAte();
                    
                    if($obj->getMinisterio()->getObjAreaMinisterial()->getId() > 0){
                        $arrStrDados["AMI_ID"] = $obj->getMinisterio()->getObjAreaMinisterial()->getId();
                        $arrStrDados["AMI_Descricao"] = $obj->getMinisterio()->getObjAreaMinisterial()->getDescricao();            
                    }else{
                        $arrStrDados["AMI_ID"] = 0;
                        $arrStrDados["AMI_Descricao"] = "";            
                    }
                    $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][] = $arrStrDados;
                    $_SESSION["DADOS_MEMBRO"]["MINISTERIOS_NUMERACAO"] = $intI+1;
                }    
                
                $arrStrJson["sucesso"]  = "true";        
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }
        
        elseif($strAcao == "BuscarMinisterio"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["ID"] == trim($_POST["ID"])){                                                                 
                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["ID"];                        
                        $arrStrDados["MIN_ID"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["MIN_ID"];
                        $arrStrDados["MIN_Descricao"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["MIN_Descricao"];
                        $arrStrDados["MMI_Desde"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["MMI_Desde"];
                        $arrStrDados["MMI_Ate"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["MMI_Ate"];
                        
                        $arrStrDados["AMI_ID"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["AMI_ID"];
                        $arrStrDados["AMI_Descricao"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["AMI_Descricao"];
                        
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        elseif($strAcao == "SalvarEditarMinisterio"){            
            if(isset($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"]); $intI++){                    
                    if($_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI]["ID"];                        
                        $arrStrDados["MIN_ID"] = trim($_POST["MIN_ID"]);
                        $arrStrDados["MIN_Descricao"] = trim(strtoupper($_POST["MIN_Descricao"]));
                        $arrStrDados["MMI_Desde"] = trim($_POST["MMI_Desde"]);
                        $arrStrDados["MMI_Ate"] = trim($_POST["MMI_Ate"]);
                        $arrStrDados["AMI_ID"] = trim($_POST["AMI_ID"]); 
                        $arrStrDados["AMI_Descricao"] = trim($_POST["AMI_Descricao"]);                         
                        $_SESSION["DADOS_MEMBRO"]["MINISTERIOS"][$intI] = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;
                        
                    }
                }
            }            
        }
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
    
    function ordenarArrayPorData($arrayDados){        
        if(uasort($arrayDados, function($a, $b){
            $format = 'd/m/Y'; 
            $ascending = false;
            $zone = new DateTimeZone('UTC');
            $d1 = DateTime::createFromFormat($format, $a["PCD_Data"], $zone)->getTimestamp();
            $d2 = DateTime::createFromFormat($format, $b["PCD_Data"], $zone)->getTimestamp();
            return $ascending ? ($d1 - $d2) : ($d2 - $d1);
        })){
            return $arrayDados;
        }
        
    }    
?>