<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    require_once('../../../../lib/html2pdf_v4.03/html2pdf.class.php');  
    
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
    
    if(isset($_GET["PES_ID"])){ 
        $intPessoaID = SegurancaHelper::getInstance()->removerSQLInjection($_GET["PES_ID"]);        
        $arrStrFiltros["PES_ID"] = $intPessoaID;        
        $arrObjs = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
        
        if($arrObjs != null){
            if(count($arrObjs) > 0){
                $arrObjs = $arrObjs["objects"];
?>
<html>
    <head>
        <title>Certificado de Batismo</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>                
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>   
        <style>
            *{
                font-family: 'Open Sans Condensed', sans-serif;
            }
            
            #print{
                text-align: right;               
            }
        </style>
    </head>
    <body>     
        <?php
            include("../../../sistema/gerencial/inc/executar-impressao.inc.php");
        ?>
        <div id="impressaoConteudo">
            <table cellpadding="0" cellspacing="0" background='../img/bgCertificado.jpg' style=" background-size: 100%; background-repeat: no-repeat; width: 100%; height: 100% "  cellpadding="4" align="center" >                
                <tr align="center">
                    <td align=center colspan="2">
                        <?php
                            $strArtigo = "o";
                            
                            if($arrObjs[0]->getSexo() == "F"){
                                $strArtigo = "a";
                            }
                        ?>
                        
                        <h1 style="font-family: 'Open Sans Condensed', 'cursive'; font-size: 35px !important; margin-top: 95px;">Certificado de Batismo</h1>
                        <p style="font-family: 'Open Sans Condensed', 'cursive'; font-size: 17px !important;">
                            Certificamos que <span style="font-family: 'Open Sans Condensed', 'cursive'; font-size: 17px !important; font-weight: bold;"><?php echo $arrObjs[0]->getNome();?></span><br/>
                            foi batizad<?php echo $strArtigo;?> em nome do Pai, do Filho e do Esp&iacute;rito Santo, conforme o mandamento do Senhor Jesus Cristo<br/>
                            em Mateus 28:19.
                        </p>
                        <p style=" font-family: 'Open Sans Condensed', 'cursive'; font-size: 17px !important;">
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
                                No dia <?php echo DataHelper::getInstance()->dataPorExtenso($objDadoEcle->getData());?>.
                            <?php
                                }
                            ?>
                        </p>
                    </td>                    
                </tr>                
                <tr>
                    <td align="center" height="40px" style="padding-left: 100px;">
                        _____________________________
                        <br/>
                        <span style="font-family: 'Open Sans Condensed', 'cursive'; font-size: 15px !important;" >Pastor</span>
                        
                    </td>
                    <td align="center" height="40px" style="padding-right: 100px;">
                        _____________________________
                        <br><span style="font-family: 'Open Sans Condensed', 'cursive'; font-size: 15px !important;" >Batizando</span>
                        
                    </td>
                </tr>                
                <tr >
                    <td val align=center colspan="2" style="padding-bottom: 20px;">
                        <p style=" font-family: 'Open Sans Condensed', 'cursive'; font-size: 18px !important;">
                            <?php
                                $arrObjs = FachadaGerencial::getInstance()->consultarParametro(null);
    
                                if($arrObjs != null){
                                    $arrObjs = $arrObjs["objects"];        
                            ?>
                            <?php echo $arrObjs[0]->getRazaoSocial();?><br/>
                            <?php echo $arrObjs[0]->getEnderecoLogradouro();?>, <?php echo $arrObjs[0]->getEnderecoNumero();?>

                            <?php
                                // complemento
                                if(trim($arrObjs[0]->getEnderecoComplemento()) != ""){
                            ?>
                            ,<?php echo $arrObjs[0]->getEnderecoComplemento();?><br/>
                            <?php
                                }else{
                            ?>
                            <br/>
                            <?php
                                }
                            ?>

                            <?php echo $arrObjs[0]->getEnderecoBairro();?> - <?php echo $arrObjs[0]->getEnderecoCidade();?> - <?php echo $arrObjs[0]->getEnderecoUf();?> - Cep: <?php echo $arrObjs[0]->getEnderecoCep();?><br/>
                            CNPJ: <?php echo $arrObjs[0]->getCNPJ();?> 
                        <?php
                            }
                        ?>
                        </p>
                    </td>
                </tr>
            </table>                
        </div>
    </body>
</html>
<?php
            }
        }
    }
    
?>