<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");
    include("inc/seguranca.inc.php");
    include("inc/autoload.inc.php");
    // diretório do módulo
    $strDir = "../../sistema/gerencial";    
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/resumo.js"></script> 
</head>
<body> 
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Qtd. de Usuários por Grupo</a></li>            
        </ul>
        <div id="tabs-1">
            <div id="dialogs">
                <div id="dialog-detalhe" title="Lista de Usuários"></div>
            </div>
            <div id="relatorio">
                <div id="dados" style="min-width: 310px; height: 250px; max-width: 100%; margin: 0 auto; overflow: auto; margin-top: 20px;">
                    
                </div>             
            </div>
        </div>            
    </div>
    <script type="text/javascript">
        init();
    </script>
</body>
</html>