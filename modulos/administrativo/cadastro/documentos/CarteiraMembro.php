<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");    
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
       
    if(isset($_GET["PES_ID"])){  
        $arrObjsParam = FachadaGerencial::getInstance()->consultarParametro(null);
        $arrObjsParam = $arrObjsParam["objects"];
        
        $intPessoaID = SegurancaHelper::getInstance()->removerSQLInjection($_GET["PES_ID"]);
        $arrStrFiltros = array();
        $arrStrFiltros["PES_ID"] = trim($intPessoaID);        
        $arrObjs = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);               
    }
?>
<html>
    <head>
        <title>Credencial do Membro</title>    
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>
    </head>
    <body>        
        <div id='impressaoConteudo'>
            <style>
                @media print {
                    .iconeImpressao{
                        visibility: hidden;
                    }
                }
                
                .frente{
                    width: 336px;
                    float: left;
                    padding-top: 20px;  
                    padding-left: 20px;
                    padding-right: 20px;
                    background-image: url('../img/bgCredencial.jpg');
                }

                .frente h1{
                    font-family: 'Open Sans Condensed', 'cursive'; 
                    font-size: 18px !important;
                    margin-top: 0px;
                    text-align: center;
                    color: #002040;
                }

                .frente h2{
                    font-family: 'Open Sans Condensed', 'cursive'; 
                    font-size: 16px !important;
                    margin-top: 0px;
                    text-align: center;
                    color: #002040;
                }

                .verso{
                    width: 333px;
                    margin-left: 379px;
                    padding-top: 20px;  
                    padding-left: 20px;
                    padding-right: 20px;
                }

                .foto{
                    width: 100px;
                    float: left;
                }

                .dadosFrente{
                    width: 128px;
                    margin-left: 108px;
                    font-family: 'Open Sans Condensed', 'cursive';
                    font-size: 14px !important;
                }

                .dadosFrente span{
                    font-weight: bold;
                }

                .barcode{
                    text-align: center;
                }
            </style>
            <?php            
                if($arrObjs != null){   
                    $arrObjs = $arrObjs["objects"];
                    for($intI=0; $intI<count($arrObjs); $intI++){                        
                        $objMembro = $arrObjs[$intI];
            ?>
            <div style="margin: auto; background-image: url('../img/bgCredencial.jpg'); background-color: #FEFEFE; width: 755px; height: 237px; margin-bottom: 10px; background-size: 100%; background-repeat: no-repeat;">
                <div class='frente'>
                    <h1><?php echo $arrObjsParam[0]->getRazaoSocial(); ?></h1> 
                    <h2>Credencial do Membro</h2>
                    <div>
                        <div class='foto'>
                            <?php 
                                $strImg = $objMembro->getFoto();

                                if(isset($strImg)){
                                   if($strImg != null){                                       
                                       echo '<img src="'.$strImg.'" width="102px" height="110px"  />';
                                   }else{
                                       echo '<img src="../../../sistema/home/img/semFoto.png" width="102px" height="110px"  />';
                                   }
                                }else{
                                    echo '<img src="../../../sistema/home/img/semFoto.png" width="102px" height="110px"  />';
                                }
                            ?>
                        </div>
                        <div class='dadosFrente'>
                            <span>Matr&iacute;cula:</span><br/>
                            <?php echo $objMembro->getMatricula();?><br/>
                            <span>Nome:</span><br/>
                            <?php echo $objMembro->getNome();?><br/>
                            <span>Batizado em:</span><br/>
                            <?php
                                $arrfiltrodadoEcle["PES_ID"] = $arrObjs[0]->getId();
                                $arrfiltrodadoEcle["DAM_Tipo"] = "BATISMO";
                                $arrObjEcle = NegDadosEclesiasticos::getInstance()->consultar($arrfiltrodadoEcle);
                                if($arrObjEcle != null){
                                    $arrObjEcle = $arrObjEcle["objects"];
                                    $objDadoEcle = new DadosEclesiasticos();
                                    $objDadoEcle = $arrObjEcle[0];
                                    //$arrStrDados[$intI]["DAM_Data"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($objDadoEcle->getData());
                                    
                            ?>
                                <?php echo DataHelper::getInstance()->converterDataBancoParaDataUsuario($objDadoEcle->getData());?>.
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div><!-- frente -->
                <div class='verso'>
                    <div class='barcode'>
                        <?php
                            require_once("../../../../lib/barcode39/Barcode39.php");
                            $objBc = new Barcode39($objMembro->getMatricula()); 
                            
                            $strArquivoBarcode = "../img/barcode39/membros/".$objMembro->getId().".gif";
                            
                            if($objBc->draw($strArquivoBarcode)){
                                echo '<img src="'.$strArquivoBarcode.'"/>';
                            }
                        ?>
                    </div>
                </div><!-- verso --> 
            </div>
            <?php
                    }
                }
            ?>
        </div>
    </body>
</html>