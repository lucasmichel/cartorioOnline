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
            $arrObjs = FachadaCarta::getInstance()->consultarTipoCarta($_POST);
            
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){             
            if(FachadaCarta::getInstance()->salvarTipoCarta($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }        
        }elseif($strAcao == "Excluir"){             
            if(FachadaCarta::getInstance()->excluirTipoCarta($_POST)){                
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