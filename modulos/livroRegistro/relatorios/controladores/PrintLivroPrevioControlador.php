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
        if($strAcao == "Consultar"){ 
            
            $arrObjs = FachadaLivroAuxiliar::getInstance()->consultarLivroAuxiliar($_POST);
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
            
            
            
            
            
            
            $intTotDespesa  = 0;
    $intTotAuxiliar  = 0;
    for($intLivro = 0; $intLivro<count($arrImpressao); $intLivro++){        

        foreach ($arrImpressao["livro"]["folha"] as $folha){            
            
            $obFolha = $folha;
            
            $htmlTitulo = '<page_header>';
                $htmlTitulo .= '<table style=" border-collapse: separate; border-spacing: 10px; padding: 10px; "  >';                            
                    $htmlTitulo .= '<tr >';
                        $htmlTitulo .= '<td align="center" style="width:650px;" ><b ">CARTORIO ÚNICO DE NOTAS E REGISTROS</b></td>';
                    $htmlTitulo .= '</tr>';

                    $htmlTitulo .= '<tr >';
                        $htmlTitulo .= '<td align="center" style="width:650px;"><b ">Comarca de MORENO-PE</b></td>';
                    $htmlTitulo .= '</tr>';

                    $htmlTitulo .= '<tr >';
                        $htmlTitulo .= '<td align="center" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlTitulo .= '</tr>';

                    $htmlTitulo .= '<tr >';    
                        $htmlTitulo .= '<td align="center" style="width:650px;"><b ">Livro nr. '.$arrImpressao["livro"]["numeroLivro"].' de registros Diários Auxiliar da receita e da Despesa</b></td>';
                    $htmlTitulo .= '</tr>';

                    $htmlTitulo .= '<tr >';
                        $htmlTitulo .= '<td align="right" style="width:650px;"><b ">FLS.'.$obFolha["numeroFolha"].'</b></td>';
                    $htmlTitulo .= '</tr>';

                    $htmlTitulo .= '<tr >';
                        $htmlTitulo .= '<td align="center" style="width:650px;"><b ">Abertura diária de transações financeiras efetuadas em '. DataHelper::getInstance()->converterDataBancoParaDataUsuario($obFolha["dataFolha"]) .'</b></td>';
                    $htmlTitulo .= '</tr>';

                    $htmlTitulo .= '<tr >';
                        $htmlTitulo .= '<td align="center" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlTitulo .= '</tr>';                      
                $htmlTitulo .= '</table>';    
            $htmlTitulo    .= '</page_header>';
            
            
            
            
            
            
            foreach ($obFolha["linhas"]["auxiliar"] as $linAuxiliar) {
                
                $lineAuxiliar = $linAuxiliar["linhasAuxiliar"];                
                $valorTotalAuxiliar = $linAuxiliar["valorTotalAuxiliar"];
                
                $htmlAuxiliar = '<table style=" border-collapse: separate; border-spacing: 10px; padding: 10px; "  >';
                    $htmlAuxiliar .= '<tr >';
                        $htmlAuxiliar .= '<td align="center" colspan="5" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlAuxiliar .= '</tr>';
                    $htmlAuxiliar .= '<tr >';
                        $htmlAuxiliar .= '<td align="center" colspan="5" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlAuxiliar .= '</tr>';
                    $htmlAuxiliar .= '<tr >';
                        $htmlAuxiliar .= '<td align="center" colspan="5" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlAuxiliar .= '</tr>';
                    $htmlAuxiliar .= '<tr >';
                        $htmlAuxiliar .= '<td align="center" colspan="5" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlAuxiliar .= '</tr>';
                    $htmlAuxiliar .= '<tr >';
                        $htmlAuxiliar .= '<td align="center" colspan="5" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlAuxiliar .= '</tr>';
                
                    $htmlAuxiliar .= '<tr bgcolor="#003366">';
                        $htmlAuxiliar .= '<td align="Left" colspan="5" style="width:650px;"><b style="color: white; ">Receitas</b></td>';                        
                    $htmlAuxiliar .= '</tr>';

                    $htmlAuxiliar .= '<tr bgcolor="#003366">';                    
                        $htmlAuxiliar .= '<td align="left" style="width:70px;"><b style="color: white;">Quantidade</b></td>';                                                      
                        $htmlAuxiliar .= '<td align="left" style="width:300px;"><b style="color: white;">Descrição</b></td>';                                                      
                        $htmlAuxiliar .= '<td align="left" style="width:100px;"><b style="color: white;">Prot./Rec.</b></td>';                                                      
                        $htmlAuxiliar .= '<td align="left" style="width:100px;"><b style="color: white;">Guia</b></td>';                                                      
                        $htmlAuxiliar .= '<td align="right" style="width:50px;"><b style="color: white;">Valor</b></td>';  
                    $htmlAuxiliar .= '</tr>';

                    if($valorTotalAuxiliar>0){
                        $j = 0;
                        foreach ($lineAuxiliar as $linhaAuxiliarAqui) {
                            if($j%2 == 0) 
                                $varCor =  "bgcolor='#DCDCDC'";    
                            else 
                                $varCor = "bgcolor='#FFFFFF'" ;                    

                            $htmlAuxiliar .= "<tr  " . $varCor . " >";                                    
                                $htmlAuxiliar .= '<td align="left">'.$linhaAuxiliarAqui["quantidade"].'</td>';                                
                                $htmlAuxiliar .= '<td align="left">'.$linhaAuxiliarAqui["descricao"].'</td>';
                                $htmlAuxiliar .= '<td align="left">'.$linhaAuxiliarAqui["protocolo"].'</td>';
                                $htmlAuxiliar .= '<td align="left">'.$linhaAuxiliarAqui["guia"].'</td>';
                                $htmlAuxiliar .= '<td align="right">R$'.$linhaAuxiliarAqui["valor"].'</td>';                         
                            $htmlAuxiliar .= '</tr>';
                            $j ++;
                        }
                    }else{
                        $htmlAuxiliar .= "<tr>";                                                                
                            $htmlAuxiliar .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';                         
                            $htmlAuxiliar .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';                         
                            $htmlAuxiliar .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';                         
                            $htmlAuxiliar .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';                         
                        $htmlAuxiliar .= '</tr>';
                    }
                    

                    $htmlAuxiliar .= '<tr bgcolor="#003366">';    
                        $htmlAuxiliar .= '<td align="Left" colspan="4" ><b style="color: white; ">Total das Receitas</b></td>';                 
                        $htmlAuxiliar .= '<td align="right" >';            
                            $htmlAuxiliar .= '<b style="color: white;">R$'. StringHelper::getInstance()->formatarMoeda( $valorTotalAuxiliar ).'</b>';                    
                        $htmlAuxiliar .= '</td>';        
                    $htmlAuxiliar .= '</tr>';    
                $htmlAuxiliar .=  '</table>';
                
                
                $intTotAuxiliar = $valorTotalAuxiliar;
            }
            
            
            foreach ($obFolha["linhas"]["despesa"] as $linDespesa) {
                
                $lineDespesa = $linDespesa["linhasDespesa"];                
                $valorTotalDespesa = $linDespesa["valorTotalDespesa"];
                
                $htmlDespesa = '<table style=" border-collapse: separate; border-spacing: 10px; padding: 10px; "  >';
                $htmlDespesa .= '<tr bgcolor="#003366">';
                    $htmlDespesa .= '<td align="Left" colspan="2" style="width:650px;"><b style="color: white; ">Despesas</b></td>';                        
                $htmlDespesa .= '</tr>';    
                $htmlDespesa .= '<tr bgcolor="#003366">';
                    $htmlDespesa .= '<td align="left" style="width:450px;"><b style="color: white;">Descrição</b></td>';                    
                    $htmlDespesa .= '<td align="right" style="width:200px;"><b style="color: white;">Valor</b></td>';
                $htmlDespesa .= '</tr>';
                
                if($valorTotalDespesa>0){
                    $i = 0;
                    foreach ($lineDespesa as $linhaDespesaAqui) {
                        
                        if($i%2 == 0) 
                            $varCor =  "bgcolor='#DCDCDC'";    
                        else 
                            $varCor = "bgcolor='#FFFFFF'" ;                    

                        $htmlDespesa .= "<tr  " . $varCor . " >";                                    
                            $htmlDespesa .= '<td align="left">'.$linhaDespesaAqui["descricao"].'</td>';
                            $htmlDespesa .= '<td align="right">R$'.$linhaDespesaAqui["valor"].'</td>';                         
                        $htmlDespesa .= '</tr>';
                        $i ++;
                    }
                    
                }else{
                    $htmlDespesa .= "<tr>";                                                            
                        $htmlDespesa .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';                         
                        $htmlDespesa .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';                         
                    $htmlDespesa .= '</tr>';
                }
                
                $htmlDespesa .= '<tr bgcolor="#003366">';    
                    $htmlDespesa .= '<td align="Left" ><b style="color: white; ">Total das Despesas</b></td>';                 
                    $htmlDespesa .= '<td align="right" >';            
                        $htmlDespesa .= '<b style="color: white;">R$'. StringHelper::getInstance()->formatarMoeda($linDespesa["valorTotalDespesa"]) .'</b>';                    
                    $htmlDespesa .= '</td>';        
                $htmlDespesa .= '</tr>';
    
    
                $htmlDespesa .=  '</table>';
                
                $intTotDespesa = $linDespesa["valorTotalDespesa"];
            }
            
            
            $resultado = $intTotAuxiliar - $intTotDespesa;
            
            $htmlCalculoFinal = '<table style=" border-collapse: separate; border-spacing: 10px; padding: 10px; "  >';                            
                
                $htmlCalculoFinal .= '<tr bgcolor="#003366">';

                    $htmlCalculoFinal .= '<td align="left" style="width:450px;" >';                 
                        $htmlCalculoFinal .= '<b style="color: white; ">Total De Receitas/ Despesas</b>';
                    $htmlCalculoFinal .= '</td>';
                    
                    $htmlCalculoFinal .= '<td align="right" style="width:200px;" >';            
                        $htmlCalculoFinal .= '<b style="color: white;">R$'. StringHelper::getInstance()->formatarMoeda($resultado) .'</b>';                    
                    $htmlCalculoFinal .= '</td>';        

                $htmlCalculoFinal .= '</tr>';
                
            $htmlCalculoFinal .=  '</table>';
            
            
            
            
            
            $htmlRodape = '<page_footer>';
            
                $htmlRodape .= '<table style=" border-collapse: separate; border-spacing: 10px; padding: 10px; "  >';                                    
                    $htmlRodape .= '<tr >';
                        $htmlRodape .= '<td align="center" style="width:650px;"><b ">Encerramento Diário de Transações Fincanceiras Efetuadas em '. DataHelper::getInstance()->converterDataBancoParaDataUsuario($obFolha["dataFolha"]) .'</b></td>';
                    $htmlRodape .= '</tr>';

                    $htmlRodape .= '<tr >';
                        $htmlRodape .= '<td align="center" style="width:650px;"><b ">&nbsp;&nbsp;&nbsp;</b></td>';
                    $htmlRodape .= '</tr>';
                    $htmlRodape .= '<tr >';
                        $htmlRodape .= '<td align="center" style="width:650px;"><b ">----------------------------------------------------------------</b></td>';
                    $htmlRodape .= '</tr>';
                    $htmlRodape .= '<tr >';
                        $htmlRodape .= '<td align="center" style="width:650px;"><b ">Tabelião de Protestos</b></td>';
                    $htmlRodape .= '</tr>';        
                $htmlRodape .= '</table>'; 
            $htmlRodape .= '</page_footer>';
            
            
            
            $txtImpressao = $htmlTitulo;
            $txtImpressao .= $htmlRodape;
            //$txtImpressao .= $htmlAuxiliar . $htmlDespesa . $htmlCalculoFinal;
            $txtImpressao .= $htmlAuxiliar . $htmlDespesa ;
                
                
            $folhaPrint[] = $txtImpressao;
            
        }
    }
                
      
    
    
    
    $htmlImpressao = '';
    for($intImpr = 0; $intImpr<count($folhaPrint); $intImpr++ ){
        $htmlImpressao .= '<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">';

        $htmlImpressao .= $folhaPrint[$intImpr];

        $htmlImpressao .= '</page>';
        
    }
            
            $objHtml2PDF = new HTML2PDF('P','A4','pt');
//$objHtml2PDF->WriteHTML($strTable2);
$objHtml2PDF->WriteHTML($htmlImpressao);
$objHtml2PDF->Output('relatorio_sintetico.pdf');
            
            
            
            
        }
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>