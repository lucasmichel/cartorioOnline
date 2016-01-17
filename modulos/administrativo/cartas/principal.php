<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");
    include("../../sistema/gerencial/inc/seguranca.inc.php");
    include("inc/autoload.inc.php");
    
    // o menu utiliza esse formulário para verificar quais 
    // estão disponíveis para o usuário
    include("../../sistema/gerencial/inc/permissoes.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript">
        $(document).ready(function(){
            exibirTela("content-modulo", "../../administrativo/cartas/resumo.php");
        });
    </script>
</head>
<body>
    <div id="container-modulo">
        <?php
            include(SISTEMA_RAIZ."/modulos/sistema/home/inc/menu.inc.php");
        ?>
        <div id="content-modulo">
        </div><!-- #content-modulo -->
    </div>
</body>
</html>