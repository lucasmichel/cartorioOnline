<?php
    // codificação utf-8 
    session_start();
    include("../../../../inc/config.inc.php");    
    include("../inc/autoload.inc.php");
    
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
                    
        if($strAcao == "ChecarNumeroMembroPermitido"){
            //identifica a quantidade permitida pela aplicação
            $strSQLSystem  = "SELECT * FROM CAD_SYS_SYSTEM ";                        
            $arrStrDadosSystem = Db::getInstance()->select($strSQLSystem);            
            $intTotalPermitido = $arrStrDadosSystem[0]["SYS_QuantidadeMaxMembros"];
            
            // identifica a quantidade de membros cadastrados            
            $strSQLMembro  = "SELECT COUNT(PES_ID) AS TOTAL FROM ADM_MEM_MEMBROS ";                        
            $arrStrDadosMembro = Db::getInstance()->select($strSQLMembro);            
            $intTotalMembro = $arrStrDadosMembro[0]["TOTAL"];
            
            if($intTotalMembro<$intTotalPermitido){
                $arrStrJson["permitido"] = "true";
            }else{
                $arrStrJson["permitido"] = "false";
            }            
            $arrStrJson["sucesso"] = "true";            
        }
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }
    
    echo json_encode($arrStrJson);
?>