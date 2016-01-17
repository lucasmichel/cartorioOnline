<?php
set_time_limit(0);
include("../../../inc/config.inc.php");    

$arquivo = $_GET["arquivo"]; 
$arrInfoArquivo = pathinfo($arquivo); 
$bloqueados = array('php', 'html', 'htm', 'asp'); 

$testa = $arrInfoArquivo["extension"];

//reorganiza o caminho do arquivo
$arrCaminho = explode("/", $arquivo);
$caminhoArquivo = SISTEMA_RAIZ.DIRECTORY_SEPARATOR."modulos".DIRECTORY_SEPARATOR.$arrCaminho[2].DIRECTORY_SEPARATOR.$arrCaminho[3].DIRECTORY_SEPARATOR.$arrCaminho[4].DIRECTORY_SEPARATOR.$arrCaminho[5].DIRECTORY_SEPARATOR.$arrCaminho[6].DIRECTORY_SEPARATOR.$arrCaminho[7];

if(!in_array($testa,$bloqueados)){ 
    if(file_exists($caminhoArquivo)){         
        // faz o teste se a variavel não esta vazia e se o arquivo realmente existe 
        switch(strtolower($testa)){ 
            // verifica a extensão do arquivo para pegar o tipo 
            case "pdf": 
                $tipo="application/pdf"; 
                break; 
            case "exe": 
                $tipo="application/octet-stream"; 
                break; 
            case "zip": 
                $tipo="application/zip"; 
                break; 
            case "doc": 
                $tipo="application/msword"; 
                break; 
            case "xls": 
                $tipo="application/vnd.ms-excel"; 
                break; 
            case "ppt": 
                $tipo="application/vnd.ms-powerpoint"; 
                break; 
            case "gif": 
                $tipo="image/gif"; 
                break; 
            case "png": 
                $tipo="image/png"; 
                break; 
            case "jpg": 
                $tipo="image/jpg"; 
                break; 
            case "mp3": 
                $tipo="audio/mpeg"; 
                break; 

            case "php": 
                // deixar vazio por seurança 
            case "htm": 
                // deixar vazio por seurança 
            case "html": 
                // deixar vazio por seurança 
            } 

        header("Content-Type: ".$tipo); 
        // informa o tipo do arquivo ao navegador 
        header("Content-Length: ".filesize($caminhoArquivo)); 
        // informa o tamanho do arquivo ao navegador 
        header("Content-Disposition: attachment; filename=".basename($caminhoArquivo)); 
        // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo 
        readfile($caminhoArquivo); 
        // lê o arquivo 
        exit; 
        // aborta pós-ações             
    }else{
        echo "Arquivo nao encontrado! ".$arrInfoArquivo["basename"];
        exit;
    }    
}else{
    echo "Erro!";
    exit;
} 








    


?>