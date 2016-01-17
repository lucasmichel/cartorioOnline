<?php
ini_set('display_errors',1);
    error_reporting(E_ALL|E_STRICT|E_NOTICE);
    ini_set('error_log','script_errors.log');
    ini_set('log_errors','On');

    // codificaÃ§Ã£o UTF-8
    // URL do software
    $strProtocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false) ? 'http' : 'https';
    $strHost      = $_SERVER["SERVER_NAME"]; // Antes: HTTP_HOST
    
    // domÃ­nio principal
    define("HOST_HTTP",  $strProtocolo."://".$strHost."/");

    // configuraÃ§Ãµes do sistema
    define("SISTEMA_RAIZ", dirname(dirname(__FILE__))); // nÃ£o precisa alterar, retorna o diretÃ³rio raiz do sistema
        
    define("SISTEMA_DIR", "cartorioOnline"); // se for subdomínio não é preciso informar esse parâmetro
    define("SISTEMA_HTTP", HOST_HTTP.SISTEMA_DIR);
    define("SISTEMA_NOME", "Tecnologia Aplicada a Seu Servi&ccedil;o.");
    define("SISTEMA_SIGLA", "Cartorio Online"); // sigla do sofware, caso exista
    define("SISTEMA_TITULO", SISTEMA_SIGLA." - ".SISTEMA_NOME); // tÃ­tulo do sofware
            
    // Dados Empresa
    define("EMPRESA", "SoftLuc");
    define("EMPRESA_SITE", "www.google.com.br");    
    
    date_default_timezone_set("America/Recife");
?>
