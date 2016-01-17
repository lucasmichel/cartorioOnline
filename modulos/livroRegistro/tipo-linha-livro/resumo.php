<?php
    // codificação UTF-8    
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/patrimonio";
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
            <li><a href="#tabs-1">Resumo</a></li>            
        </ul>
        <div id="tabs-1">
            <?php
                // exportacao de conteúdo
                include("../../sistema/gerencial/inc/export.inc.php");  
            ?>
            
            <div id="relatorio">
                <div id="grafico" style="min-width: 310px; height: 290px; max-width: 100%; margin: 0 auto">
                    Carregando...
                </div>               
                <div id="dados" style="min-width: 310px; height: 250px; max-width: 100%; margin: 0 auto; overflow: auto; margin-top: 20px;">
                    Carregando...
                </div>             
            </div>
        </div>
    </div>
    <script type="text/javascript">
        init();
    </script>
</body>
</html>