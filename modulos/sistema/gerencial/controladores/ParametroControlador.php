<?php
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../inc/seguranca.inc.php");
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
            $arrObjs = FachadaGerencial::getInstance()->consultarParametro($_POST);
             
            if($arrObjs != null){
                
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = 1;
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"])){
                $_POST["DADOS_PARAMETRO_SISTEMA"] = $_SESSION["DADOS_PARAMETRO_SISTEMA"];
            }
            if(FachadaGerencial::getInstance()->salvarParametro($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }
        
        
        
        elseif($strAcao == "AdicionarFone"){                         
            if(!isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"])){
                $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"] = array();
                $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES_NUMERACAO"]++;
            }
            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES_NUMERACAO"];            
            $arrStrDados["PART_Numero"] = trim($_POST["PART_Numero"]);
            $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"][] = $arrStrDados;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarFone"){        
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"])){                
                if(count($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        
        elseif($strAcao == "ExcluirFone"){        
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"])){
                for($intI=0; $intI<count($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"]); $intI++){
                    if($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"][$intI]);                
                        sort($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparFone"){        
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"])){
                unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionFone"){                         
            $arrObjs = FachadaGerencial::getInstance()->consultarTelefoneParametro();
            if($arrObjs != null){                
                unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"]);                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"];                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objFone = new ParametroFone();
                            $objFone = $arrObjs[$intI];                                     
                            $arrStrDados["ID"] = $intI+1;                            
                            $arrStrDados["PART_Numero"] = $objFone->getFone();                            
                            $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES"][] = $arrStrDados;
                            $_SESSION["DADOS_PARAMETRO_SISTEMA"]["FONES_NUMERACAO"] = $intI+1;                            
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
        
        
        
        
        
        
        
        

        
        
        
        elseif($strAcao == "AdicionarEmail"){                         
            if(!isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"])){
                $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"] = array();
                $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS_NUMERACAO"] = 1; //responsável por definir o ID do registro na sessão
            }else{
                $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS_NUMERACAO"]++;
            }            
            $arrStrDados = array();
            $arrStrDados["ID"] = $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS_NUMERACAO"];            
            $arrStrDados["PARE_EMAILS"] = trim($_POST["PARE_EMAILS"]);            
            $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"][] = $arrStrDados;
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "ListarEmails"){        
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"])){                
                if(count($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"]) > 0){
                    $arrStrJson["rows"]     = $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"];
                    $arrStrJson["sucesso"]  = "true";        
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }
        }
        
        elseif($strAcao == "ExcluirEmail"){        
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"])){
                for($intI=0; $intI<count($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"]); $intI++){
                    if($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"][$intI]["ID"] == trim($_POST["ID"])){                 
                        unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"][$intI]);                
                        sort($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"]);
                        break;
                    }
                }
            }
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "LimparEmail"){        
            if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"])){
                unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"]);                
            }            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();        
        }
        
        elseif($strAcao == "PreencherSessionEmails"){            
            $arrObjs = FachadaGerencial::getInstance()->consultarEmailParametro();
            if($arrObjs != null){                
                unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"]);                
                if($arrObjs != null){                    
                    $arrObjs = $arrObjs["objects"];                    
                    if(count($arrObjs) > 0){
                        for($intI = 0; $intI<count($arrObjs); $intI++){                                                
                            $objEmail = new ParametroEmail();
                            $objEmail = $arrObjs[$intI];                                     
                            $arrStrDados["ID"] = $intI+1;
                            $arrStrDados["PARE_EMAILS"] = $objEmail->getEmail();
                            $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS"][] = $arrStrDados;
                            $_SESSION["DADOS_PARAMETRO_SISTEMA"]["EMAILS_NUMERACAO"] = $intI+1;
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
        }elseif($strAcao == "GerarCabecalho"){
            include("../inc/cabecalho-impressao.inc.php");
            exit;
        }
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>