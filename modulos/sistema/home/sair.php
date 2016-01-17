<?php
    session_start();
    
    unset($_SESSION);
    
    /*unset($_SESSION["ACESSOPERMITIDO"]);
    
    unset($_SESSION["PARAMETRO"]);
    unset($_SESSION["USUARIO_ID"]);
    unset($_SESSION["USUARIO_NOME"]);
    unset($_SESSION["UNIDADE_ID"]);
    unset($_SESSION["UNIDADE_DESCRICAO"]);
    unset($_SESSION["UNIDADE_SIGLA"]);
    unset($_SESSION["UNIDADE_CODIGO"]);*/

    //header("Location: ../../../index.php");
    
    
    $arrStrJson             = Array();
    $arrStrJson["sucessoLogout"]  = "false";
    $arrStrJson["mensagemLogout"] = "error";
    
    //caso pase a variavel 
    if(!isset($_POST['logoutJavaScript'])){
        header("Location: ../gerencial/frmLogin.php");
    }else{
        $arrStrJson["sucessoLogout"]  = "true";
        $arrStrJson["mensagemLogout"] = "OK";        
        echo json_encode($arrStrJson);
    }
    
?>