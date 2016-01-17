<?php
    // codificação utf-8
    function __autoload($strNomeClasse){
        $strStrDir = array(
            // Comuns, DBs, Helpers
            SISTEMA_RAIZ."/classes/comuns/"
            , SISTEMA_RAIZ."/classes/dbs/"
            , SISTEMA_RAIZ."/classes/helpers/"

            // Gerencial
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/repositorios/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/controladores/"

            // Administrativo
            , SISTEMA_RAIZ."/modulos/administrativo/administrativo/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/administrativo/administrativo/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/administrativo/administrativo/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/administrativo/administrativo/classes/repositorios/"
            , SISTEMA_RAIZ."/modulos/administrativo/administrativo/controladores/"

        );

        for($intI=0; $intI<count($strStrDir);$intI++){
            if(file_exists($strStrDir[$intI].$strNomeClasse.".php")){
                require_once $strStrDir[$intI].$strNomeClasse.".php";
            }
        }
    }    
?>