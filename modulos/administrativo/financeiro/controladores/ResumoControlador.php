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
            //lista todas as categorias, pega cada uma e conta quantos membro cada uma tem            
            //BUSCA AS CATEGORIAS
            $arrStrFiltros = array();
            $arrStrFiltros["CAP_Situacao"] = "NAO LIQUIDADO";
            $arrObjs  = FachadaFinanceiro::getInstance()->consultarContaAPagar($arrStrFiltros);
            $douTotal = $arrObjs["totalLancamentos"];
            $arrObjs  = $arrObjs["rows"];
                  
            
            $arrDados = array();
            $arrDados["chart"]["title"] = "Lembretes Financeiros";
            $arrDados["chart"]["text"] = "Texto";
            $strHtml = '';
            $arrDataGrafico = array();        
            //$strHtml .= '<fieldset style="margin-top: 20px;">';
            $strHtml .= '<table cellpadding="5" cellspacing="0" width="100%">';
            $strHtml .= '<tr>';
                $strHtml .= '<td>';
                    $strHtml .= 'Pagamentos em aberto (Contas à Pagar)';
                $strHtml .= '</td>';
            $strHtml .= '</tr>';
            $strHtml .= '<tr>';
                $strHtml .= '<td>';
                //$strHtml .= '<legend>Recebimentos em aberto (Contas &agrave; Receber)</legend>';
                $strHtml .= '<table id="dadosRelatorioPagamentos" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                                $strHtml .= '<tr class="cabecalhoTabela">';
                                    $strHtml .= '<td width="5%">Cód.</td>';
                                    $strHtml .= '<td width="10%" align="center">Data Venc.</td>';
                                    $strHtml .= '<td width="20%">Descrição</td>';
                                    $strHtml .= '<td width="10%" align="right">Valor Total (R$)</td>'; 
                                    $strHtml .= '<td width="10%" align="right">Valor Pago (R$)</td>';    
                                    $strHtml .= '<td width="20%" align="center">Núm. Doc.</td>';
                                    $strHtml .= '<td width="20%" align="center">Recebimento</td>';
                                    $strHtml .= '<td width="5%" align="center">Atraso</td>';
                                $strHtml .= '</tr>';

                            
                            
                            
                            
                            
            $classDif='';     
            if(count($arrObjs) > 0){
                for($intI=0; $intI<count($arrObjs); $intI++){                
                    $classDif = 'class="linhaNormal"';
                    if($intI%2 == 0){
                        $classDif = 'class="linhaCor"';
                    }                    
                    $strHtml .= '<tr '.$classDif.'>';
                        $strHtml .= '<td>'.$arrObjs[$intI]["CAP_ID"].'</td>';
                        $strHtml .= '<td align="center">'.$arrObjs[$intI]["CAP_DataVencimento"].'</td>';
                        $strHtml .= '<td>'.$arrObjs[$intI]["CAP_Descricao"].'</td>';
                        $strHtml .= '<td align="right">'.$arrObjs[$intI]["CAP_Valor"].'</td>';
                        $strHtml .= '<td align="right">'.$arrObjs[$intI]["CAP_ValorRecebido"].'</td>';
                        $strHtml .= '<td align="center">'.$arrObjs[$intI]["CAP_Numero"].'</td>';
                        $strHtml .= '<td align="center">'.$arrObjs[$intI]["CAP_SituacaoPagamento"].'</td>';
                        $strCor = '';
                        if($arrObjs[$intI]["CAP_DiasAtraso"] > 0){
                            $strCor = 'style="background-color: #FF4242; color: #FFF;"';
                        }
                        $strHtml .= '<td align="center" '.$strCor.'>'.$arrObjs[$intI]["CAP_DiasAtraso"].' dia(s)</td>';
                    $strHtml .= '</tr>';
                }
                $strHtml .= '<tr>';
                        $strHtml .= '<td colspan="3" align="right"><b>Total</b></td>';
                        $strHtml .= '<td align="right"><b>'.$douTotal.'</b></td>';
                        $strHtml .= '<td align="right" colspan="4"></td>';                                
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum pagamento em aberto.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '<table>';
            }
            $strHtml .= '</td>';
            $strHtml .= '</tr>';
            
            
            
            $arrStrFiltros = array();
            $arrStrFiltros["CAR_Situacao"] = "NAO LIQUIDADO";
            $arrObjs  = FachadaFinanceiro::getInstance()->consultarContaAReceber($arrStrFiltros);
            $douTotal = $arrObjs["totalLancamentos"];
            $arrObjs  = $arrObjs["rows"];            
            
            if($arrObjs != null){
                
                $strHtml .= '<tr>';
                $strHtml .= '<td>';
                        $strHtml .= 'Recebimentos em aberto (Contas &agrave; Receber) ';
                $strHtml .= '</td>';
                $strHtml .= '</tr>';
                $strHtml .= '<tr>';
                $strHtml .= '<td>';
                
                
                //$strHtml .= '<legend>Pagamentos em aberto (Contas &agrave; Pagar)</legend>';
                $strHtml .= '<table id="dadosRelatorioRecebimento" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td width="5%">Cód.</td>';
                        $strHtml .= '<td width="10%" align="center">Data Venc.</td>';
                        $strHtml .= '<td width="20%">Descrição</td>';
                        $strHtml .= '<td width="10%" align="right">Valor Total (R$)</td>'; 
                        $strHtml .= '<td width="10%" align="right">Valor Pago (R$)</td>';    
                        $strHtml .= '<td width="20%" align="center">Núm. Doc.</td>';
                        $strHtml .= '<td width="20%" align="center">Recebimento</td>';
                        $strHtml .= '<td width="5%" align="center">Atraso</td>';
                    $strHtml .= '</tr>';

                    $strClassDif = '';

                    for($intI=0; $intI<count($arrObjs); $intI++){
                        $strClassDif = 'class="linhaNormal"';

                        if($intI%2 == 0){
                            $strClassDif = 'class="linhaCor"';
                        }

                        $strHtml .= '<tr '.$strClassDif.'>';
                            $strHtml .= '<td>'.$arrObjs[$intI]["CAR_ID"].'</td>';
                            $strHtml .= '<td align="center">'.$arrObjs[$intI]["CAR_DataConta"].'</td>';
                            $strHtml .= '<td>'.$arrObjs[$intI]["CAR_Descricao"].'</td>';
                            $strHtml .= '<td align="right">'.$arrObjs[$intI]["CAR_Valor"].'</td>';
                            $strHtml .= '<td align="right">'.$arrObjs[$intI]["CAR_ValorRecebido"].'</td>';
                            $strHtml .= '<td align="center">'.$arrObjs[$intI]["CAR_Numero"].'</td>';
                            $strHtml .= '<td align="center">'.$arrObjs[$intI]["CAR_SituacaoPagamento"].'</td>';

                            $strCor = '';

                            if($arrObjs[$intI]["CAR_DiasAtraso"] > 0){
                                $strCor = 'style="background-color: #FF4242; color: #FFF;"';
                            }

                            $strHtml .= '<td align="center" '.$strCor.'>'.$arrObjs[$intI]["CAR_DiasAtraso"].' dia(s)</td>';
                        $strHtml .= '</tr>';
                    }

                    $strHtml .= '<tr>';
                        $strHtml .= '<td colspan="3" align="right"><b>Total</b></td>';
                        $strHtml .= '<td align="right"><b>'.$douTotal.'</b></td>';
                        $strHtml .= '<td align="right" colspan="4"></td>';                                
                    $strHtml .= '</tr>';

                $strHtml .= '</table>';
            }else{                        
                $strHtml .= '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum recebimento em aberto.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '<table>';
            }
            
            $strHtml .= '</td>';
            $strHtml .= '</tr>';
            $strHtml .= '</table>';
            $arrDados["EXCEL"] = $strHtml; 

            $arrFiltroParametro = "";
            $arrDadosParametro = FachadaGerencial::getInstance()->consultarParametro($arrFiltroParametro);
            $txtIgrejaCNPJ = strtoupper($arrDadosParametro["objects"][0]->getValor());                
            $txtIgrejaBairro = strtoupper($arrDadosParametro["objects"][4]->getValor());       
            $txtIgrejaCEP = strtoupper($arrDadosParametro["objects"][5]->getValor());                
            $txtIgrejaCidade = strtoupper($arrDadosParametro["objects"][6]->getValor());                
            $txtIgrejaComplemento = strtoupper($arrDadosParametro["objects"][7]->getValor());                
            $txtIgrejaLogradouro = strtoupper($arrDadosParametro["objects"][8]->getValor());                
            $txtIgrejaNumero = strtoupper($arrDadosParametro["objects"][9]->getValor());                
            $txtIgrejaUF = strtoupper($arrDadosParametro["objects"][10]->getValor());                
            $txtIgrejaNomeFantasia = strtoupper($arrDadosParametro["objects"][13]->getValor());                
            $txtIgrejaTelefone = strtoupper($arrDadosParametro["objects"][18]->getValor()); 
            $txtEndereco= $txtIgrejaLogradouro.", ".$txtIgrejaNumero." - ".$txtIgrejaCidade. " - ". $txtIgrejaBairro." - ".$txtIgrejaUF." - ". $txtIgrejaCEP." - ".$txtIgrejaComplemento." FONE: ".$txtIgrejaTelefone;
            $arrStrJson["dados"] = $arrDados;            
            $arrStrJson["dadosIgreja"] = $txtIgrejaNomeFantasia; 
            $arrStrJson["dadosTitulo1"] = $txtIgrejaLogradouro.", ".$txtIgrejaNumero; 
            $arrStrJson["dadosTitulo2"] = $txtIgrejaBairro." - ". $txtIgrejaCidade." - ".$txtIgrejaUF; 
            $arrStrJson["dadosTitulo3"] = "CEP: ".$txtIgrejaCEP." FONE: ".$txtIgrejaTelefone; 
            $arrStrJson["dadosRodape"] = "Gerado por ".$_SESSION["USUARIO_LOGIN"]." em ".date("d/m/Y")." às ".date("H:i:s"); 
            $arrStrJson["sucesso"]     = "true";
            
            
            
        }        
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>