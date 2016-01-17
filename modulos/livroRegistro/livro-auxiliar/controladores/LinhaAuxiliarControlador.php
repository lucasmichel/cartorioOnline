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
            $arrObjs = FachadaLivroAuxiliar::getInstance()->consultarLinhaAuxiliar($_POST);
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){   
            
            //var_dump($_POST);die();
            
            
            
            $_POST["USU_UsuarioCadastroID"] = $_SESSION["USUARIO_ID"];
            $_POST["USU_UsuarioAlteracaoID"] = $_SESSION["USUARIO_ID"];            
            $_POST["LAU_DataHoraCadastro"] = date("Y-m-d H:i:s");
            $_POST["LAU_DataHoraAlteracao"] = date("Y-m-d H:i:s");
            
            if(FachadaLivroAuxiliar::getInstance()->salvarLinhaAuxiliar($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }elseif($strAcao == "Excluir"){
            if(FachadaLivroAuxiliar::getInstance()->excluirLinhaAuxiliar($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>