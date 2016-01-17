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
            $strSQLCategoria  = "SELECT * FROM CAD_GRU_GRUPOS_USUARIOS WHERE GRU_Status = 'A' ";
            
            // o grupo Administrador n�o � pra ser exibido para os outros usu�rios
            if(isset($_SESSION["USUARIO_ID"])){
                if($_SESSION["USUARIO_ID"] <> -1){
                    if($_SESSION["USUARIO_ID"] <> -2){ // corresponde ao usuário SUPORTE.MS
                        $strSQLCategoria .= "AND GRU_ID <> -1 AND GRU_ID <> -2 ";
                    }else{
                        $strSQLCategoria .= "AND GRU_ID <> -1 ";
                    }
                }
            }
            
            $arrStrDadosCategoria = Db::getInstance()->select($strSQLCategoria);            
             
            if(count($arrStrDadosCategoria) > 0){
                $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td width="85%">Grupo do Usuário</td>';
                        $strHtml .= '<td width="10%" align="center">Qtd. Usuários</td>';  
                        $strHtml .= '<td width="5%" align="center"></td>'; 
                    $strHtml .= '</tr>';
                $classDif='';  
                
                for($intI = 0; $intI < count($arrStrDadosCategoria); $intI++){                
                    $classDif = 'class="linhaNormal"';
                    if($intI%2 == 0){
                        $classDif = 'class="linhaCor"';
                    }                    
                    $id = $arrStrDadosCategoria[$intI]["GRU_ID"];                    
                    //conta os membros com o ID da categoria
                    $strSQLMembro  = "SELECT COUNT(USU_ID) AS TOTAL FROM CAD_USU_USUARIOS WHERE GRU_ID = ".$id." ; ";
                    $arrStrDadosMembro = Db::getInstance()->select($strSQLMembro);                                    
                    
                    $arrDataGrafico["categorie"] = $arrStrDadosCategoria[$intI]["GRU_Descricao"];
                    $arrDataGrafico["point"] = $arrStrDadosMembro[0]["TOTAL"];       
                    
                    
                    $arrDados["chart"]["series"]["data"][] = $arrDataGrafico;
                    $strHtml .= '<tr '.$classDif.'>';
                        $strHtml .= '<td>'.$arrStrDadosCategoria[$intI]["GRU_Descricao"].'</td>';
                        $strHtml .= '<td align="center" >'.$arrStrDadosMembro[0]["TOTAL"].'</td>'; 
                        $strHtml .= '<td align="center"><a href="javascript: void(0);" onclick="detalhar('.$arrStrDadosCategoria[$intI]["GRU_ID"].');" title="Clique aqui para visualizar os usuários."><img border="0" src="../home/img/botao-pesquisar.png"/></a></td>'; 
                    $strHtml .= '</tr>';
                }
                $strHtml .= '</table>';            
                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["html"]     = $strHtml;
            }else{
                $arrStrJson["html"] = "Não existem grupos de usuários cadastrados.";
                $arrStrJson["sucesso"] = "false";
            }         
        }elseif($strAcao == "Detalhar"){
            $strSQL = "SELECT * FROM CAD_USU_USUARIOS WHERE GRU_ID = ".$_POST["GRU_ID"];            
            $arrStrDados = Db::getInstance()->select($strSQL);            
                            
            if(count($arrStrDados) > 0){                
                $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td width="80%">Usuário</td>';
                        $strHtml .= '<td width="20%" align="center">Último Acesso</td>';
                    $strHtml .= '</tr>';
                $classDif=''; 
                
                for($intI = 0; $intI < count($arrStrDados); $intI++){                
                    $classDif = 'class="linhaNormal"';
                    if($intI%2 == 0){
                        $classDif = 'class="linhaCor"';
                    }                    
                    
                    $strHtml .= '<tr '.$classDif.'>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["USU_Login"].'</td>';
                        $strHtml .= '<td align="center" >'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["USU_DataHoraUltimoAcesso"]).'</td>';                         
                    $strHtml .= '</tr>';
                }
                $strHtml .= '</table>';            
                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["html"]     = $strHtml;
            }else{
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["html"]     = "Nenhum usuário encontrado.";
            }
        }
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>