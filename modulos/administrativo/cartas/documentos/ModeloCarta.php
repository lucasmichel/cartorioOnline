<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);  
    
    
    if(isset($_GET["CAR_ID"])){                
                        $arrStrFiltros["CAR_ID"] = trim($_GET["CAR_ID"]);        
                        $arrObj = FachadaCarta::getInstance()->consultarCarta($arrStrFiltros);
                        if($arrObj != null){
                            if(count($arrObj) > 0){                  
                                $objCarta = new Carta();                
                                $objCarta = $arrObj["objects"][0];
                                $tipoCarta = new TipoCarta();
                                $tipoCarta = $objCarta->getTipoCarta();
    
    
?>
<html>    
    <head>
        <title><?php echo "Carta gerada em ".date("d/m/Y H:i:s");?></title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/ficha.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>
    </head>
    
    
    <body>     
        <div id="containerFicha">
            <?php
                include("../../../sistema/gerencial/inc/executar-impressao.inc.php");
            ?>
            <div id="impressaoConteudo">
                <div id="cabecalho">
                    <div id="logo">
                        <?php
                            include("../../../sistema/gerencial/inc/cabecalho-impressao.inc.php");
                        ?>
                    </div>
                    <div id="titulo">
                        <h1><?php echo $tipoCarta->getDescricao();?></h1>
                    </div>
                </div>
                <hr/>
                <div id="ficha">
                    <?php
                    
                    ?>                    
                                <table  border="0px">
                                    <tr >
                                        <td >
                                            <?php echo $objCarta->getTexto();?>
                                        </td>                            
                                    </tr>                        
                                </table>

                    <?php
                            }                    
                        }
                    }
                    ?>

                    <?php
                        include("../../../sistema/gerencial/inc/rodape-impressao.inc.php");
                    ?>
                </div>
            </div>
        </div>
    </body>    
</html>
