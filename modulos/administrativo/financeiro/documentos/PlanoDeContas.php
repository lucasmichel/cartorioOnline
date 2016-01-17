<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);    
    /*echo '<pre>';
    print_r($arrStrDados = FachadaFinanceiro::getInstance()->consultarPlanoConta($_GET));
    die();*/
    if(isset($_GET)){         
        $arrStrDados = FachadaFinanceiro::getInstance()->consultarPlanoConta($_GET);
        if($arrStrDados != null){
            if(count($arrStrDados) > 0){
                $arrStrDados = $arrStrDados["objects"];
                
?>
<html>
    <head>
        <title>Plano de Contas</title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/relatorio.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>      
    </head>
    <body>
        <div id="containerRelatorio">
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
                        <h1>Plano de Contas</h1>
                    </div>
                </div>
                <hr/>
                <div>
                    <table>
                        <?php                                
                            for($intI = 0; $intI<count($arrStrDados); $intI++){
                                $planoConta = new PlanoConta();
                                $planoConta = $arrStrDados[$intI];                                    
                        ?>                            
                            <?php
                                $quebra = explode(".", $planoConta->getCodigoContabil());
                                /*echo'<pre>';
                                var_dump($quebra);*/
                                if(($quebra[0] > 1)&&(count($quebra) == 1)){
                                    echo '<tr><td></td><td></td></tr>';
                                }
                            ?>
                            <tr>
                                <td>
                                    <?php
                                        if($planoConta->getTipo() == "S"){
                                           echo'<b>';
                                        }
                                        echo $planoConta->getCodigoContabil();
                                        if($planoConta->getTipo() == "S"){
                                           echo'</b>'; 
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($planoConta->getTipo() == "S"){
                                           echo'<b>';
                                        }                                            
                                        echo $planoConta->getDescricao();                                            
                                        if($planoConta->getTipo() == "S"){
                                           echo'</b>'; 
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </table>
                    <?php
                        include("../../../sistema/gerencial/inc/rodape-impressao.inc.php");
                    ?>
                </div>
            </div>
        </div>             
    </body>
</html>
<?php
            }
        }
    }
?>