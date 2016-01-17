<?php
    // codificação utf-8
    function __autoload($strNomeClasse){
        $strStrDir = array(
            // Comuns, DBs, Helpers
            SISTEMA_RAIZ."/classes/comuns/"
            , SISTEMA_RAIZ."/classes/dbs/"
            , SISTEMA_RAIZ."/classes/interfaces/"
            , SISTEMA_RAIZ."/classes/helpers/"
            , SISTEMA_RAIZ."/classes/componentes/"

            // Gerencial
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/sistema/gerencial/classes/repositorios/"
                
            // tipo linha livro
            , SISTEMA_RAIZ."/modulos/livroRegistro/tipo-linha-livro/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/tipo-linha-livro/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/tipo-linha-livro/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/tipo-linha-livro/classes/repositorios/"
            
            // livro previo
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-previo/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-previo/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-previo/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-previo/classes/repositorios/"
            
            // livro auxiliar
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-auxiliar/classes/basicas/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-auxiliar/classes/fachadas/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-auxiliar/classes/negocios/"
            , SISTEMA_RAIZ."/modulos/livroRegistro/livro-auxiliar/classes/repositorios/"
            
            
            
            

        );

        for($intI=0; $intI<count($strStrDir);$intI++){
            if(file_exists($strStrDir[$intI].$strNomeClasse.".php")){
                require_once $strStrDir[$intI].$strNomeClasse.".php";
            }
        }
    }    
?>