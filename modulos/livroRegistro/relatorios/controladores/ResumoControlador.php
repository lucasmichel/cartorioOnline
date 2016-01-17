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
            
            $dtInicio = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["dataInicial"]);
            $dtFim = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["dataFim"]);
            
            //busca os tipos de despesas
            $strSQLDespesa  = " SELECT * FROM LIR_TIL_TIPO_LINHA WHERE TIL_Tipo = 'D' ";
            $arrStrTiposDespesas = Db::getInstance()->select($strSQLDespesa);
            
            //busca os tipos de receitas
            $strSQLReceitas  = " SELECT * FROM LIR_TIL_TIPO_LINHA WHERE TIL_Tipo = 'R' ";
            $arrStrTiposReceitas = Db::getInstance()->select($strSQLReceitas);
            
            $dadosDespesa = array();
            $arrSerieDespesa = array();
            $graficoDespesa = array();
            
            $dadosReceita = array();
            $arrSerieReceita = array();
            $graficoReceita = array();
            
            //busca as linhas pelos tipos
            //busca as linhas de despesas
            if($arrStrTiposDespesas != ""){
                foreach ($arrStrTiposDespesas as $despesa) {
                    $strSQL  = " SELECT * FROM LIR_LAU_LINHA_AUXILIAR AS LINHA_AUX ";
                    $strSQL .= " INNER JOIN LIR_FAU_FOLHA_AUXILIAR AS FOLHA_AUX ON (FOLHA_AUX.FAU_ID = LINHA_AUX.FAU_ID)  ";
                    $strSQL .= " INNER JOIN LIR_LIA_LIVRO_AUXILIAR AS LIVRO_AUX ON (LIVRO_AUX.LIA_ID = FOLHA_AUX.LIA_ID)  ";
                    $strSQL .= " INNER JOIN LIR_TIL_TIPO_LINHA AS TIPO_LINHA ON (TIPO_LINHA.TIL_ID = LINHA_AUX.TIL_ID)  ";
                    $strSQL .= " WHERE  TIPO_LINHA.TIL_Tipo = 'D' AND TIPO_LINHA.TIL_ID =  ".$despesa["TIL_ID"]. " AND ";//despesa
                    //$strSQL .= " WHERE  TIPO_LINHA = 'R' ";//receita

                    if($_POST["tipoConsulta"] == "linha"){
                        $strSQL .= " LINHA_AUX.LAU_Data >= '".$dtInicio." 00:00:00'  AND LINHA_AUX.LAU_Data <= '".$dtFim." 23:59:59' ";
                        $strSQL .= " ORDER BY LINHA_AUX.LAU_Data  ";
                    }elseif($_POST["tipoConsulta"] == "folha"){
                        $strSQL .= " FOLHA_AUX.FAU_DataFolha >= '".$dtInicio." 00:00:00'  AND FOLHA_AUX.FAU_DataFolha <= '".$dtFim." 23:59:59' ";
                        $strSQL .= " ORDER BY FOLHA_AUX.FAU_DataFolha ";
                    }else{
                        $strSQL .= " LIVRO_AUX.LIA_DataHoraCadastro >= '".$dtInicio." 00:00:00' AND LIVRO_AUX.LIA_DataHoraCadastro <= '".$dtFim." 23:59:59' ";
                        $strSQL .= " ORDER BY LIVRO_AUX.LIA_DataHoraCadastro  ";
                    }
                    $arrDados["tipo"] = $despesa["TIL_Descricao"];
                    $arrDados["dados"] = Db::getInstance()->select($strSQL);
                    
                    $arrSerieDespesa["name"] = $despesa["TIL_Descricao"];
                    $arrSerieDespesa["y"] = doubleval(count($arrDados["dados"]));
                    $graficoDespesa["series"][] = $arrSerieDespesa;
                    
                    $dadosDespesa[] = $arrDados;
                }
            }
            $graficoDespesa["titulo"] = "Despesas";
            
            
            //busca as linhas de receita
            if($arrStrTiposDespesas != ""){
                foreach ($arrStrTiposReceitas as $receita) {
                    $strSQLRec  = " SELECT * FROM LIR_LAU_LINHA_AUXILIAR AS LINHA_AUX ";
                    $strSQLRec .= " INNER JOIN LIR_FAU_FOLHA_AUXILIAR AS FOLHA_AUX ON (FOLHA_AUX.FAU_ID = LINHA_AUX.FAU_ID)  ";
                    $strSQLRec .= " INNER JOIN LIR_LIA_LIVRO_AUXILIAR AS LIVRO_AUX ON (LIVRO_AUX.LIA_ID = FOLHA_AUX.LIA_ID)  ";
                    $strSQLRec .= " INNER JOIN LIR_TIL_TIPO_LINHA AS TIPO_LINHA ON (TIPO_LINHA.TIL_ID = LINHA_AUX.TIL_ID)  ";
                    $strSQLRec .= " WHERE  TIPO_LINHA.TIL_Tipo = 'R' AND TIPO_LINHA.TIL_ID =  ".$receita["TIL_ID"]. " AND ";//despesa
                    
                    if($_POST["tipoConsulta"] == "linha"){
                        $strSQLRec .= " LINHA_AUX.LAU_Data >= '".$dtInicio."'  AND LINHA_AUX.LAU_Data <= '".$dtFim."' ";
                        $strSQLRec .= " ORDER BY LINHA_AUX.LAU_Data  ";
                    }elseif($_POST["tipoConsulta"] == "folha"){
                        $strSQLRec .= " FOLHA_AUX.FAU_DataFolha >= '".$dtInicio."'  AND FOLHA_AUX.FAU_DataFolha <= '".$dtFim."' ";
                        $strSQLRec .= " ORDER BY FOLHA_AUX.FAU_DataFolha ";
                    }else{
                        $strSQLRec .= " LIVRO_AUX.LIA_DataHoraCadastro >= '".$dtInicio." 00:00:00' AND LIVRO_AUX.LIA_DataHoraCadastro <= '".$dtFim." 23:59:59' ";
                        $strSQLRec .= " ORDER BY LIVRO_AUX.LIA_DataHoraCadastro  ";
                    }
                    
                    $arrDadosRe["tipo"] = $receita["TIL_Descricao"];
                    $arrDadosRe["dados"] = Db::getInstance()->select($strSQLRec);
                    
                    $arrSerieReceita["name"] = $receita["TIL_Descricao"];
                    $arrSerieReceita["y"] = doubleval(count($arrDadosRe["dados"]));
                    $graficoReceita["series"][] = $arrSerieReceita;
                    $dadosReceita[] = $arrDadosRe;

                }
            }
            $graficoReceita["titulo"] = "Receitas";
            
            $arrStrJson["graficoReceita"] = $graficoReceita;
            $arrStrJson["graficoDespesa"] = $graficoDespesa;
            
            $arrStrJson["sucesso"] = "true";
            
        }        
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>