<?php
    // codificação UTF-8
    session_start();
    $arrStrJson = array();
    $arrStrJson["pdfID"] = $_SESSION["USUARIO_ID"]."_".time();    
    
    // grava na sessão o conteúdo do pdf enviado via post
    // esses dados serão resgatados em outro momento
    $_SESSION[$arrStrJson["pdfID"]]["PDF_Nome"]       = $_POST["PDF_Nome"];    
    $_SESSION[$arrStrJson["pdfID"]]["PDF_Conteudo"]   = $_POST["PDF_Cabecalho"].$_POST["PDF_Conteudo"];
    $_SESSION[$arrStrJson["pdfID"]]["PDF_Orientacao"] = $_POST["PDF_Orientacao"];
    
    echo json_encode($arrStrJson);
?>

