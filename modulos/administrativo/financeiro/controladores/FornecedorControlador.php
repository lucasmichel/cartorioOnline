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
            
            $arrObjs = FachadaFinanceiro::getInstance()->consultarFornecedor($_POST);
            
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){
            
            // guarda a sessão no array $_POST que irá para o negócio
            // e lá será tratado
            if(isset($_SESSION["DADOS_FORNECEDOR"])){
                $_POST["DADOS_FORNECEDOR"] = $_SESSION["DADOS_FORNECEDOR"];                
            }
            if(FachadaFinanceiro::getInstance()->salvarFornecedor($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }elseif($strAcao == "Excluir"){
            if(FachadaFinanceiro::getInstance()->excluirFornecedor($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }        
        }elseif($strAcao == "ConsultarEmailFoneMembro"){
            $arrStrRetorno = array();
            $arrFone = NegPessoaTelefone::getInstance()->consultar($_POST);
            $arrEmail = NegPessoaEmail::getInstance()->consultar($_POST);
            if($arrFone != null){
                $arrFone = $arrFone["objects"];
                $fone = new PessoaTelefone();
                $fone = $arrFone[0];
                $arrStrRetorno["fone"] = $fone->getNumero();
            }else{
                $arrStrRetorno["fone"] = null;
            }
            
            if($arrEmail != null){
                $arrEmail = $arrEmail["objects"];
                $email = new PessoaEmail();
                $email = $arrEmail[0];
                $arrStrRetorno["email"] = $email->getEmail();
            }else{
                $arrStrRetorno["email"] = null;
            }
            
            $arrStrJson["dados"]  = $arrStrRetorno;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            
            
        }
        
        
        
        elseif($strAcao == "AdicionarFone"){                         
            if(!isset($_SESSION["DADOS_FORNECEDOR"]["FONES"])){
                $_SESSION["DADOS_FORNECEDOR"]["FONES"] = array();
                $_SESSION["DADOS_FORNECEDOR"]["FONES_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_FORNECEDOR"]["FONES_NUMERACAO"]++;
            }
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_FORNECEDOR"]["FONES_NUMERACAO"];            
            $arrStrDados["TEL_Operadora"] = trim($_POST["TEL_Operadora"]);
            $arrStrDados["TEL_Numero"] = trim($_POST["TEL_Numero"]);
            $arrStrDados["TEL_NomeContato"] = trim(strtoupper($_POST["TEL_NomeContato"]));
            $_SESSION["DADOS_FORNECEDOR"]["FONES"][] = $arrStrDados;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarFone"){        
            if(isset($_SESSION["DADOS_FORNECEDOR"]["FONES"])){                
                if(count($_SESSION["DADOS_FORNECEDOR"]["FONES"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_FORNECEDOR"]["FONES"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        
        elseif($strAcao == "ExcluirFone"){        
            if(isset($_SESSION["DADOS_FORNECEDOR"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_FORNECEDOR"]["FONES"]); $intI++){
                    if($_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]);                
                        sort($_SESSION["DADOS_FORNECEDOR"]["FONES"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparFone"){        
            if(isset($_SESSION["DADOS_FORNECEDOR"]["FONES"])){
                unset($_SESSION["DADOS_FORNECEDOR"]["FONES"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionFone"){             
            if(isset($_POST["FOR_ID"])){
                $arrFiltroConsultaFone["FOR_ID"] = $_POST["FOR_ID"];
            }
            $arrObjs = FachadaFinanceiro::getInstance()->consultarTelefoneFornecedor($arrFiltroConsultaFone);
            if($arrObjs != null){                
                unset($_SESSION["DADOS_FORNECEDOR"]["FONES"]);                
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
                            $_SESSION["DADOS_FORNECEDOR"]["FONES"][] = $arrStrDados;
                            $_SESSION["DADOS_FORNECEDOR"]["FONES_NUMERACAO"] = $intI+1;                            
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
        elseif($strAcao == "PreencherSessionFoneMembro"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsultaFone["PES_ID"] = $_POST["PES_ID"];
            }
            $arrObjs = FachadaGerencial::getInstance()->consultarTelefonePessoa($arrFiltroConsultaFone);
            if($arrObjs != null){                
                unset($_SESSION["DADOS_FORNECEDOR"]["FONES"]);                
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
                            $_SESSION["DADOS_FORNECEDOR"]["FONES"][] = $arrStrDados;
                            $_SESSION["DADOS_FORNECEDOR"]["FONES_NUMERACAO"] = $intI+1;                            
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
            if(isset($_SESSION["DADOS_FORNECEDOR"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_FORNECEDOR"]["FONES"]); $intI++){                    
                    if($_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){                                         
                        $arrStrDados["ID"] = $_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["ID"];
                        $arrStrDados["TEL_Operadora"] = $_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["TEL_Operadora"];
                        $arrStrDados["TEL_Numero"] = $_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["TEL_Numero"];
                        $arrStrDados["TEL_NomeContato"] = $_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["TEL_NomeContato"];                        
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        
        elseif($strAcao == "SalvarEditarFone"){            
            if(isset($_SESSION["DADOS_FORNECEDOR"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_FORNECEDOR"]["FONES"]); $intI++){                    
                    if($_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){
                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI]["ID"];            
                        $arrStrDados["TEL_Operadora"] = trim($_POST["TEL_Operadora"]);
                        $arrStrDados["TEL_Numero"] = trim($_POST["TEL_Numero"]);
                        $arrStrDados["TEL_NomeContato"] = trim(strtoupper($_POST["TEL_NomeContato"]));
                        $_SESSION["DADOS_FORNECEDOR"]["FONES"][$intI] = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;
                        
                    }
                }
            }            
        }
        
        
        
        
        
        
        
        
        
        

        
        
        
        elseif($strAcao == "AdicionarEmail"){                         
            if(!isset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"])){
                $_SESSION["DADOS_FORNECEDOR"]["EMAILS"] = array();
                $_SESSION["DADOS_FORNECEDOR"]["EMAILS_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_FORNECEDOR"]["EMAILS_NUMERACAO"]++;
            }            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_FORNECEDOR"]["EMAILS_NUMERACAO"];            
            $arrStrDados["EMA_Email"] = trim(strtoupper($_POST["EMA_Email"]));            
            $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][] = $arrStrDados;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarEmails"){        
            if(isset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"])){                
                if(count($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_FORNECEDOR"]["EMAILS"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        
        elseif($strAcao == "ExcluirEmail"){        
            if(isset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]); $intI++){
                    if($_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]);                
                        sort($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparEmail"){        
            if(isset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"])){
                unset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionEmails"){             
            if(isset($_POST["FOR_ID"])){
                $arrFiltroConsultaEmail["FOR_ID"] = $_POST["FOR_ID"];
            }
            $arrObjs = FachadaFinanceiro::getInstance()->consultarEmailFornecedor($arrFiltroConsultaEmail);
            if($arrObjs != null){                
                unset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]);                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"];                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objEmail = new PessoaEmail();
                            $objEmail = $arrObjs[$intI];                                     
                            $arrStrDados["ID"] = $intI+1;
                            $arrStrDados["EMA_Email"] = $objEmail->getEmail();
                            $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][] = $arrStrDados;
                            $_SESSION["DADOS_FORNECEDOR"]["EMAILS_NUMERACAO"] = $intI+1;
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
        elseif($strAcao == "PreencherSessionEmailsMembro"){             
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsultaEmail["PES_ID"] = $_POST["PES_ID"];
            }
            $arrObjs = FachadaGerencial::getInstance()->consultarEmailPessoa($arrFiltroConsultaEmail);
            if($arrObjs != null){                
                unset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]);                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"];                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objEmail = new PessoaEmail();
                            $objEmail = $arrObjs[$intI];                                     
                            $arrStrDados["ID"] = $intI+1;
                            $arrStrDados["EMA_Email"] = $objEmail->getEmail();
                            $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][] = $arrStrDados;
                            $_SESSION["DADOS_FORNECEDOR"]["EMAILS_NUMERACAO"] = $intI+1;
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
            if(isset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]); $intI++){                    
                    if($_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]["ID"];
                        $arrStrDados["EMA_Email"] = $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]["EMA_Email"];
                        $arrStrJson["rows"]   = $arrStrDados;
                        $arrStrJson["sucesso"]  = "true";        
                        $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                        break;;
                    }
                }
            }            
        }
        
        elseif($strAcao == "SalvarEditarEmail"){            
            if(isset($_SESSION["DADOS_FORNECEDOR"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_FORNECEDOR"]["EMAILS"]); $intI++){                    
                    if($_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                        
                        $arrStrDados["ID"] = $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI]["ID"];            
                        $arrStrDados["EMA_Email"] = trim(strtoupper($_POST["EMA_Email"]));
                        $_SESSION["DADOS_FORNECEDOR"]["EMAILS"][$intI] = $arrStrDados;
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
?>