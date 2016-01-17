<?php
    // codificação UTF-8    
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/financeiro";
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
            <li><a href="#tabs-1">Pagamentos e Recebimentos</a></li>            
        </ul>
        <div id="tabs-1">
            <?php
                // exportacao de conteúdo
                include("../../sistema/gerencial/inc/export.inc.php");  
            ?>
            
            <div id="resumo">
                <h1 class="titulo_relatorio">Contas a Pagar</h1>
                <?php
                    $arrStrFiltros = array();
                    $arrStrFiltros["PCL_ParcelaAberta"] = true;
                    $arrStrFiltros["CON_Tipo"] = "P";

                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarParcelasContaPagarReceber($arrStrFiltros);
                    $douTotal = 0;                        
                    $strHtml  = '';

                    if($arrObjs != null){
                        $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                            $strHtml .= '<tr class="cabecalhoTabela">';
                                $strHtml .= '<td width="80px">Cód. Parc.</td>';
                                $strHtml .= '<td width="80px" align="center">Data Venc.</td>';
                                $strHtml .= '<td width="670px"><div style="width: 670px;">Hist&oacute;rico</div></td>';
                                $strHtml .= '<td width="80px" align="right">Valor Total (R$)</td>'; 
                                $strHtml .= '<td width="100px" align="center">N&ordm; do Documento</td>';                                    
                                $strHtml .= '<td width="60px" align="center">Atraso</td>';
                            $strHtml .= '</tr>';

                            $strClassDif = '';

                            for($intI=0; $intI<count($arrObjs); $intI++){
                                $strClassDif = 'class="linhaNormal"';

                                if($intI%2 == 0){
                                    $strClassDif = 'class="linhaCor"';
                                }

                                $strHtml .= '<tr '.$strClassDif.'>';
                                    $strHtml .= '<td>'.$arrObjs[$intI]["PCL_ID"].'</td>';
                                    $strHtml .= '<td align="center">'.$arrObjs[$intI]["PCL_DataVencimento"].'</td>';
                                    
                                    // consulta o histórico 
                                    $arrStrFiltrosHistorico = array();
                                    $arrStrFiltrosHistorico["CON_ID"] = $arrObjs[$intI]["CON_ID"];
                                    $arrStrDadosHistoricos = FachadaFinanceiro::getInstance()->consultarContaPagarReceber($arrStrFiltrosHistorico);
                                    $arrStrDadosHistoricos = $arrStrDadosHistoricos["objects"];
                                    
                                    $strHtml .= '<td>'.$arrStrDadosHistoricos[0]->getDescricao().'</td>';
                                    
                                    $strHtml .= '<td align="right">'.$arrObjs[$intI]["PCL_Valor"].'</td>';
                                    $strHtml .= '<td align="center">'.$arrObjs[$intI]["PCL_Numero"].'</td>';

                                    $strCor = '';

                                    if($arrObjs[$intI]["PCL_DiasAtraso"] > 0){
                                        $strCor = 'style="background-color: #FF4242; color: #FFF;"';
                                    }

                                    $strHtml .= '<td align="center" '.$strCor.'>'.$arrObjs[$intI]["PCL_DiasAtraso"].' dia(s)</td>';
                                $strHtml .= '</tr>';

                                $douTotal += doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrObjs[$intI]["PCL_Valor"]));
                            }

                            $strHtml .= '<tr class="rodapeRelatorio">';
                                $strHtml .= '<td colspan="3" align="right"><b>Total</b></td>';
                                $strHtml .= '<td align="right"><b>'.NumeroHelper::getInstance()->formatarMoeda($douTotal).'</b></td>';
                                $strHtml .= '<td align="right" colspan="2"></td>';                                
                            $strHtml .= '</tr>';

                        $strHtml .= '</table>';
                    }else{                        
                        $strHtml = '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
                            $strHtml .= '<tr>';
                                $strHtml .= '<td>Nenhum valor a pagar.</td>';
                            $strHtml .= '</tr>';
                        $strHtml .= '</table>';
                    }

                    echo $strHtml;
                ?>
                <h1 class="titulo_relatorio">Contas a Receber</h1>
                <?php
                    $arrStrFiltros = array();
                    $arrStrFiltros["PCL_ParcelaAberta"] = true;
                    $arrStrFiltros["CON_Tipo"] = "R";

                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarParcelasContaPagarReceber($arrStrFiltros);
                    $douTotal = 0;                        
                    $strHtml  = '';

                    if($arrObjs != null){
                        $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                            $strHtml .= '<tr class="cabecalhoTabela">';
                                $strHtml .= '<td width="80px">Cód. Parc.</td>';
                                $strHtml .= '<td width="80px" align="center">Data Venc.</td>';
                                $strHtml .= '<td width="670px"><div style="width: 670px;">Hist&oacute;rico</div></td>';
                                $strHtml .= '<td width="80px" align="right">Valor Total (R$)</td>'; 
                                $strHtml .= '<td width="100px" align="center">N&ordm; do Documento</td>';                                    
                                $strHtml .= '<td width="60px" align="center">Atraso</td>';
                            $strHtml .= '</tr>';

                            $strClassDif = '';

                            for($intI=0; $intI<count($arrObjs); $intI++){
                                $strClassDif = 'class="linhaNormal"';

                                if($intI%2 == 0){
                                    $strClassDif = 'class="linhaCor"';
                                }

                                $strHtml .= '<tr '.$strClassDif.'>';
                                    $strHtml .= '<td>'.$arrObjs[$intI]["PCL_ID"].'</td>';
                                    $strHtml .= '<td align="center">'.$arrObjs[$intI]["PCL_DataVencimento"].'</td>';
                                    
                                    // consulta o histórico 
                                    $arrStrFiltrosHistorico = array();
                                    $arrStrFiltrosHistorico["CON_ID"] = $arrObjs[$intI]["CON_ID"];
                                    $arrStrDadosHistoricos = FachadaFinanceiro::getInstance()->consultarContaPagarReceber($arrStrFiltrosHistorico);
                                    $arrStrDadosHistoricos = $arrStrDadosHistoricos["objects"];
                                    
                                    $strHtml .= '<td>'.$arrStrDadosHistoricos[0]->getDescricao().'</td>';
                                    $strHtml .= '<td align="right">'.$arrObjs[$intI]["PCL_Valor"].'</td>';
                                    $strHtml .= '<td align="center">'.$arrObjs[$intI]["PCL_Numero"].'</td>';

                                    $strCor = '';

                                    if($arrObjs[$intI]["PCL_DiasAtraso"] > 0){
                                        $strCor = 'style="background-color: #FF4242; color: #FFF;"';
                                    }

                                    $strHtml .= '<td align="center" '.$strCor.'>'.$arrObjs[$intI]["PCL_DiasAtraso"].' dia(s)</td>';
                                $strHtml .= '</tr>';

                                $douTotal += doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrObjs[$intI]["PCL_Valor"]));
                            }

                            $strHtml .= '<tr class="rodapeRelatorio">';
                                $strHtml .= '<td colspan="3" align="right"><b>Total</b></td>';
                                $strHtml .= '<td align="right"><b>'.NumeroHelper::getInstance()->formatarMoeda($douTotal).'</b></td>';
                                $strHtml .= '<td align="right" colspan="2"></td>';                                
                            $strHtml .= '</tr>';

                        $strHtml .= '</table>';
                    }else{                        
                        $strHtml = '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
                            $strHtml .= '<tr>';
                                $strHtml .= '<td>Nenhum valor a receber.</td>';
                            $strHtml .= '</tr>';
                        $strHtml .= '</table>';
                    }

                    echo $strHtml;
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        init();
    </script>
</body>
</html>