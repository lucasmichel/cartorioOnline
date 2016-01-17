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
    $arrStrJson["parcelasDiferentes"] = "";
    $arrStrJson["parcelasCorretasComTotal"] = "";
    
    try{
        if($strAcao == "Consultar"){            
            $arrObjs = FachadaFinanceiro::getInstance()->consultarContaPagarReceber($_POST);
            
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["totalLancamentos"] = $arrObjs["totalLancamentos"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){
            // guarda o $_FILES também no $_POST
            $_POST["FILES"] = $_FILES;            
            // no alterar valida se o número de parcelas é igual ao número de parcelas geradas
            if(isset($_POST["CON_ID"])){
                if($_POST["CON_ID"] != ""){
                    $arrStrJson["parcelasDiferentes"] = "false";
                    
                    if(intval($_POST["CON_NumeroParcelas"]) != count($_POST["PCL_DataVencimento"])){                        
                        $arrStrJson["parcelasDiferentes"] = "true";
                        $arrStrJson["mensagem"]  = "O n&uacute;mero de parcelas est&aacute; diferente do total de parcelas geradas. ";
                        echo json_encode($arrStrJson);
                        exit;
                    }
                }
            }
            
            
            $_POST["CON_Valor"] = NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["CON_Valor"]); 
            $strValorParcela    = $_POST["CON_Valor"]/$_POST["CON_NumeroParcelas"];
            $strValorParcela    = NumeroHelper::getInstance()->formatarNumeroParaBanco(NumeroHelper::getInstance()->formatarMoeda($strValorParcela)); // identifica qual a parcela
                       
            $arrStrJson["parcelasCorretasComTotal"] = "true";
            
            // veirifa se a soma das parcelas é igual ao total            
            for($intI=0; $intI<count($_POST["PCL_Valor"]); $intI++){
                if(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_Valor"][$intI]) != $strValorParcela){
                    $arrStrJson["parcelasCorretasComTotal"] = "false";
                    break;
                }
            }
            
            $douSomaParcelas = 0;
            
            for($intI=0; $intI<count($_POST["PCL_Valor"]); $intI++){
                $douSomaParcelas += doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_Valor"][$intI]));
            }
            
            if($arrStrJson["parcelasCorretasComTotal"] == "true"){                
                if(FachadaFinanceiro::getInstance()->salvarContaPagarReceber($_POST)){                
                    $arrStrJson["sucesso"]  = "true";
                    $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
                }
            }else{                
                $arrStrJson["mensagem"]  = "O valor total da conta (R$ ".NumeroHelper::getInstance()->formatarMoeda($_POST["CON_Valor"]).") ";
                $arrStrJson["mensagem"] .= "est&aacute; diferente da soma dos valores das parcelas (R$ ".NumeroHelper::getInstance()->formatarMoeda($douSomaParcelas).")! ";
                $arrStrJson["mensagem"] .= "Dessa forma sua conta n&atilde;o poder&aacute; ser salva para n&atilde;o gerar uma inconsist&ecirc;ncia no sistema.";
            }
        }elseif($strAcao == "Excluir"){             
            if(FachadaFinanceiro::getInstance()->excluirContaPagarReceber($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }elseif($strAcao == "EfetuarPagamento"){            
            // guarda o $_FILES também no $_POST
            $_POST["FILES"] = $_FILES;
            if(FachadaFinanceiro::getInstance()->pagarParcelaContaPagarReceber($_POST)){
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }
        }elseif($strAcao == "GerarParcelas"){            
            $strValorTotal = NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["CON_ValorParcelas"]);
            $intNumeroParcelas = intval($_POST["CON_NumeroParcelas"]);

            $strValorParcelas = doubleval($strValorTotal)/$intNumeroParcelas;
            $strValorParcelas = NumeroHelper::getInstance()->formatarMoeda($strValorParcelas);

            $strDataInicioParcela = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["CON_DataInicioParcela"]);
            $strNumeroInicialDocumentoParcela = $_POST["CON_NumeroInicialParcela"];



            $strHtml = '<table>';
                $strHtml .= '<tr>';
                    $strHtml .= '<td align="center">Data do Vencimento</td>';
                    $strHtml .= '<td align="right">Valor(R$)</td>';
                    $strHtml .= '<td align="center">N&ordm; do Documento</td>';
                    $strHtml .= '<td></td>';
                $strHtml .= '</tr>';
            for($intI=1; $intI<=$intNumeroParcelas; $intI++){
                $strHtml .= '<tr id="linhaParcela'.$intI.'">';

                if($intI == 1){                    
                    $strHtml .= '<td align="center">';
                        //$strHtml .= DataHelper::getInstance()->converterDataBancoParaDataUsuario($strDataInicioParcela);
                        $strHtml .= '<input type="text" name="PCL_DataVencimento[]" value="'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($strDataInicioParcela).'" class="campoTextoPadrao"/>';
                    $strHtml .= '</td>';
                    $strHtml .= '<td align="right">';
                        // $strHtml .= $strValorParcelas;
                        $strHtml .= '<input type="text" name="PCL_Valor[]" class="campoTextoPadrao" value="'.$strValorParcelas.'"/>';
                    $strHtml .= '</td>';
                    $strHtml .= '<td  align="center">';
                        // $strHtml .= $strNumeroInicialDocumentoParcela;
                        $strHtml .= '<input type="text" name="PCL_Numero[]" class="campoTextoPadrao" value="'.$strNumeroInicialDocumentoParcela.'"/>';
                    $strHtml .= '</td>';

                    $strHtml .= '<td>';
                        $strHtml .= '<input type="button" value="Remover" class="botao" onclick="removerParcela('.$intI.');"/>';
                    $strHtml .= '</td>';
                }else{
                    $strDataProximoVencimento = date("Y-m-d", strtotime("+".$intI." month", time($strDataInicioParcela)));

                    $strHtml .= '<td>';
                        //$strHtml .= DataHelper::getInstance()->converterDataBancoParaDataUsuario($strDataProximoVencimento);
                        $strHtml .= '<input type="text" name="PCL_DataVencimento[]" value="'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($strDataProximoVencimento).'" class="campoTextoPadrao"/>';
                    $strHtml .= '</td>';
                    $strHtml .= '<td>';
                        // $strHtml .= $strValorParcelas;
                        $strHtml .= '<input type="text" name="PCL_Valor[]" class="campoTextoPadrao" value="'.$strValorParcelas.'"/>';
                    $strHtml .= '</td>';
                    $strHtml .= '<td>';
                    if(trim($strNumeroInicialDocumentoParcela) != ""){
                        $strNumeroInicialDocumentoParcela += 1;
                        //$strHtml .= (intval($strNumeroInicialDocumentoParcela) + 1);
                        $strHtml .= '<input type="text" name="PCL_Numero[]" class="campoTextoPadrao" value="'.$strNumeroInicialDocumentoParcela.'"/>';
                    }else{
                        $strHtml .= '<input type="text" name="PCL_Numero[]" class="campoTextoPadrao" value=""/>';
                    }
                    $strHtml .= '</td>';

                    $strHtml .= '<td>';
                        $strHtml .= '<input type="button" value="Remover" class="botao" onclick="removerParcela('.$intI.');"/>';
                    $strHtml .= '</td>';
                }

                $strHtml .= '</tr>';
            }
            $strHtml .= '</table>';
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["html"]  = $strHtml;
        }elseif($strAcao == "GerarParcelasAlt"){
            $arrStrDadosParcelas = FachadaFinanceiro::getInstance()->consultarParcelasContaPagarReceber($_POST);

            $strHtml = '<table>';
                $strHtml .= '<tr>';
                    $strHtml .= '<td align="center">Data do Vencimento</td>';
                    $strHtml .= '<td align="right">Valor(R$)</td>';
                    $strHtml .= '<td align="center">N&ordm; do Documento</td>';
                    $strHtml .= '<td></td>';
                $strHtml .= '</tr>';
            for($intI=0; $intI<count($arrStrDadosParcelas); $intI++){
                $strHtml .= '<tr id="linhaParcela'.$intI.'">';

                $strHtml .= '<td align="center">';
                        //$strHtml .= DataHelper::getInstance()->converterDataBancoParaDataUsuario($strDataInicioParcela);
                        $strHtml .= '<input type="text" name="PCL_DataVencimento[]" value="'.$arrStrDadosParcelas[$intI]["PCL_DataVencimento"].'" class="campoTextoPadrao"/>';
                    $strHtml .= '</td>';
                    $strHtml .= '<td align="right">';
                        // $strHtml .= $strValorParcelas;
                        $strHtml .= '<input type="text" name="PCL_Valor[]" class="campoTextoPadrao" value="'.$arrStrDadosParcelas[$intI]["PCL_Valor"].'"/>';
                    $strHtml .= '</td>';
                    $strHtml .= '<td  align="center">';
                        // $strHtml .= $strNumeroInicialDocumentoParcela;
                        $strHtml .= '<input type="text" name="PCL_Numero[]" class="campoTextoPadrao" value="'.$arrStrDadosParcelas[$intI]["PCL_Numero"].'"/>';
                    $strHtml .= '</td>';

                    $strHtml .= '<td>';
                        $strHtml .= '<input type="button" value="Remover" class="botao" onclick="removerParcela('.$intI.');"/>';
                    $strHtml .= '</td>';

                $strHtml .= '</tr>';
            }
            $strHtml .= '</table>';
            
            
            $arrStrJson["sucesso"]  = "true";
            $arrStrJson["html"]  = $strHtml;
        }elseif($strAcao == "ConsultarParcelas"){
            $arrStrDadosParcelas = FachadaFinanceiro::getInstance()->consultarParcelasContaPagarReceber($_POST);
            
            if($arrStrDadosParcelas != null){
                $arrStrJson["rows"]     = $arrStrDadosParcelas;
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "CalulcarValorPago"){
            $douJuros = doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_Juros"]));
            $douMora = doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_Mora"]));
            $douMulta = doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_Multa"]));
            $douDesconto = doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_Desconto"]));
            $douParcela = doubleval(NumeroHelper::getInstance()->formatarNumeroParaBanco($_POST["PCL_ValorParcela"]));
            
            $arrStrJson["valorPago"] = ($douParcela + $douJuros + $douMora + $douMulta) - $douDesconto;
            $arrStrJson["valorPago"] = NumeroHelper::getInstance()->formatarMoeda($arrStrJson["valorPago"]);
            $arrStrJson["sucesso"] = "true";
        }elseif($strAcao == "DataAtual"){
            $arrStrJson["dataAtual"]  =  date("d/m/Y");
            $arrStrJson["sucesso"]  = "true";
        }elseif($strAcao == "ExcluirAnexo"){            
            $arquivo = $_POST["arquivo"]; 
            $arrCaminho = explode("/", $arquivo);
            //$caminhoArquivo = SISTEMA_RAIZ.DIRECTORY_SEPARATOR."modulos".DIRECTORY_SEPARATOR.$arrCaminho[2].DIRECTORY_SEPARATOR.$arrCaminho[3].DIRECTORY_SEPARATOR.$arrCaminho[4].DIRECTORY_SEPARATOR.$arrCaminho[5].DIRECTORY_SEPARATOR.$arrCaminho[6].DIRECTORY_SEPARATOR.$arrCaminho[7];            
            $caminhoArquivo = SISTEMA_RAIZ.DIRECTORY_SEPARATOR.$arrCaminho[4].DIRECTORY_SEPARATOR.$arrCaminho[5].DIRECTORY_SEPARATOR.$arrCaminho[6].DIRECTORY_SEPARATOR.$arrCaminho[7].DIRECTORY_SEPARATOR.$arrCaminho[8].DIRECTORY_SEPARATOR.$arrCaminho[9].DIRECTORY_SEPARATOR.$arrCaminho[10];            
            
            if(unlink($caminhoArquivo)){
                NegContaPagarReceber::getInstance()->excluirArquivoFisico($_POST["CON_ID"]);
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }            
        }
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>