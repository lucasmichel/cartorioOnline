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
            $arrFiltroConsulta = null;
            if(isset($_POST["pesquisarPor"])){
                if($_POST["pesquisarPor"] == "nome"){
                    $arrFiltroConsulta["PES_Nome"] = $_POST["pesquiasrCampo"];
                }
                if($_POST["pesquisarPor"] == "cpf"){
                    $arrFiltroConsulta["PES_CPF"] = $_POST["pesquiasrCampo"];
                }
                if($_POST["pesquisarPor"] == "matricula"){
                    $arrFiltroConsulta["PES_Matricula"] = $_POST["pesquiasrCampo"];
                }                                
                if(isset($_POST["PES_Sexo"])){
                    if($_POST["PES_Sexo"] != ""){
                        $arrFiltroConsulta["PES_Sexo"] = $_POST["PES_Sexo"]; 
                    }
                }                                
                if(isset($_POST["NES_ID"])){
                    if($_POST["NES_ID"] != ""){
                        $arrFiltroConsulta["NES_ID"] = $_POST["NES_ID"]; 
                    }
                }                                
                if(isset($_POST["ECV_ID"])){                    
                    if($_POST["ECV_ID"] != ""){
                        $arrFiltroConsulta["ECV_ID"] = $_POST["ECV_ID"]; 
                    }                    
                }                
                $arrFiltroConsulta["PES_Status"] = $_POST["PES_Status"];    
            }
            if(isset($_POST["PES_ID"])){
                $arrFiltroConsulta["PES_ID"] = $_POST["PES_ID"];
            }
            
            $arrObjs = FachadaCadastro::getInstance()->consultarFuncionario($arrFiltroConsulta);
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }            
        }elseif($strAcao == "Salvar"){
            if(FachadaCadastro::getInstance()->salvarFuncionario($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }        
        }elseif($strAcao == "Excluir"){
            if(FachadaCadastro::getInstance()->excluirFuncionario($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }elseif($strAcao == "ConsultarCPFCadastro"){                        
            $arrObjs = FachadaGerencial::getInstance()->consultarPessoa($_POST);            
            if($arrObjs == null){    
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>