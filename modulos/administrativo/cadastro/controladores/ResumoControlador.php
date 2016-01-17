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

        if($strAcao == "MembroPorStatus"){            
            // SQL
            $strSQL  = "SELECT M.MEM_Tipo, COUNT(M.PES_ID) AS QuantidadeMembros FROM ADM_MEM_MEMBROS AS M ";
            $strSQL .= "GROUP BY M.MEM_Tipo ";
            $arrStrDados = Db::getInstance()->select($strSQL);
                     
            $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';

                $strHtml .= '<tr class="cabecalhoTabela">';
                    $strHtml .= '<td style="width: 710px;">Tipo</td>';
                    $strHtml .= '<td style="width: 70px; text-align: right;">Qtd. de Pessoas</td>';                    
                $strHtml .= '</tr>';
                
            $classDif='';
            
            // array que contém os dados 
            // apresentados no gráfico
            $arrStrGraficoData       = array();
            $arrStrGraficoCategories = array();
                        
            if(count($arrStrDados) > 0){
                for($intI = 0; $intI < count($arrStrDados); $intI++){                
                    $classDif = 'class="linhaNormal"';
                    if($intI%2 == 0){
                        $classDif = 'class="linhaCor"';
                    }                    
                       
                    $strHtml .= '<tr '.$classDif.'>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["MEM_Tipo"].'</td>';
                        $strHtml .= '<td style="text-align: right;">'.$arrStrDados[$intI]["QuantidadeMembros"].'</td>';                    
                    $strHtml .= '</tr>';
                    
                    // informa os dados que alimentará o gráfico
                    $arrStrGraficoCategories[$intI] = $arrStrDados[$intI]["MEM_Tipo"];
                    $arrStrGraficoData[$intI]       = array($arrStrDados[$intI]["MEM_Tipo"], intval($arrStrDados[$intI]["QuantidadeMembros"]));
                }
                
                $strHtml .= '</table>';
                
                $arrStrJson["relatorio"]             = $strHtml;
                $arrStrJson["sucesso"]               = "true";
                $arrStrJson["grafico"]["data"]       = $arrStrGraficoData;
                $arrStrJson["grafico"]["categories"] = $arrStrGraficoCategories;
            }else{
                $arrStrJson["relatorio"] = "";
                $arrStrJson["sucesso"]   = "false";
            }         
        }elseif($strAcao == "MembroPorSexo"){            
            // SQL
            $strSQL  = "SELECT P.PES_Sexo, COUNT(M.PES_ID) AS QuantidadeMembros FROM CAD_PES_PESSOAS AS P ";
            $strSQL .= "LEFT JOIN ADM_MEM_MEMBROS AS M ON (M.PES_ID=P.PES_ID) WHERE P.PES_Status = 'A' ";
            $strSQL .= "GROUP BY P.PES_Sexo ";
            $arrStrDados = Db::getInstance()->select($strSQL);
                
            $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                $strHtml .= '<tr class="cabecalhoTabela">';
                    $strHtml .= '<td style="width: 710px;">Sexo</td>';
                    $strHtml .= '<td style="width: 70px; text-align: right;">Qtd. de Membros</td>';                    
                $strHtml .= '</tr>';
                
            $classDif='';
                        
            $intM = 0;
            $intF = 0;
            
            if(count($arrStrDados) > 0){
                for($intI = 0; $intI < count($arrStrDados); $intI++){                
                    $classDif = 'class="linhaNormal"';
                    if($intI%2 == 0){
                        $classDif = 'class="linhaCor"';
                    }                    
                       
                    $strHtml .= '<tr '.$classDif.'>';
                    
                    $strSexo = "MASCULINO";
                    
                    if($arrStrDados[$intI]["PES_Sexo"] == "F"){
                        $strSexo = "FEMININO";
                        $intF = intval($arrStrDados[$intI]["QuantidadeMembros"]);
                    }else{
                        $intM = intval($arrStrDados[$intI]["QuantidadeMembros"]);
                    }
                    
                        $strHtml .= '<td>'.$strSexo.'</td>';
                        $strHtml .= '<td style="text-align: right;">'.$arrStrDados[$intI]["QuantidadeMembros"].'</td>';                    
                    $strHtml .= '</tr>';
                }
                
                $strHtml .= '</table>';
                
                $arrStrJson["relatorio"]        = $strHtml;
                $arrStrJson["sucesso"]          = "true";
                
                // dados do gráfico pizza
                $arrStrJson["grafico"]["dataM"] = $intM;
                $arrStrJson["grafico"]["dataF"] = $intF;
            }else{
                $arrStrJson["relatorio"] = "";
                $arrStrJson["sucesso"]   = "false";
            }         
        } 
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>