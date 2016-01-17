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
        if($strAcao == "AcumuladoPorCentroCusto"){
            if($_POST['CEN_ID'] > 0){
                $strSQL  = "SELECT CEN.CEN_ID, CEN.CEN_Descricao FROM FIN_CEN_CENTROS_CUSTO AS CEN WHERE CEN.CEN_ID = ".$_POST['CEN_ID']." AND CEN.CEN_Status = 'A'";
            }else{
                $strSQL  = "SELECT CEN.CEN_ID, CEN.CEN_Descricao FROM FIN_CEN_CENTROS_CUSTO AS CEN WHERE CEN.CEN_Status = 'A'";
            }
            $arrStrDados = Db::getInstance()->select($strSQL);            
            if($arrStrDados != null){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Acumulado Por Centro de Custo</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Per&iacute;odo de '.$_POST["LCA_DataInicial"].' a '.$_POST["LCA_DataFinal"].'</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 60px; text-align: left;">C&oacute;d.</td>';
                        $strHtml .= '<td style="width: 370px; text-align: left;">Nome</td>';
                        $strHtml .= '<td style="width: 170px; text-align: right;">Entradas(R$)</td>';
                        $strHtml .= '<td style="width: 170px; text-align: right;">Saídas(R$)</td>';
                        $strHtml .= '<td style="width: 100px; text-align: right;">Saldo(R$)</td>';
                    $strHtml .= '</tr>';
                
                $douTotalGeralEntradas = 0;
                $douTotalGeralSaidas = 0;
                    
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    $strClass = 'linhaNormal';
                    
                    if($intI%2 == 0){
                        $strClass = 'linhaCor';
                    }
                    
                    $strHtml .= '<tr class="'.$strClass.'">';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["CEN_ID"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["CEN_Descricao"].'</td>';
                                                
                        // calcula o valor por centro de custo
                        // diferenca entre entradas e saidas
                        // calculo das entradas                        
                        $strSQL  = "SELECT SUM(LCA_Valor) AS LCA_ValorTotal FROM FIN_LCA_LANCAMENTOS_CAIXA WHERE CEN_ID = ".$arrStrDados[$intI]["CEN_ID"]." ";
                        $strSQL .= "AND LCA_DataMovimento BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                        $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' AND LCA_Tipo = 'E' ";
                        $arrStrDadosEntrada = Db::getInstance()->select($strSQL);
                        
                        $strValorTotalEntrada = 0;
                        
                        if($arrStrDadosEntrada != null){
                            if(count($arrStrDadosEntrada) > 0){
                                if(trim($arrStrDadosEntrada[0]["LCA_ValorTotal"]) != ""){
                                    $strValorTotalEntrada = $arrStrDadosEntrada[0]["LCA_ValorTotal"];
                                }
                            }
                        }
                        
                        // calcula o valor por centro de custo
                        // diferenca entre entradas e saidas
                        // calculo das saídas                        
                        $strSQL  = "SELECT SUM(LCA_Valor) AS LCA_ValorTotal FROM FIN_LCA_LANCAMENTOS_CAIXA WHERE CEN_ID = ".$arrStrDados[$intI]["CEN_ID"]." ";
                        $strSQL .= "AND LCA_DataMovimento BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                        $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' AND LCA_Tipo = 'S' ";
                        $arrStrDadosSaida = Db::getInstance()->select($strSQL);
                        
                        $strValorTotalSaida = 0;
                        
                        if($arrStrDadosSaida != null){
                            if(count($arrStrDadosSaida) > 0){
                                if(trim($arrStrDadosSaida[0]["LCA_ValorTotal"]) != ""){
                                    $strValorTotalSaida = $arrStrDadosSaida[0]["LCA_ValorTotal"];
                                }
                            }
                        }
                        
                        //
                        // Contas a Pagar/Receber
                        //
                        //
                        $strSQL  = "SELECT SUM(P.PCL_Valor) AS PCL_ValorTotal FROM FIN_PCL_PARCELAS AS P ";
                        $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                        $strSQL .= "WHERE C.CEN_ID = ".$arrStrDados[$intI]["CEN_ID"]." ";
                        $strSQL .= "AND P.PCL_DataBaixa BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                        $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' AND PC.PLA_Movimentacao = 'E' ";
                        $arrStrDadosEntrada = Db::getInstance()->select($strSQL);
                        
                        $strValorTotalEntradaContas = 0;
                        
                        if($arrStrDadosEntrada != null){
                            if(count($arrStrDadosEntrada) > 0){
                                if(trim($arrStrDadosEntrada[0]["PCL_ValorTotal"]) != ""){
                                    $strValorTotalEntradaContas = $arrStrDadosEntrada[0]["PCL_ValorTotal"];
                                }
                            }
                        }
                        
                        // calcula o valor por centro de custo
                        // diferenca entre entradas e saidas
                        // calculo das saídas                        
                        $strSQL  = "SELECT SUM(P.PCL_Valor) AS PCL_ValorTotal FROM FIN_PCL_PARCELAS AS P ";
                        $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                        $strSQL .= "WHERE C.CEN_ID = ".$arrStrDados[$intI]["CEN_ID"]."  AND PC.PLA_Tipo = 'A'  ";
                        $strSQL .= "AND P.PCL_DataBaixa BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                        $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' AND PC.PLA_Movimentacao = 'S' ";
                        $arrStrDadosSaida = Db::getInstance()->select($strSQL);
                        
                        $strValorTotalSaidaContas = 0;
                        
                        if($arrStrDadosSaida != null){
                            if(count($arrStrDadosSaida) > 0){
                                if(trim($arrStrDadosSaida[0]["PCL_ValorTotal"]) != ""){
                                    $strValorTotalSaidaContas = $arrStrDadosSaida[0]["PCL_ValorTotal"];
                                }
                            }
                        }
                        
                        //
                        // Contribuições
                        //
                        $strSQL  = "SELECT SUM(CTB_Valor) AS CTB_ValorTotal FROM FIN_CTB_CONTRIBUICOES AS C ";
                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                        $strSQL .= "WHERE C.CEN_ID = ".$arrStrDados[$intI]["CEN_ID"]." ";
                        $strSQL .= "AND C.CTB_DataContribuicao BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                        $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' AND PC.PLA_Movimentacao = 'E' ";
                        $arrStrDadosEntrada = Db::getInstance()->select($strSQL);
                        
                        $strValorTotalEntradasContribuicoes = 0;
                        
                        if($arrStrDadosEntrada != null){
                            if(count($arrStrDadosEntrada) > 0){
                                if(trim($arrStrDadosEntrada[0]["CTB_ValorTotal"]) != ""){
                                    $strValorTotalEntradasContribuicoes = $arrStrDadosEntrada[0]["CTB_ValorTotal"];
                                }
                            }
                        }
                        
                        $strValorTotalSaidasContribuicoes = 0;                        
                        
                        
                        // soma todas as entradas
                        $strValorTotalEntrada += ($strValorTotalEntradaContas + $strValorTotalEntradasContribuicoes);
                        $douTotalGeralEntradas += $strValorTotalEntrada;
                        
                        $strValorTotalSaida += ($strValorTotalSaidaContas + $strValorTotalSaidasContribuicoes);
                        $douTotalGeralSaidas += $strValorTotalSaida;
                        
                        $douValorFinal = doubleval($strValorTotalEntrada) - doubleval($strValorTotalSaida);
                        
                        $strHtml .= '<td align="right" style="color: blue;">'.NumeroHelper::getInstance()->formatarMoeda($strValorTotalEntrada).'</td>';
                        $strHtml .= '<td align="right" style="color: red;">'.NumeroHelper::getInstance()->formatarMoeda($strValorTotalSaida).'</td>';
                        $strHtml .= '<td align="right">'.NumeroHelper::getInstance()->formatarMoeda($douValorFinal).'</td>';
                    $strHtml .= '</tr>';
                }
                    $douSaldoTotalFinal = doubleval($douTotalGeralEntradas) - doubleval($douTotalGeralSaidas);
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='2'></td>";
                        $strHtml .= "<td style='text-align: right;font-weight: bold;'>Total(R$) ".NumeroHelper::getInstance()->formatarMoeda($douTotalGeralEntradas)."</td>";
                        $strHtml .= "<td style='text-align: right;font-weight: bold;'>Total(R$) ".NumeroHelper::getInstance()->formatarMoeda($douTotalGeralSaidas)."</td>";
                        $strHtml .= "<td style='text-align: right;font-weight: bold;'>Saldo(R$) ".NumeroHelper::getInstance()->formatarMoeda($douSaldoTotalFinal)."</td>";
                    $strHtml .= "</tr>";
                
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='5'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhuma movimenta&ccedil;&atilde;o no per&iacute;odo informado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
            
        }elseif($strAcao == "AnaliticoPorPlanoDeContas"){
            if($_POST["PLA_ID"]>0){
                $strSQL  = "SELECT PLA.* FROM FIN_PLA_PLANOS_CONTAS AS PLA WHERE PLA.PLA_Status = 'A' AND PLA.PLA_Tipo = 'A' AND PLA.PLA_ID = ".$_POST["PLA_ID"]." ORDER BY PLA.PLA_CodigoContabil";
            }else{
                $strSQL  = "SELECT PLA.* FROM FIN_PLA_PLANOS_CONTAS AS PLA WHERE PLA.PLA_Status = 'A' AND PLA.PLA_Tipo = 'A' ORDER BY PLA.PLA_CodigoContabil";
            }            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != null){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Anal&iacute;tico Por Plano de Contas</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Per&iacute;odo de '.$_POST["LCA_DataInicial"].' a '.$_POST["LCA_DataFinal"].'</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                   
                // total geral
                $douValorTotalGeral = 0;                
                $douValorTotalEntradasFinal = 0;
                $douValorTotalSaidasFinal = 0;
                
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    // cada linha das consultas estarão armazenadas em uma linha do array
                    // tendo como objetivo ordená-lo pela data
                    $arrStrHtmlDados = array(); 
                    
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="text-align: left;">'.$arrStrDados[$intI]["PLA_CodigoContabil"]." - ".$arrStrDados[$intI]["PLA_Descricao"].'</td>';                        
                    $strHtml .= '</tr>';
                    
                    $strHtml .= '<tr>';
                    $strHtml .= '<td>';
                        
                        $douValorTotalLancamentosEntrada = 0;
                        $douValorTotalLancamentosSaida = 0;
                    
                        // identifica os lançamentos para o plano de contas em
                        // contribuições, contas a pagar/receber e fluxo de caixa
                        $strHtmlTabelaInicio = '<table style="width: 100%;">';
                        $strHtmlTabelaDados  = '';                        
                        
                            // LANÇAMENTOS CAiXA
                            $strSQL  = "SELECT * FROM FIN_LCA_LANCAMENTOS_CAIXA AS PLA ";
                            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PES ON (PES.PES_ID=PLA.PES_ID) ";
                            $strSQL .= "LEFT JOIN FIN_FOR_FORNECEDORES AS FORNE ON (FORNE.FOR_ID=PLA.FOR_ID) ";
                            $strSQL .= "WHERE PLA.PLA_ID=".$arrStrDados[$intI]["PLA_ID"]." ";
                            $strSQL .= "AND PLA.LCA_DataMovimento BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                            $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' ";
                            $arrStrDadosLancamentos = Db::getInstance()->select($strSQL);
                            
                            for($intY=0; $intY<count($arrStrDadosLancamentos); $intY++){
                                $strClass = 'linhaNormal';
                                
                                if($intY%2 == 0){
                                    $strClass = 'linhaCor';
                                }
                                
                                $strHtmlTabelaDados = '<tr class="'.$strClass.'">';
                                    $strHtmlTabelaDados .= '<td>'.  DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosLancamentos[$intY]["LCA_DataMovimento"]).'</td>';
                                    $strHtmlTabelaDados .= '<td>'.$arrStrDadosLancamentos[$intY]["LCA_Descricao"].'</td>';
                                    $strHtmlTabelaDados .= '<td>'.$arrStrDadosLancamentos[$intY]["LCA_Referencia"].'</td>';
                                    
                                    // exibe o membro/funcionário ou o fornecedor                                    
                                    if(trim($arrStrDadosLancamentos[$intY]["PES_ID"]) != ""){
                                        $strHtmlTabelaDados .= '<td>'.$arrStrDadosLancamentos[$intY]["PES_Nome"].'</td>';
                                    }else{
                                        $strHtmlTabelaDados .= '<td>'.$arrStrDadosLancamentos[$intY]["FOR_NomeFantasia"].'</td>';
                                    }
                                     
                                    $strSinal = "";
                                    $strStyle = "color: blue;";
                                    
                                    // saída coloca o sinal de MENOS (-) na frente do valor
                                    if($arrStrDadosLancamentos[$intY]["LCA_Tipo"] == "S"){
                                        $strStyle = "color: red;";
                                        $strSinal = "-";
                                        $douValorTotalLancamentosSaida += doubleval($arrStrDadosLancamentos[$intY]["LCA_Valor"]);
                                    }else{
                                        $douValorTotalLancamentosEntrada += doubleval($arrStrDadosLancamentos[$intY]["LCA_Valor"]);
                                    }
                                    
                                    $strHtmlTabelaDados .= '<td align="right" style="'.$strStyle.'">'.$strSinal.NumeroHelper::getInstance()->formatarMoeda($arrStrDadosLancamentos[$intY]["LCA_Valor"]).'</td>';
                                $strHtmlTabelaDados .= '</tr>';
                                
                                // guarda a linha
                                $arrStrHtmlDados[$arrStrDadosLancamentos[$intY]["LCA_DataMovimento"]][] = $strHtmlTabelaDados;
                            }
                            
                            // CONTAS A PAGAR/RECEBER
                            $strSQL  = "SELECT * FROM FIN_PCL_PARCELAS AS P ";
                            $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PES ON (PES.PES_ID=C.PES_ID) ";
                            $strSQL .= "LEFT JOIN FIN_FOR_FORNECEDORES AS FORNE ON (FORNE.FOR_ID=C.FOR_ID) ";
                            $strSQL .= "WHERE C.PLA_ID = ".$arrStrDados[$intI]["PLA_ID"]." ";
                            $strSQL .= "AND P.PCL_DataBaixa BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                            $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."'";
                            $arrStrDadosContasPagarReceber = Db::getInstance()->select($strSQL);
                            
                            for($intY=0; $intY<count($arrStrDadosContasPagarReceber); $intY++){
                                $strClass = 'linhaNormal';
                                
                                if($intY%2 == 0){
                                    $strClass = 'linhaCor';
                                }
                                
                                $strHtmlTabelaDados = '<tr class="'.$strClass.'">';
                                    $strHtmlTabelaDados .= '<td>'.  DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosContasPagarReceber[$intY]["PCL_DataBaixa"]).'</td>';
                                    $strHtmlTabelaDados .= '<td>'.$arrStrDadosContasPagarReceber[$intY]["CON_Descricao"].'</td>';
                                    $strHtmlTabelaDados .= '<td>'.$arrStrDadosContasPagarReceber[$intY]["PCL_Referencia"].'</td>';
                                    
                                    // exibe o membro/funcionário ou o fornecedor                                    
                                    if(trim($arrStrDadosContasPagarReceber[$intY]["PES_ID"]) != ""){
                                        $strHtmlTabelaDados .= '<td>'.$arrStrDadosContasPagarReceber[$intY]["PES_Nome"].'</td>';
                                    }else{
                                        $strHtmlTabelaDados .= '<td>'.$arrStrDadosContasPagarReceber[$intY]["FOR_NomeFantasia"].'</td>';
                                    }
                                     
                                    $strSinal = "";
                                    $strStyle = "color: blue;";
                                    
                                    // saída coloca o sinal de MENOS (-) na frente do valor
                                    if($arrStrDadosContasPagarReceber[$intY]["CON_Tipo"] == "P"){
                                        $strStyle = "color: red;";
                                        $strSinal = "-";
                                        $douValorTotalLancamentosSaida += doubleval($arrStrDadosContasPagarReceber[$intY]["PCL_Valor"]);
                                    }else{
                                        $douValorTotalLancamentosEntrada += doubleval($arrStrDadosContasPagarReceber[$intY]["PCL_Valor"]);
                                    }
                                    
                                    $strHtmlTabelaDados .= '<td align="right" style="'.$strStyle.'">'.$strSinal.NumeroHelper::getInstance()->formatarMoeda($arrStrDadosContasPagarReceber[$intY]["PCL_Valor"]).'</td>';
                                $strHtmlTabelaDados .= '</tr>';
                                
                                // guarda a linha
                                $arrStrHtmlDados[$arrStrDadosContasPagarReceber[$intY]["PCL_DataBaixa"]][] = $strHtmlTabelaDados;
                            }   
                            
                            // CONTRIBUIÇÕES
                            $strSQL  = "SELECT * FROM FIN_CTB_CONTRIBUICOES AS C ";
                            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PES ON (PES.PES_ID=C.PES_ID) ";                            
                            $strSQL .= "WHERE C.PLA_ID = ".$arrStrDados[$intI]["PLA_ID"]." ";
                            $strSQL .= "AND C.CTB_DataContribuicao BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' ";
                            $strSQL .= "AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' ";
                            $arrStrDadosContribuicoes = Db::getInstance()->select($strSQL);
                                                        
                            for($intY=0; $intY<count($arrStrDadosContribuicoes); $intY++){
                                $strClass = 'linhaNormal';
                                
                                if($intY%2 == 0){
                                    $strClass = 'linhaCor';
                                }
                                
                                $strHtmlTabelaDados = '<tr class="'.$strClass.'">';
                                    $strHtmlTabelaDados .= '<td>'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosContribuicoes[$intY]["CTB_DataContribuicao"]).'</td>';
                                    $strHtmlTabelaDados .= '<td>CONTRIBUIÇÃO</td>';
                                    $strHtmlTabelaDados .= '<td>'.$arrStrDadosContribuicoes[$intY]["CTB_Referencia"].'</td>';
                                    
                                    // exibe o membro/funcionário ou o fornecedor                                    
                                    if(trim($arrStrDadosContribuicoes[$intY]["PES_ID"]) != ""){
                                        $strHtmlTabelaDados .= '<td>'.$arrStrDadosContribuicoes[$intY]["PES_Nome"].'</td>';
                                    }else{
                                        $strHtmlTabelaDados .= '<td>NÃO IDENTIFICADO</td>';
                                    }
                                     
                                    $strSinal = "";
                                    $strStyle = "color: blue;";
                                    
                                    // na contribuição só existe entrada
                                    $douValorTotalLancamentosEntrada += doubleval($arrStrDadosContribuicoes[$intY]["CTB_Valor"]);
                                    
                                    $strHtmlTabelaDados .= '<td align="right" style="'.$strStyle.'">'.$strSinal.NumeroHelper::getInstance()->formatarMoeda($arrStrDadosContribuicoes[$intY]["CTB_Valor"]).'</td>';
                                $strHtmlTabelaDados .= '</tr>';
                                
                                // guarda a linha
                                $arrStrHtmlDados[$arrStrDadosContribuicoes[$intY]["CTB_DataContribuicao"]][] = $strHtmlTabelaDados;
                            }  
                            
                            // $douValorTotalGeral += ($douValorTotalLancamentosEntrada - $douValorTotalLancamentosSaida);
                            
                            $strHtmlCabecalho = '';
                            $strHtmlRodape = '';
                            
                            // cabeçalho/rodapé do relatório
                            if(count($arrStrDadosLancamentos) > 0 || count($arrStrDadosContasPagarReceber) > 0 || count($arrStrDadosContribuicoes) > 0){
                                $strHtmlCabecalho = '<tr>';
                                    $strHtmlCabecalho .= '<td style="text-align: left; width: 80px; font-weight: bold;">Data</td>';
                                    $strHtmlCabecalho .= '<td style="text-align: left; width: 420px; font-weight: bold;">Hist&oacute;rico</td>';
                                    $strHtmlCabecalho .= '<td style="text-align: left; width: 60px; font-weight: bold;">Ref.</td>';
                                    $strHtmlCabecalho .= '<td style="text-align: left; width: 300px; font-weight: bold;">Origem/Destino</td>';
                                    $strHtmlCabecalho .= '<td style="text-align: right;width: 120px; font-weight: bold;">Valor(R$)</td>';
                                $strHtmlCabecalho .= '</tr>';
                                
                                $strHtmlRodape = '<tr>';
                                    $strHtmlRodape .= '<td colspan="4" style="font-weight: bold; text-align: right;">Total(R$): </td>';
                                    $strHtmlRodape .= '<td style="font-weight: bold; text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda(($douValorTotalLancamentosEntrada - $douValorTotalLancamentosSaida)).'</td>';
                                $strHtmlRodape .= '</tr>';                                
                            }else{
                                $strHtmlTabelaDados .= '<tr>';
                                    $strHtmlTabelaDados .= '<td>Nenhum lançamento para o per&iacute;odo informado.</td>';                                    
                                $strHtmlTabelaDados .= '</tr>';
                                
                                $arrStrHtmlDados["MSG_SEM_LANCAMENTOS"][] = $strHtmlTabelaDados;
                            }
                            
                            $douValorTotalGeral += ($douValorTotalLancamentosEntrada - $douValorTotalLancamentosSaida);
                            
                            $douValorTotalEntradasFinal += $douValorTotalLancamentosEntrada;
                            $douValorTotalSaidasFinal += $douValorTotalLancamentosSaida;
                        $strHtmlTabelaFim = '</table>';
                        
                        // ordena o array pelo índice
                        // o índice corresponde a data
                        ksort($arrStrHtmlDados);
                        
                        // monta o HTML FINAL do Registro do Plano de Contas
                        $strHtml .= $strHtmlTabelaInicio;
                            $strHtml .= $strHtmlCabecalho;
                            
                            $intContador = 0;
                            
                            if($arrStrHtmlDados != null){
                                if(count($arrStrHtmlDados) > 0){
                                    foreach ($arrStrHtmlDados as $arrValores){
                                        for($intF=0; $intF<count($arrValores); $intF++){
                                            $strHtml .= $arrValores[$intF];
                                        }
                                    }
                                }
                            }
                            
                            $strHtml .= $strHtmlRodape;
                        $strHtml .= $strHtmlTabelaFim;
                        
                    $strHtml .= '</td>';
                    $strHtml .= '</tr>';
                }   
                
                    $strHtml .= '<tr>';                        
                        $strHtml .= '<td style="font-weight: bold; text-align: center;">Total Entradas(R$): <span style="color:green; margin-right: 20px;">'.NumeroHelper::getInstance()->formatarMoeda($douValorTotalEntradasFinal).'</span> Total Saídas(R$): <span style="color:red; margin-right: 20px;">'.NumeroHelper::getInstance()->formatarMoeda($douValorTotalSaidasFinal).'</span> Saldo(R$): '.NumeroHelper::getInstance()->formatarMoeda($douValorTotalGeral).'</td>';
                    $strHtml .= '</tr>';
                    
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhuma movimenta&ccedil;&atilde;o no per&iacute;odo informado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }elseif($strAcao == "BalanceteFinanceiro"){
            $strSQL  = "SELECT PLA.* FROM FIN_PLA_PLANOS_CONTAS AS PLA WHERE PLA.PLA_Status = 'A' ";
            $strSQL .= "AND PLA.PLA_Tipo = 'S' AND PLA.PLA_CodigoContabil = '1' OR PLA.PLA_CodigoContabil = '2' ORDER BY PLA.PLA_CodigoContabil";
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != null){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Balancete Financeiro</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Mês: '.$_POST["BAL_MesDescricao"].' Ano: '.$_POST["BAL_Ano"].'</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                   
                // total geral
                $douValorTotalGeral = 0;                
                
                $strHtml .= '<tr class="cabecalhoTabela">';
                    $strHtml .= '<td style="text-align: left; width: 800px;">Discriminação</td>';  
                    $strHtml .= '<td style="text-align: right;width: 100px;">Receitas</td>'; 
                    $strHtml .= '<td style="text-align: right;width: 100px;">Despesas</td>'; 
                $strHtml .= '</tr>';
                
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    // cada linha das consultas estarão armazenadas em uma linha do array
                    // tendo como objetivo ordená-lo pela data
                    $arrStrHtmlDados = array(); 
                    
                    // calcula o total de entradas e saídas para RECEITAS E DESPESAS
                    $douTotalEntradaAnalitico = 0;
                    $douTotalSaidaAnalitico = 0;
                    
                    // fluxo de caixa
                    $strSQL  = "SELECT SUM(L.LCA_Valor) AS TotalEntrada FROM FIN_LCA_LANCAMENTOS_CAIXA AS L ";
                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=L.PLA_ID) ";
                    $strSQL .= "WHERE P.PLA_CodigoContabil LIKE '".$arrStrDados[$intI]["PLA_CodigoContabil"].".%' AND P.PLA_Tipo = 'A' ";
                    $strSQL .= "AND L.LCA_Tipo = 'E' AND L.LCA_DataMovimento BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                    $arrStrDadosTotalFluxoEntradas = Db::getInstance()->select($strSQL);
                    
                    if($arrStrDadosTotalFluxoEntradas != null){
                        if(count($arrStrDadosTotalFluxoEntradas) > 0){
                            $douTotalEntradaAnalitico += doubleval($arrStrDadosTotalFluxoEntradas[0]["TotalEntrada"]);
                        }
                    }
                    
                    $strSQL  = "SELECT SUM(L.LCA_Valor) AS TotalSaida FROM FIN_LCA_LANCAMENTOS_CAIXA AS L ";
                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=L.PLA_ID) ";
                    $strSQL .= "WHERE P.PLA_CodigoContabil LIKE '".$arrStrDados[$intI]["PLA_CodigoContabil"].".%' AND P.PLA_Tipo = 'A' ";
                    $strSQL .= "AND L.LCA_Tipo = 'S' AND L.LCA_DataMovimento BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                    $arrStrDadosTotalFluxoSaidas = Db::getInstance()->select($strSQL);
                    
                    if($arrStrDadosTotalFluxoSaidas != null){
                        if(count($arrStrDadosTotalFluxoSaidas) > 0){
                            $douTotalSaidaAnalitico += doubleval($arrStrDadosTotalFluxoSaidas[0]["TotalSaida"]);
                        }
                    }
                    
                    // contas a pagar/receber
                    $strSQL  = "SELECT SUM(P.PCL_Valor) AS TotalEntrada FROM FIN_PCL_PARCELAS AS P ";
                    $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                    $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDados[$intI]["PLA_CodigoContabil"].".%' AND PC.PLA_Tipo = 'A' ";
                    $strSQL .= "AND C.CON_Tipo = 'R' AND P.PCL_DataBaixa BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                    $arrStrDadosTotalContaEntradas = Db::getInstance()->select($strSQL);
                    
                    if($arrStrDadosTotalContaEntradas != null){
                        if(count($arrStrDadosTotalContaEntradas) > 0){
                            $douTotalEntradaAnalitico += doubleval($arrStrDadosTotalContaEntradas[0]["TotalEntrada"]);
                        }
                    }
                    
                    $strSQL  = "SELECT SUM(P.PCL_Valor) AS TotalSaida FROM FIN_PCL_PARCELAS AS P ";
                    $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                    $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDados[$intI]["PLA_CodigoContabil"].".%' AND PC.PLA_Tipo = 'A' ";
                    $strSQL .= "AND C.CON_Tipo = 'P' AND P.PCL_DataBaixa BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                    $arrStrDadosTotalContaSaidas = Db::getInstance()->select($strSQL);
                    
                    if($arrStrDadosTotalContaSaidas != null){
                        if(count($arrStrDadosTotalContaSaidas) > 0){
                            $douTotalSaidaAnalitico += doubleval($arrStrDadosTotalContaSaidas[0]["TotalSaida"]);
                        }
                    }
                    
                    // contribuições
                    $strSQL  = "SELECT SUM(C.CTB_Valor) AS TotalEntrada FROM FIN_CTB_CONTRIBUICOES AS C ";
                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                    $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDados[$intI]["PLA_CodigoContabil"].".%' AND PC.PLA_Tipo = 'A' ";
                    $strSQL .= "AND C.CTB_DataContribuicao BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                    $arrStrDadosTotalContribuicaoEntradas = Db::getInstance()->select($strSQL);
                    
                    if($arrStrDadosTotalContribuicaoEntradas != null){
                        if(count($arrStrDadosTotalContribuicaoEntradas) > 0){
                            $douTotalEntradaAnalitico += doubleval($arrStrDadosTotalContribuicaoEntradas[0]["TotalEntrada"]);
                        }
                    }
                    
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="text-align: left;">'.$arrStrDados[$intI]["PLA_CodigoContabil"]." ".$arrStrDados[$intI]["PLA_Descricao"].'</td>';  
                        $strHtml .= '<td style="text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda($douTotalEntradaAnalitico).'</td>'; 
                        $strHtml .= '<td style="text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda($douTotalSaidaAnalitico).'</td>'; 
                    $strHtml .= '</tr>';
                    
                    // calcula o total de entradas e saídas de contas sintéticas associadas as contas RECEITAS E DESPESAS
                    $strSQL  = "SELECT PLA.* FROM FIN_PLA_PLANOS_CONTAS AS PLA WHERE PLA.PLA_Status = 'A' ";
                    $strSQL .= "AND PLA.PLA_Tipo = 'S' AND PLA.PLA_CodigoContabil LIKE '".$arrStrDados[$intI]["PLA_CodigoContabil"].".%' ";
                    $strSQL .= "ORDER BY PLA.PLA_CodigoContabil";
                    $arrStrDadosSinteticaFilha = Db::getInstance()->select($strSQL);
                    
                    if(count($arrStrDadosSinteticaFilha) > 0){
                        for($intW=0; $intW<count($arrStrDadosSinteticaFilha); $intW++){
                            // verifica se existe os analíticos amarrados ao sintético
                            $strSQL = "SELECT * FROM FIN_PLA_PLANOS_CONTAS WHERE PLA_Status = 'A' AND PLA_CodigoContabilPai = '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"]."' ";
                            $arrStrDadosAnaliticosExistentes = Db::getInstance()->select($strSQL);

                            if($arrStrDadosAnaliticosExistentes != null){
                                if(count($arrStrDadosAnaliticosExistentes) > 0){
                                    // cálculo dos totais das filhas
                                    $douTotalEntradaAnaliticoFilhas = 0;
                                    $douTotalSaidaAnaliticoFilhas = 0;

                                    // fluxo de caixa
                                    $strSQL  = "SELECT SUM(L.LCA_Valor) AS TotalEntrada FROM FIN_LCA_LANCAMENTOS_CAIXA AS L ";
                                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=L.PLA_ID) ";
                                    $strSQL .= "WHERE P.PLA_CodigoContabil LIKE '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"].".%' AND P.PLA_Tipo = 'A' ";
                                    $strSQL .= "AND L.LCA_Tipo = 'E' AND L.LCA_DataMovimento BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                    $arrStrDadosTotalFluxoEntradas = Db::getInstance()->select($strSQL);

                                    if($arrStrDadosTotalFluxoEntradas != null){
                                        if(count($arrStrDadosTotalFluxoEntradas) > 0){
                                            $douTotalEntradaAnaliticoFilhas += doubleval($arrStrDadosTotalFluxoEntradas[0]["TotalEntrada"]);
                                        }
                                    }

                                    $strSQL  = "SELECT SUM(L.LCA_Valor) AS TotalSaida FROM FIN_LCA_LANCAMENTOS_CAIXA AS L ";
                                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=L.PLA_ID) ";
                                    $strSQL .= "WHERE P.PLA_CodigoContabil LIKE '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"].".%' AND P.PLA_Tipo = 'A' ";
                                    $strSQL .= "AND L.LCA_Tipo = 'S' AND L.LCA_DataMovimento BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                    $arrStrDadosTotalFluxoSaidas = Db::getInstance()->select($strSQL);

                                    if($arrStrDadosTotalFluxoSaidas != null){
                                        if(count($arrStrDadosTotalFluxoSaidas) > 0){
                                            $douTotalSaidaAnaliticoFilhas += doubleval($arrStrDadosTotalFluxoSaidas[0]["TotalSaida"]);
                                        }
                                    }

                                    // contas a pagar/receber
                                    $strSQL  = "SELECT SUM(P.PCL_Valor) AS TotalEntrada FROM FIN_PCL_PARCELAS AS P ";
                                    $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                                    $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"].".%' AND PC.PLA_Tipo = 'A' ";
                                    $strSQL .= "AND C.CON_Tipo = 'R' AND P.PCL_DataBaixa BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                    $arrStrDadosTotalContaEntradas = Db::getInstance()->select($strSQL);

                                    if($arrStrDadosTotalContaEntradas != null){
                                        if(count($arrStrDadosTotalContaEntradas) > 0){
                                            $douTotalEntradaAnaliticoFilhas += doubleval($arrStrDadosTotalContaEntradas[0]["TotalEntrada"]);
                                        }
                                    }

                                    $strSQL  = "SELECT SUM(P.PCL_Valor) AS TotalSaida FROM FIN_PCL_PARCELAS AS P ";
                                    $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                                    $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"].".%' AND PC.PLA_Tipo = 'A' ";
                                    $strSQL .= "AND C.CON_Tipo = 'P' AND P.PCL_DataBaixa BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                    $arrStrDadosTotalContaSaidas = Db::getInstance()->select($strSQL);

                                    if($arrStrDadosTotalContaSaidas != null){
                                        if(count($arrStrDadosTotalContaSaidas) > 0){
                                            $douTotalSaidaAnaliticoFilhas += doubleval($arrStrDadosTotalContaSaidas[0]["TotalSaida"]);
                                        }
                                    }

                                    // contribuições
                                    $strSQL  = "SELECT SUM(C.CTB_Valor) AS TotalEntrada FROM FIN_CTB_CONTRIBUICOES AS C ";
                                    $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                                    $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"].".%' AND PC.PLA_Tipo = 'A' ";
                                    $strSQL .= "AND C.CTB_DataContribuicao BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                    $arrStrDadosTotalContribuicaoEntradas = Db::getInstance()->select($strSQL);

                                    if($arrStrDadosTotalContribuicaoEntradas != null){
                                        if(count($arrStrDadosTotalContribuicaoEntradas) > 0){
                                            $douTotalEntradaAnaliticoFilhas += doubleval($arrStrDadosTotalContribuicaoEntradas[0]["TotalEntrada"]);
                                        }
                                    }

                                    $strHtml .= '<tr class="cabecalhoTabela">';
                                        $strHtml .= '<td style="text-align: left;">'.$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"]." ".$arrStrDadosSinteticaFilha[$intW]["PLA_Descricao"].'</td>';  
                                        $strHtml .= '<td style="text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda($douTotalEntradaAnaliticoFilhas).'</td>'; 
                                        $strHtml .= '<td style="text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda($douTotalSaidaAnaliticoFilhas).'</td>'; 
                                    $strHtml .= '</tr>';

                                    // contas analíticas com suas sequências obedecendo a ordem das contas sintéticas filhas
                                    $strSQL  = "SELECT PLA.* FROM FIN_PLA_PLANOS_CONTAS AS PLA WHERE PLA.PLA_Status = 'A' ";
                                    $strSQL .= "AND PLA.PLA_Tipo = 'A' AND PLA.PLA_CodigoContabil LIKE '".$arrStrDadosSinteticaFilha[$intW]["PLA_CodigoContabil"].".%' ";
                                    $strSQL .= "ORDER BY PLA.PLA_CodigoContabil";
                                    $arrStrDadosAnaliticas = Db::getInstance()->select($strSQL);

                                    for($intZ=0; $intZ<count($arrStrDadosAnaliticas); $intZ++){
                                        // cálculo dos totais das filhas
                                        $douTotalEntradaAnali = 0;
                                        $douTotalSaidaAnali = 0;

                                        // fluxo de caixa
                                        $strSQL  = "SELECT SUM(L.LCA_Valor) AS TotalEntrada FROM FIN_LCA_LANCAMENTOS_CAIXA AS L ";
                                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=L.PLA_ID) ";
                                        $strSQL .= "WHERE P.PLA_CodigoContabil = '".$arrStrDadosAnaliticas[$intZ]["PLA_CodigoContabil"]."' AND P.PLA_Tipo = 'A' ";
                                        $strSQL .= "AND L.LCA_Tipo = 'E' AND L.LCA_DataMovimento BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                        $arrStrDadosTotalFluxoEntradas = Db::getInstance()->select($strSQL);

                                        if($arrStrDadosTotalFluxoEntradas != null){
                                            if(count($arrStrDadosTotalFluxoEntradas) > 0){
                                                $douTotalEntradaAnali += doubleval($arrStrDadosTotalFluxoEntradas[0]["TotalEntrada"]);
                                            }
                                        }

                                        $strSQL  = "SELECT SUM(L.LCA_Valor) AS TotalSaida FROM FIN_LCA_LANCAMENTOS_CAIXA AS L ";
                                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=L.PLA_ID) ";
                                        $strSQL .= "WHERE P.PLA_CodigoContabil = '".$arrStrDadosAnaliticas[$intZ]["PLA_CodigoContabil"]."' AND P.PLA_Tipo = 'A' ";
                                        $strSQL .= "AND L.LCA_Tipo = 'S' AND L.LCA_DataMovimento BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                        $arrStrDadosTotalFluxoSaidas = Db::getInstance()->select($strSQL);

                                        if($arrStrDadosTotalFluxoSaidas != null){
                                            if(count($arrStrDadosTotalFluxoSaidas) > 0){
                                                $douTotalSaidaAnali += doubleval($arrStrDadosTotalFluxoSaidas[0]["TotalSaida"]);
                                            }
                                        }

                                        // contas a pagar/receber
                                        $strSQL  = "SELECT SUM(P.PCL_Valor) AS TotalEntrada FROM FIN_PCL_PARCELAS AS P ";
                                        $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                                        $strSQL .= "WHERE PC.PLA_CodigoContabil = '".$arrStrDadosAnaliticas[$intZ]["PLA_CodigoContabil"]."' AND PC.PLA_Tipo = 'A' ";
                                        $strSQL .= "AND C.CON_Tipo = 'R' AND P.PCL_DataBaixa BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                        $arrStrDadosTotalContaEntradas = Db::getInstance()->select($strSQL);

                                        if($arrStrDadosTotalContaEntradas != null){
                                            if(count($arrStrDadosTotalContaEntradas) > 0){
                                                $douTotalEntradaAnali += doubleval($arrStrDadosTotalContaEntradas[0]["TotalEntrada"]);
                                            }
                                        }

                                        $strSQL  = "SELECT SUM(P.PCL_Valor) AS TotalSaida FROM FIN_PCL_PARCELAS AS P ";
                                        $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
                                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                                        $strSQL .= "WHERE PC.PLA_CodigoContabil LIKE '".$arrStrDadosAnaliticas[$intZ]["PLA_CodigoContabil"]."' AND PC.PLA_Tipo = 'A' ";
                                        $strSQL .= "AND C.CON_Tipo = 'P' AND P.PCL_DataBaixa BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                        $arrStrDadosTotalContaSaidas = Db::getInstance()->select($strSQL);

                                        if($arrStrDadosTotalContaSaidas != null){
                                            if(count($arrStrDadosTotalContaSaidas) > 0){
                                                $douTotalSaidaAnali += doubleval($arrStrDadosTotalContaSaidas[0]["TotalSaida"]);
                                            }
                                        }

                                        // contribuições
                                        $strSQL  = "SELECT SUM(C.CTB_Valor) AS TotalEntrada FROM FIN_CTB_CONTRIBUICOES AS C ";
                                        $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
                                        $strSQL .= "WHERE PC.PLA_CodigoContabil = '".$arrStrDadosAnaliticas[$intZ]["PLA_CodigoContabil"]."' AND PC.PLA_Tipo = 'A' ";
                                        $strSQL .= "AND C.CTB_DataContribuicao BETWEEN '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-01' AND '".$_POST["BAL_Ano"]."-".$_POST["BAL_Mes"]."-31' ";
                                        $arrStrDadosTotalContribuicaoEntradas = Db::getInstance()->select($strSQL);

                                        if($arrStrDadosTotalContribuicaoEntradas != null){
                                            if(count($arrStrDadosTotalContribuicaoEntradas) > 0){
                                                $douTotalEntradaAnali += doubleval($arrStrDadosTotalContribuicaoEntradas[0]["TotalEntrada"]);
                                            }
                                        }

                                        if($douTotalEntradaAnali != 0 || $douTotalSaidaAnali != 0){
                                            $strHtml .= '<tr>';
                                                $strHtml .= '<td style="text-align: left;">'.$arrStrDadosAnaliticas[$intZ]["PLA_CodigoContabil"]." ".$arrStrDadosAnaliticas[$intZ]["PLA_Descricao"].'</td>';  
                                                $strHtml .= '<td style="text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda($douTotalEntradaAnali).'</td>'; 
                                                $strHtml .= '<td style="text-align: right;">'.NumeroHelper::getInstance()->formatarMoeda($douTotalSaidaAnali).'</td>'; 
                                            $strHtml .= '</tr>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }   
                
                    /*$strHtml .= '<tr>';                        
                        $strHtml .= '<td style="font-weight: bold; text-align: right;">Total Geral(R$): '.NumeroHelper::getInstance()->formatarMoeda($douValorTotalGeral).'</td>';
                    $strHtml .= '</tr>';*/
                    
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhuma movimenta&ccedil;&atilde;o no per&iacute;odo informado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        
        
        elseif($strAcao == "Fornecedor"){ 
            $strSQL = "SELECT * FROM FIN_FOR_FORNECEDORES WHERE FOR_ID IS NOT NULL ";
            
            if(!empty($_POST["FOR_Tipo"])){
                $strSQL .= "AND FOR_Tipo = '".$_POST["FOR_Tipo"]."' ";
            }
            
            $strSQL .= "ORDER BY FOR_NomeFantasia ";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != ""){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Fornecedores</h1>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 60px; text-align: left;">C&oacute;d.</td>';
                        $strHtml .= '<td>Nome/Nome Fantasia</td>';
                        $strHtml .= '<td>Razão Social</td>';
                        $strHtml .= '<td style="width: 120px;">CPF/CNPJ</td>';
                        $strHtml .= '<td style="width: 100px; text-align: left;">Telefone</td>';
                        $strHtml .= '<td style="width: 200px; text-align: left;">Email</td>';
                        $strHtml .= '<td style="width: 300px; text-align: left;">Ramo de Atividade</td>';
                    $strHtml .= '</tr>';
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';

                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }

                        $strHtml .= '<tr class="'.$strClass.'">';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FOR_ID"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FOR_NomeFantasia"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FOR_RazaoSocial"].'</td>';
                            $strHtml .= '<td>'.trim(DocumentacaoHelper::getInstance()->formatarCPFCNPJ($arrStrDados[$intI]["FOR_CNPJ"])).'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FOR_Telefone"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FOR_Email"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FOR_RamoAtividade"].'</td>';
                        $strHtml .= '</tr>';    
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='7'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum fornecedor cadastrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        
        
        
        
        
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>