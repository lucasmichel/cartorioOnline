<?php
    // codificação UTF-8

    session_start();
    include("../../../inc/config.inc.php");
    include("../../../inc/seguranca.inc.php");
    include("inc/autoload.inc.php");
    include("../../../inc/permissoes.inc.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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