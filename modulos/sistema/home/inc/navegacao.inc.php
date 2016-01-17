<?php
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");    
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <div id="barra-navegacao">
        <?php
            if(isset($_GET["moduloCategoria"])){
                $arrStrFiltros = array();
                $arrStrFiltros["MCT_ID"] = $_GET["moduloCategoria"];
                $arrObjs = FachadaGerencial::getInstance()->consultarModuloCategoria($arrStrFiltros);
                $arrObjs = $arrObjs["objects"];
                
                if($arrObjs != null){
                    if(count($arrObjs) > 0){
                        $objModuloCategoria = $arrObjs[0];
        ?>
        <a href="javascript: void(0);" onclick="atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php'); exibirTela('content', 'modulo-categoria.php');"><b>Tela inicial</b></a>
        /
        <?php echo $objModuloCategoria->getDescricao(); ?>
        <?php
                    }
                }
            }

            if(isset($_GET["modulo"])){
                $arrStrFiltros = array();
                $arrStrFiltros["MOD_ID"]     = $_GET["modulo"];
                $arrStrFiltros["MOD_Status"] = "A";
                $arrObjModulos = FachadaGerencial::getInstance()->consultarModulo($arrStrFiltros);
                
                if($arrObjModulos != null){
                    if(count($arrObjModulos["objects"]) > 0){
                        $objModulo = $arrObjModulos["objects"][0];
        ?>
        <a href="javascript: void(0);" onclick="atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php'); exibirTela('content', 'modulo-categoria.php');"><b>Tela inicial</b></a>
        /
        <a href="javascript: void(0);" title="<?php echo $objModulo->getModuloCategoria()->getDescricao(); ?>" onclick="atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php?moduloCategoria=<?php echo $objModulo->getModuloCategoria()->getId(); ?>'); exibirTela('content', 'modulo.php?moduloCategoria=<?php echo $objModulo->getModuloCategoria()->getId(); ?>');"><b><?php echo $objModulo->getModuloCategoria()->getDescricao(); ?></b></a>
        /
        <?php echo $objModulo->getDescricao(); ?>
        <?php
                    }
                }
            }
        ?>
    </div>
</body>
</html>