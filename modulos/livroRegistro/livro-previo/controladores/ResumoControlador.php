<?php
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    
    // variáveis utilizadas neste arquivo
    // estas variáveis são padrões do sistema
    $arrStrJson            = null;
    $arrStrJson["sucesso"] = "false";  
    $strAcao               = $_POST["ACO_Descricao"]; // requisições recebidas pela interface
    
    // caso seja retornado uma exceção esta flag deve ser alterada
    // para true. Dessa forma o sistema o sistema exibirá a div correspondente
    // a exceção, será uma DIV diferente do padrão.
    $arrStrJson["excecao"] = "false";      
    
    try{
        if($strAcao == "DadosDoGrafico"){            
            // Grupos de Patrimônio
            $arrStrFiltros = array();
            $arrStrFiltros["TIP_Status"] = "A";
            $arrObjsGropoPatrimonio = FachadaPatrimonio::getInstance()->consultarTipoPatrimonio($arrStrFiltros);
            $arrObjsGropoPatrimonio = $arrObjsGropoPatrimonio["objects"];  
            
            $strHtml  = '';
            $intTotalGeralFinal = 0;
            
            if($arrObjsGropoPatrimonio != null){                
                $arrDados = array();            
                $arrDados["chart"]["title"] = "Patrimônios da Instituição";
                $arrDados["chart"]["text"] = "Texto";
                
                $strHtml = '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td width="25%">Grupo</td>';
                        $strHtml .= '<td width="25%">Subgrupo</td>';
                        $strHtml .= '<td width="10%" align="center">Quantidade</td>'; 
                        $strHtml .= '<td width="10%" align="center">Novo(%)</td>';    
                        $strHtml .= '<td width="10%" align="center">Bom(%)</td>';
                        $strHtml .= '<td width="10%" align="center">Regular(%)</td>';
                        $strHtml .= '<td width="10%" align="center">Ruim(%)</td>';
                    $strHtml .= '</tr>';
                    $strClassDif = '';
                
                for($intI=0; $intI<count($arrObjsGropoPatrimonio); $intI++){                     
                    $strClassDif = 'class="linhaNormal"';
                    if($intI%2 == 0){
                        $strClassDif = 'class="linhaCor"';
                    }
                    // identifica os subgrupos de cada grupo
                    $arrStrFiltros = array();
                    $arrStrFiltros["IPT_Status"] = "A";
                    $arrStrFiltros["TIP_ID"]     = $arrObjsGropoPatrimonio[$intI]->getId();
                    $arrObjsItensGropoPatrimonio = FachadaPatrimonio::getInstance()->consultarItemPatrimonio($arrStrFiltros);
                    $arrObjsItensGropoPatrimonio = $arrObjsItensGropoPatrimonio["objects"];
                    
                    // controla o número de linhas que será colocado no rowspan
                    // do grupo
                    // será listado o grupo e dentro dele os subgrupos
                    // Ex.:
                    // Grupo1       Subgrupo1
                    //              Subgrupo2
                    //              Subgrupo3
                    // Grupo 2      Subgrupo4
                    $strRowsSpan = '';

                    if($arrObjsItensGropoPatrimonio != null){
                        if(count($arrObjsItensGropoPatrimonio) > 0){
                            $strRowsSpan = 'rowspan="'.count($arrObjsItensGropoPatrimonio).'"';
                        }
                    }
                    
                    // o grupo só é exibido uma vez
                    $strHtmlGrupo = '<td '.$strRowsSpan.' valign="top">'.$arrObjsGropoPatrimonio[$intI]->getDescricao().'</td>';

                    $intTotalGeralGrupo = 0;
                    
                    if($arrObjsItensGropoPatrimonio != null){
                        for($intZ=0; $intZ<count($arrObjsItensGropoPatrimonio); $intZ++){
                            
                            $strHtml .= '<tr '.$strClassDif.'>'; 
                            if($intZ == 0){
                                $strHtml .= $strHtmlGrupo;
                            }
                            
                            // gera as estatísticas
                            $arrStrFiltros = array();
                            $arrStrFiltros["TOT_Total"] = true;
                            $arrStrFiltros["IPT_ID"] = $arrObjsItensGropoPatrimonio[$intZ]->getId();
                            $arrStrDadosPerc = RepoPatrimonio::getInstance()->consultar($arrStrFiltros);
                            $intTotalGeral = intval($arrStrDadosPerc[0]["Total"]); // total de patrimônios
                            $intTotalGeralGrupo += $intTotalGeral; // obterm o total final do Grupo

                            // novo
                            $arrStrFiltros = array();
                            $arrStrFiltros["PTM_Campo"] = "PTM_Condicao";
                            $arrStrFiltros["PTM_CampoValor"] = "NOVO";
                            $arrStrFiltros["IPT_ID"] = $arrObjsItensGropoPatrimonio[$intZ]->getId();

                            $arrStrDadosPerc = RepoPatrimonio::getInstance()->contarCampo($arrStrFiltros);
                            $intTotalParcial = intval($arrStrDadosPerc[0]["Total"]); // total de patrimônios
                            $intTotalNovo    = $intTotalParcial;

                            // bom
                            $arrStrFiltros = array();
                            $arrStrFiltros["PTM_Campo"] = "PTM_Condicao";
                            $arrStrFiltros["PTM_CampoValor"] = "BOM";
                            $arrStrFiltros["IPT_ID"] = $arrObjsItensGropoPatrimonio[$intZ]->getId();

                            $arrStrDadosPerc = RepoPatrimonio::getInstance()->contarCampo($arrStrFiltros);
                            $intTotalParcial = intval($arrStrDadosPerc[0]["Total"]); // total de patrimônios
                            $intTotalBom    = $intTotalParcial;

                            // regular
                            $arrStrFiltros = array();
                            $arrStrFiltros["PTM_Campo"] = "PTM_Condicao";
                            $arrStrFiltros["PTM_CampoValor"] = "REGULAR";
                            $arrStrFiltros["IPT_ID"] = $arrObjsItensGropoPatrimonio[$intZ]->getId();

                            $arrStrDadosPerc = RepoPatrimonio::getInstance()->contarCampo($arrStrFiltros);
                            $intTotalParcial = intval($arrStrDadosPerc[0]["Total"]); // total de patrimônios
                            $intTotalRegular = $intTotalParcial;

                            // ruim
                            $arrStrFiltros = array();
                            $arrStrFiltros["PTM_Campo"] = "PTM_Condicao";
                            $arrStrFiltros["PTM_CampoValor"] = "RUIM";
                            $arrStrFiltros["IPT_ID"] = $arrObjsItensGropoPatrimonio[$intZ]->getId();

                            $arrStrDadosPerc = RepoPatrimonio::getInstance()->contarCampo($arrStrFiltros);
                            $intTotalParcial = intval($arrStrDadosPerc[0]["Total"]); // total de patrimônios
                            $intTotalRuim    = $intTotalParcial;

                            // cálculo dos percentuais
                            $douPercNovo = NumeroHelper::getInstance()->formatar2CasasDecimais(0);
                            $douPercBom = NumeroHelper::getInstance()->formatar2CasasDecimais(0);
                            $douPercRegular = NumeroHelper::getInstance()->formatar2CasasDecimais(0);
                            $douPercRuim = NumeroHelper::getInstance()->formatar2CasasDecimais(0);

                            if($intTotalGeral > 0){
                                $douPercNovo    = NumeroHelper::getInstance()->formatar2CasasDecimais($intTotalNovo*100/$intTotalGeral);                                            
                                $douPercBom     = NumeroHelper::getInstance()->formatar2CasasDecimais($intTotalBom*100/$intTotalGeral);
                                $douPercRegular = NumeroHelper::getInstance()->formatar2CasasDecimais($intTotalRegular*100/$intTotalGeral);
                                $douPercRuim    = NumeroHelper::getInstance()->formatar2CasasDecimais($intTotalRuim*100/$intTotalGeral);
                            }

                                $strHtml .= '<td>'.$arrObjsItensGropoPatrimonio[$intZ]->getDescricao().'</td>';
                                $strHtml .= '<td align="center">'.$intTotalGeral.'</td>';
                                $strHtml .= '<td align="center">'.$douPercNovo.'</td>';
                                $strHtml .= '<td align="center">'.$douPercBom.'</td>';
                                $strHtml .= '<td align="center">'.$douPercRegular.'</td>';
                                $strHtml .= '<td align="center">'.$douPercRuim.'</td>';
                            $strHtml .= '</tr>';
                            $intTotalGeralFinal += $intTotalGeral;   
                        }
                        
                        $arrStrGraficoDadosSeries[] = $intTotalGeralGrupo; 
                        $arrDados["chart"]["categories"][] = $arrObjsGropoPatrimonio[$intI]->getDescricao();                            
                    }else{                                           
                        $strHtml .= '<tr>';
                        $strHtml .= $strHtmlGrupo;
                        $strHtml .= '<td>-</td>';
                        $strHtml .= '<td align="center">-</td>';
                        $strHtml .= '<td align="center">-</td>';
                        $strHtml .= '<td align="center">-</td>';
                        $strHtml .= '<td align="center">-</td>';
                        $strHtml .= '<td align="center">-</td>';
                        $strHtml .= '</tr>';                        
                    }                    
                }
                    $strHtml .= '<tr>';
                        $strHtml .= '<td colspan="2" align="right"><b>Total</b></td>';
                        $strHtml .= '<td align="center"><b>'.$intTotalGeralFinal.'</b></td>';
                        $strHtml .= '<td align="right" colspan="4"></td>';                                
                    $strHtml .= '</tr>';
                            
                    $strHtml .= '</table>';
                
                    $arryName = array();
                    $arryName["name"] = "Quantidade";
                    $arryName["data"] = $arrStrGraficoDadosSeries;
                    $arrDados["chart"]["series"] = $arryName;
                    $arrDados["EXCEL"] = $strHtml;
                    $arrStrJson["dados"] = $arrDados;                      
                    $arrStrJson["sucesso"]     = "true";
                
                
            }else{
                $arrStrJson["mensagem"] = "NENHUMA PATRIMONIO CADASTRADO.";
                $arrStrJson["dados"] = null;
                $arrStrJson["sucesso"] = "false";
            }
        }        
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>