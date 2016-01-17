<?php
    // codificação UTF-8    
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/cadastro";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/resumo.js"></script>
    <style type="text/css">
        .highcharts-container{width:100% !important;}
    </style>
</head>
<body> 
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Resumo</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                        <a href="javascript: void(0);" onclick="imprimir('printMembroPorStatus');"><img src="img/imprimir.png" width="24" height="24" border="0" alt="Imprimir" title="Imprimir" align="absmiddle" /></a>
                    </div>
                    <div id="printMembroPorStatus">
                        <div id="resMembroPorStatus"></div>
                        <div id="relatorioMembroPorStatus" style="margin-top: 10px;"></div>
                    </div>
        </div>
            
    </div>
    <script type="text/javascript">
        init();
    </script>
</body>
</html>