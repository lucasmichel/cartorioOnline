<?php
    // codificação utf-8 
    session_start();
    include("../../../../inc/config.inc.php");    
    include("../inc/autoload.inc.php");
    
    // configurações de memória e tempo de execução
    set_time_limit(0);
    ini_set("memory_limit", "256M");
    ini_set("max_execution_time", "1000");

    // variáveis utilizadas neste arquivo
    // estas variáveis são padrões do sistema
    $arrStrJson            = null;
    $arrStrJson["sucesso"] = "false";
    
    // caso seja retornado uma exceção esta flag deve ser alterada
    // para true. Dessa forma o sistema o sistema exibirá a div correspondente
    // a exceção, será uma DIV diferente do padrão.
    $arrStrJson["excecao"] = "false"; 
    
    try{
        // a ação deve vir antes do permissões.inc
        // para que se possa, quando necessário, verificar se o
        // usuário tem permissão ou não
        $strAcao = $_POST["ACO_Descricao"];
        
        if($strAcao == "ChecarAcesso"){        
            if ((!empty($_POST["USU_Login"])) && (!empty($_POST["USU_Senha"]))){
                $arrStrFiltros              = array();
                $arrStrFiltros["USU_Login"] = SegurancaHelper::getInstance()->removerSQLInjection(trim($_POST["USU_Login"]));
                $arrStrFiltros["USU_Senha"] = SegurancaHelper::getInstance()->removerSQLInjection(trim(md5($_POST["USU_Senha"])));
                
                $arrObjs = FachadaGerencial::getInstance()->consultarUsuario($arrStrFiltros);
                $arrObjs = $arrObjs["objects"];
                
                if($arrObjs != null){
                    if(count($arrObjs) > 0){
                        $arrStrJson["sucesso"] = "true";
                        
                        // preenche a sessão de segurança
                        $_SESSION["ACESSOPERMITIDO"]         = "TRUE";
                        $_SESSION["USUARIO_ID"]              = $arrObjs[0]->getId();
                        $_SESSION["USUARIO_LOGIN"]           = $arrObjs[0]->getLogin();
                        $_SESSION["USUARIO_ULTIMOACESSO"]    = $arrObjs[0]->getDataHoraUltimoAcesso();                    
                        
                        // registrando o acesso do usuário                        
                        $arrStrDadosAcesso                 = array();
                        $arrStrDadosAcesso["USU_ID"]       = $arrObjs[0]->getId();
                        $arrStrDadosAcesso["USA_DataHora"] = date("Y-m-d H:i:s");
                        FachadaGerencial::getInstance()->registrarAcessoUsuario($arrStrDadosAcesso);
                        
                        // verificando se o usuário é um membro
                        // caso seja um mebro o sistema pega o nome do membro
                        // para posteriomente exibí-lo na tela
                        $arrStrFiltrosPessoa = array();
                        $arrStrFiltrosPessoa["USU_Sistema_ID"] = $arrObjs[0]->getId();

                        $_SESSION["USUARIO_NOME"] = $arrObjs[0]->getLogin();
                        
                        
                        /*$arrObjs = FachadaGerencial::getInstance()->consultarPessoa($arrStrFiltrosPessoa);

                        if($arrObjs != null){
                            if(count($arrObjs) > 0){
                                $_SESSION["USUARIO_NOME"] = $arrObjs[0]->getNome();
                            }
                        }*/
                    }
                }else{
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getUsuarioSenhaInvalido();
                }
            }
        }else{            
            if($strAcao == "Consultar"){                
                $arrObjs = FachadaGerencial::getInstance()->consultarUsuario($_POST);
                
                if($arrObjs != null){
                    if(count($arrObjs) > 0){
                        $arrStrJson["rows"]     = $arrObjs["rows"];
                        $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                        $arrStrJson["sucesso"]  = "true";
                    }
                }
            }elseif($strAcao == "VerificarSenha"){   
                
                $arrStrFiltros["USU_ID"] = $_POST["USU_ID"];
                $arrStrFiltros["USU_Senha"] = md5($_POST["USU_Senha"]);
                $arrObjs = FachadaGerencial::getInstance()->consultarUsuarioSenha($arrStrFiltros);
                
                if($arrObjs != null){
                    if(count($arrObjs) > 0){
                        $arrStrJson["rows"]     = $arrObjs["rows"];
                        
                        $arrStrJson["sucesso"]  = "true";
                    }
                }
            }elseif($strAcao == "Salvar"){                
                if(FachadaGerencial::getInstance()->salvarUsuario($_POST)){                
                    $arrStrJson["sucesso"]  = "true";
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }elseif($strAcao == "AlterarSenha"){
                if(FachadaGerencial::getInstance()->alterarSenhaUsuario($_POST)){
                    $arrStrJson["sucesso"]  = "true";
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }elseif($strAcao == "RecuperarSenha"){                
                if(FachadaGerencial::getInstance()->recuperarSenha($_POST)){
                    $arrStrJson["sucesso"]  = "true";
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }elseif($strAcao == "Excluir"){             
                if(FachadaGerencial::getInstance()->excluirUsuario($_POST)){                
                    $arrStrJson["sucesso"]  = "true";
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
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