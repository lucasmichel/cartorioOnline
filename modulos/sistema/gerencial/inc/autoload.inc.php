<?php
    // codificação utf-8
    function __autoload($strNomeClasse){
        $strStrDir = array(
            SISTEMA_RAIZ."/classes/comuns/"
            , SISTEMA_RAIZ."/classes/dbs/"
            , SISTEMA_RAIZ."/classes/helpers/"
            , SISTEMA_RAIZ."/classes/componentes/"
            , SISTEMA_RAIZ."/classes/interfaces/"

            // gerencial
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/repositorios/"
            
            // cadastro            
            , SISTEMA_RAIZ."/modulos/administrativo/cadastro/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/administrativo/cadastro/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/administrativo/cadastro/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/administrativo/cadastro/classes/repositorios/"
        );

        for($intI=0; $intI<count($strStrDir);$intI++){
            if(file_exists($strStrDir[$intI].$strNomeClasse.".php")){
                require_once $strStrDir[$intI].$strNomeClasse.".php";
            }
        }
    }    
?>