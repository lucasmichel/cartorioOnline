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
        if($strAcao == "Analitico"){
            $strSQL  = "SELECT * FROM PAT_PTM_PATRIMONIOS AS P ";
            $strSQL .= "INNER JOIN PAT_TIP_TIPOS_PATRIMONIOS AS T ON (T.TIP_ID=P.TIP_ID) ";
            $strSQL .= "INNER JOIN PAT_IPT_ITENS_PATRIMONIAIS AS I ON (I.TIP_ID=T.TIP_ID) ";
            $strSQL .= "INNER JOIN PAT_FRA_FORMAS_AQUISICAO AS F ON (F.FRA_ID=P.FRA_ID) ";
            $strSQL .= "WHERE P.PTM_ID IS NOT NULL ";
                        
            if(isset($_POST["PTM_Condicao"])){
                if(trim($_POST["PTM_Condicao"]) != ""){
                    $strSQL .= "AND P.PTM_Condicao = '".$_POST["PTM_Condicao"]."' ";
                }
            }
            
            if(isset($_POST["TIP_ID"])){
                if(trim($_POST["TIP_ID"]) != ""){
                    $strSQL .= "AND P.TIP_ID = ".$_POST["TIP_ID"]." ";
                }
            }
            
            
            
            if(isset($_POST["IPT_ID"])){
                if(trim($_POST["IPT_ID"]) != ""){
                    $strSQL .= "AND P.IPT_ID = ".$_POST["IPT_ID"]." ";
                }
            }
            
            if(isset($_POST["PTM_Descricao"])){
                if(trim($_POST["PTM_Descricao"]) != ""){                    
                    $strSQL .= "AND P.PTM_Descricao LIKE '%".$arrStrFiltros["PTM_Descricao"]."%' ";                
                }
            }
            
            $strSQL .= "GROUP BY P.PTM_ID ";                
            $strSQL .= "ORDER BY T.TIP_Descricao ";   
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != null){
                $douTotalGeral = 0;
                
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Patrimonial Anal&iacute;tico</h1>';
               // $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 60px; text-align: left;">C&oacute;d.</td>';
                        $strHtml .= '<td style="width: 120px; text-align: left;">N&ordm; Tombamento</td>';
                        $strHtml .= '<td style="width: 250px;">Grupo</td>';
                        $strHtml .= '<td style="width: 180px;">Subgrupo</td>';
                        $strHtml .= '<td style="width: 180px;">Descrição</td>';
                        $strHtml .= '<td style="width: 120px;">Forma Aquisi&ccedil;&atilde;o</td>';
                        $strHtml .= '<td style="width: 150px;">Condi&ccedil;&atilde;o</td>';
                        $strHtml .= '<td style="width: 100px; text-align: right;">Valor(R$)</td>';
                    $strHtml .= '</tr>';

                for($intI=0; $intI<count($arrStrDados); $intI++){
                    $strClass = 'linhaNormal';
                    
                    if($intI%2 == 0){
                        $strClass = 'linhaCor';
                    }
                    
                    $douTotalGeral += doubleval($arrStrDados[$intI]["PTM_ValorEstimado"]);
                    
                    $strHtml .= '<tr class="'.$strClass.'">';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["PTM_ID"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["PTM_NumeroTombamento"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["TIP_Descricao"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["IPT_Descricao"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["PTM_Descricao"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["FRA_Descricao"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["PTM_Condicao"].'</td>';
                        $strHtml .= '<td align="right">'.NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["PTM_ValorEstimado"]).'</td>';
                    $strHtml .= '</tr>';
                }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='7' align='right'><strong>Total Geral(R$):</strong></td>";
                        $strHtml .= "<td align='right'>".NumeroHelper::getInstance()->formatarMoeda($douTotalGeral)."</td>";
                    $strHtml .= "</tr>";
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='8'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum patrim&ocirc;nio encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }elseif($strAcao == "Sintetico"){ 
            $strSQL  = "SELECT * FROM PAT_TIP_TIPOS_PATRIMONIOS AS T ";
            $strSQL .= "INNER JOIN PAT_PTM_PATRIMONIOS AS P ON (P.TIP_ID=T.TIP_ID) ";
            
            if(isset($_POST["PTM_Condicao"])){
                if(trim($_POST["PTM_Condicao"]) != ""){
                    $strSQL .= "AND P.PTM_Condicao = '".$_POST["PTM_Condicao"]."' ";
                }
            }
            
            if(isset($_POST["TIP_ID"])){
                if(trim($_POST["TIP_ID"]) != ""){
                    $strSQL .= "AND P.TIP_ID = ".$_POST["TIP_ID"]." ";
                }
            }
            
            if(isset($_POST["IPT_ID"])){
                if(trim($_POST["IPT_ID"]) != ""){
                    $strSQL .= "AND P.IPT_ID = ".$_POST["IPT_ID"]." ";
                }
            }
            
            if(isset($_POST["PTM_Descricao"])){
                if(trim($_POST["PTM_Descricao"]) != ""){                    
                    $strSQL .= "AND P.PTM_Descricao LIKE '%".$arrStrFiltros["PTM_Descricao"]."%' ";                
                }
            }
            
            
            $strSQL .= "GROUP BY T.TIP_ID ";
            $strSQL .= "ORDER BY T.TIP_Descricao";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != null){
                $douTotalGeral = 0;
                
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Patrimonial Sint&eacute;tico</h1>';
               // $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    $strClass = 'linhaNormal';
                    
                    if($intI%2 == 0){
                        $strClass = 'linhaCor';
                    }
                    
                    // identifica os subgrupos
                    $strSQL  = "SELECT * FROM PAT_PTM_PATRIMONIOS AS P ";
                    $strSQL .= "INNER JOIN PAT_IPT_ITENS_PATRIMONIAIS AS I ON (I.IPT_ID=P.IPT_ID) ";
                    $strSQL .= "INNER JOIN PAT_FRA_FORMAS_AQUISICAO AS F ON (F.FRA_ID=P.FRA_ID) ";
                    $strSQL .= "WHERE P.TIP_ID=".$arrStrDados[$intI]["TIP_ID"]." ";
                    
                    if(isset($_POST["PTM_Condicao"])){
                        if(trim($_POST["PTM_Condicao"]) != ""){
                            $strSQL .= "AND P.PTM_Condicao = '".$_POST["PTM_Condicao"]."' ";
                        }
                    }

                    if(isset($_POST["TIP_ID"])){
                        if(trim($_POST["TIP_ID"]) != ""){
                            $strSQL .= "AND P.TIP_ID = ".$_POST["TIP_ID"]." ";
                        }
                    }

                    $arrStrDadosSubgrupos = Db::getInstance()->select($strSQL);
                    
                    // identifica os grupos e calcula o rowspan
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 320px;" valign="top" rowspan="'.(count($arrStrDadosSubgrupos) + 1).'">'.$arrStrDados[$intI]["TIP_Descricao"].'</td>';                    
                        $strHtml .= '<td valign="top" style="width: 300px;">Subgrupos</td>';
                        $strHtml .= '<td valign="top" style="width: 300px;">Descrição</td>';
                        $strHtml .= '<td valign="top" style="width: 200px;">Forma de Aquisi&ccedil;&atilde;o</td>';
                        $strHtml .= '<td valign="top"style="width: 100px;">Condi&ccedil;&atilde;o</td>';
                        $strHtml .= '<td valign="top" style="width: 120px; text-align: right;">Valor(R$)</td>';
                   $strHtml .= '</tr>';
                      
                        
                    // lista os subgrupos
                    for($intX=0; $intX<count($arrStrDadosSubgrupos); $intX++){
                        $douTotalGeral += doubleval($arrStrDadosSubgrupos[$intX]["PTM_ValorEstimado"]);
                        
                        $strHtml .= '<tr>';                            
                            $strHtml .= '<td valign="top">'.$arrStrDadosSubgrupos[$intX]["IPT_Descricao"].'</td>';
                            $strHtml .= '<td valign="top">'.$arrStrDadosSubgrupos[$intX]["PTM_Descricao"].'</td>';
                            $strHtml .= '<td valign="top">'.$arrStrDadosSubgrupos[$intX]["FRA_Descricao"].'</td>';
                            $strHtml .= '<td valign="top">'.$arrStrDadosSubgrupos[$intX]["PTM_Condicao"].'</td>';
                            $strHtml .= '<td valign="top" align="right">'.NumeroHelper::getInstance()->formatarMoeda($arrStrDadosSubgrupos[$intX]["PTM_ValorEstimado"]).'</td>';
                       $strHtml .= '</tr>';
                    }
                }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='5' align='right'><strong>Total Geral(R$):</strong></td>";
                        $strHtml .= "<td align='right'>".NumeroHelper::getInstance()->formatarMoeda($douTotalGeral)."</td>";
                    $strHtml .= "</tr>";
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='6'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum patrim&ocirc;nio encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "GrupoSubGrupo"){ 
            
            
            
            $strSQL  = "SELECT * FROM PAT_TIP_TIPOS_PATRIMONIOS AS GRUPO ";
            
            
            if(isset($_POST["TIP_ID"])){
                if(trim($_POST["TIP_ID"]) != ""){
                    $strSQL .= "WHERE GRUPO.TIP_ID = ".$_POST["TIP_ID"]." ";
                }
            }
            
            /*
            var_dump($strSQL);
            var_dump($_POST);
            die();
            */
            $arrStrDadosGrupo = Db::getInstance()->select($strSQL);            
            if($arrStrDadosGrupo != null){
                
                
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Subgrupos</h1>';
               // $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    
                for($intI=0; $intI<count($arrStrDadosGrupo); $intI++){
                    
                    
                    $strHtml .= '<tr class="cabecalhoTabela">';                        
                        $strHtml .= '<td style="width: 500px;" valign="top"><b> '.NumeroHelper::getInstance()->completarComZero($intI+1, 3).' - '.$arrStrDadosGrupo[$intI]["TIP_Descricao"].'</b></td>';
                   $strHtml .= '</tr>';                    

                   $strHtml .= '<tr class="cabecalhoTabela">';
                   
                        $strHtml .= '<td valign="top" style="width: 500px; ">';
                        
                        $strSQLSubgrupo  = "SELECT * FROM PAT_IPT_ITENS_PATRIMONIAIS AS SUBGRUPO ";
                        $strSQLSubgrupo .= "WHERE SUBGRUPO.TIP_ID = ".$arrStrDadosGrupo[$intI]["TIP_ID"]." ";
                        $arrStrDadosSubGrupo = Db::getInstance()->select($strSQLSubgrupo);
                        if($arrStrDadosSubGrupo != null){
                            
                            $strHtml .= '<table id="tableRelatorio" class="dadosTabela"  cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                                    for($intZ=0; $intZ<count($arrStrDadosSubGrupo); $intZ++){
                                        
                                        $strClass = 'linhaNormal';                    
                                        if($intZ%2 == 0){
                                            $strClass = 'linhaCor';
                                        }
                                        
                                        $strHtml .= '<tr class="'.$strClass.'">';                                            
                                            $strHtml .= '<td style="width: 500px;" valign="top">'.NumeroHelper::getInstance()->completarComZero($intZ+1, 3).' - '.$arrStrDadosSubGrupo[$intZ]["IPT_Descricao"].'</td>';
                                        $strHtml .= '</tr>';
                                    }
                            $strHtml .= '</table>';
                            
                        }else{
                            $strHtml.= '<table>';
                                $strHtml .= '<tr>';
                                    $strHtml .= '<td>Nenhum subgrupo cadastrado. </td>';
                                $strHtml .= '</tr>';
                            $strHtml .= '</table>';
                        }
                        
                        $strHtml .= '</td>';
                        
                   $strHtml .= '</tr>';                    
                }
                    
                    
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum grupo cadastrado.</td>';
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