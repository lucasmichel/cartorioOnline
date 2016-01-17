<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
    
    if(isset($_GET["cod"])){ 
        // parâmetros do sistema
        $arrObjsParam = FachadaGerencial::getInstance()->consultarParametro(null);        
        $arrObjsParam = $arrObjsParam["objects"];     
        
        $strSQL  = "SELECT * FROM FIN_CON_CONTAS AS C ";
        $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS P ON (P.PES_ID=C.PES_ID) "; 
        $strSQL .= "LEFT JOIN FIN_FOR_FORNECEDORES AS F ON (F.FOR_ID=C.FOR_ID) "; 
        $strSQL .= "WHERE C.CON_ID=".SegurancaHelper::getInstance()->removerSQLInjection(trim($_GET["cod"]));
        
        $arrStrDados = Db::getInstance()->select($strSQL);
                        
        if($arrStrDados != null){
            if(count($arrStrDados) > 0){                  
                /*$strTitulo = "Pagamento";
                
                if($arrStrDados[0]["CON_Tipo"] == "R"){
                    $strTitulo = "Recebimento";
                }*/
?>
<html>
    <head>
        <title>Recibo</title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/recibo.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>       
    </head>
    <body>
        <div id="containerRecibo">
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
                        <h1>Recibo</h1>
                    </div>
                </div>
                <hr/>
                <div>
                    <table id="dadosRecibo" style="width: 100%;">
                        <tr>
                            <td>
                                <div class="redondo" style="width: 450px">
                                    <?php
                                        echo 'Recebi da <strong>'.trim($arrObjsParam[0]->getRazaoSocial()).'</strong><br/><br/>';
                                        echo '<strong>Endere&ccedil;o:</strong><br/>'.trim($arrObjsParam[0]->getEnderecoLogradouro()).", ".trim($arrObjsParam[0]->getEnderecoNumero());

                                        if(trim($arrObjsParam[0]->getEnderecoComplemento()) != ""){
                                            echo ", ".trim($arrObjsParam[0]->getEnderecoComplemento())."<br/> ";
                                        }else{
                                            echo "<br/>";
                                        }

                                        echo trim($arrObjsParam[0]->getEnderecoBairro()).", ".trim($arrObjsParam[0]->getEnderecoCidade())." - ".trim($arrObjsParam[0]->getEnderecoUf())." - Cep: ".trim($arrObjsParam[0]->getEnderecoCep())."<br/><br/>";
                                        
                                    ?>
                                </div>
                            </td>                            
                            <td valign="top">
                                <p style="text-align: right;">
                                    <strong>N°</strong> <?php echo NumeroHelper::getInstance()->completarComZero($arrStrDados[0]["CON_ID"], 5);?>
                                </p>                                
                                <div class="redondo" style="text-align: right; width: 160px; float: right;">
                                    <strong>(R$)</strong> <?php echo NumeroHelper::getInstance()->formatarMoeda($arrStrDados[0]["CON_ValorTotal"]);?>                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 10px 0px 0px 0px;">
                                <div class="redondo">
                                    <?php
                                        echo 'A import&acirc;ncia de <strong>'. NumeroHelper::getInstance()->valorPorExtenso( NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados[0]["CON_ValorTotal"])).'</strong>.<br/>';
                                        echo 'Referente &agrave; <strong>'.$arrStrDados[0]["CON_Descricao"].'</strong><br/>';                                
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 10px 0px 10px 0px;">
                                Para maior clareza, firmamos o presente.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    $strEndereco = "";
                                            
                                    if($arrStrDados[0]["CON_Tipo"] == "P"){
                                        echo '<strong>Emitente:</strong> '.$arrStrDados[0]["FOR_NomeFantasia"].'<br/>';
                                        
                                        if($arrStrDados[0]["FOR_Tipo"] == "F"){                                            
                                            echo '<strong>CPF:</strong> '.$arrStrDados[0]["FOR_CNPJ"].'<br/>';
                                        }else{                                            
                                            echo '<strong>CNPJ:</strong> '.$arrStrDados[0]["FOR_CNPJ"].'<br/>';
                                        } 

                                        if(isset($arrStrDados[0]["FOR_EnderecoLogradouro"])){
                                            if($arrStrDados[0]["FOR_EnderecoLogradouro"] != ""){
                                                $strEndereco .= $arrStrDados[0]["FOR_EnderecoLogradouro"].", ".$arrStrDados[0]["FOR_EnderecoNumero"];

                                                if(trim($arrStrDados[0]["FOR_EnderecoComplemento"]) != ""){
                                                    $strEndereco .= ", ".$arrStrDados[0]["FOR_EnderecoComplemento"]."<br/>";
                                                }

                                                $strEndereco .= $arrStrDados[0]["FOR_EnderecoBairro"].", ".$arrStrDados[0]["FOR_EnderecoCidade"]." - ".$arrStrDados[0]["FOR_EnderecoUf"]." - CEP: ".$arrStrDados[0]["FOR_EnderecoCep"];
                                            }
                                        }

                                        echo '<strong>Endere&ccedil;o:</strong><br/>';
                                        echo $strEndereco;
                                    }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                    echo "<strong>Data:</strong> ".DataHelper::getInstance()->dataPorExtenso(date("Y-m-d"));
                                ?>
                                <br/><br/>
                                _____________________________________________________________
                                <br/>
                                <?php
                                    echo $arrStrDados[0]["FOR_NomeFantasia"].'<br/>';
                                ?>
                            </td>
                        </tr>
                    </table>
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