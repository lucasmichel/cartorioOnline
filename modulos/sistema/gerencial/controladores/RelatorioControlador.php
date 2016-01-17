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
        if($strAcao == "RelatorioAcessoUsuario"){
            
            $strSQL  = "SELECT USUARIO.*, ACESSO.USA_DataHora AS ULTIMO_ACESSO, COUNT(ACESSO.USU_ID) AS TOTAL_ACESSO FROM CAD_USU_USUARIOS AS USUARIO ";
            $strSQL .= "LEFT JOIN CAD_USA_USUARIOS_ACESSOS AS ACESSO ON (ACESSO.USU_ID = USUARIO.USU_ID) ";            
            $strSQL .= "WHERE USUARIO.USU_ID IS NOT NULL ";
                   
            // o grupo Administrador n�o � pra ser exibido para os outros usu�rios
            if(isset($_SESSION["USUARIO_ID"])){
                if($_SESSION["USUARIO_ID"] <> -1){
                    if($_SESSION["USUARIO_ID"] <> -2){ // corresponde ao usuário SUPORTE.MS
                        $strSQL .= "AND GRU_ID <> -1 AND GRU_ID <> -2 ";
                    }else{
                        $strSQL .= "AND GRU_ID <> -1 ";
                    }
                }
            }
            
            if ( (!empty($_POST["USA_DataHoraInicial"])) && (!empty($_POST["USA_DataHoraFinal"])) ){
                $strSQL .= "AND ACESSO.USA_DataHora BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["USA_DataHoraInicial"])."' AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["USA_DataHoraFinal"])."' ";
            }
            if(!empty($_POST["USU_Status"])){                
                $strSQL .= "AND USUARIO.USU_Status = '".$_POST["USU_Status"]."' ";                
            }               
            $strSQL .= " GROUP BY USUARIO.USU_ID ORDER BY USUARIO.USU_Login, ACESSO.USA_DataHora ASC  ";   
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != null){
                $douTotalGeral = 0;
                
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin-bottom: 20px;">Usuários do Sistema</h1>';
               // $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        /*$strHtml .= '<td style="width: 60px; text-align: left;">C&oacute;d.</td>';*/
                        $strHtml .= '<td style="width: 200px; text-align: left;">Login</td>';
                        $strHtml .= '<td style="width: 150px;">Telefone</td>';
                        $strHtml .= '<td style="width: 220px;">E-mail</td>';
                        $strHtml .= '<td style="width: 160px;text-align:center;">Data Cadastro</td>';
                        $strHtml .= '<td style="width: 160px;text-align:center;">Último Acesso</td>';
                        $strHtml .= '<td style="width: 130px;text-align:center;">Qtd. de Acessos</td>';
                        $strHtml .= '<td style="width: 50px; text-align: center; ">Ativo</td>';
                    $strHtml .= '</tr>';

                for($intI=0; $intI<count($arrStrDados); $intI++){
                    if($arrStrDados[$intI]["USU_ID"] > 1){// PARA IGNORAR O ADMINISTRADOR
                    $strClass = 'linhaNormal';
                    if($intI%2 == 0){
                        $strClass = 'linhaCor';
                    }                    
                    $strHtml .= '<tr class="'.$strClass.'">';
                        /*$strHtml .= '<td>'.$arrStrDados[$intI]["USU_ID"].'</td>';*/
                        $strHtml .= '<td>'.$arrStrDados[$intI]["USU_Login"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["USU_Telefone"].'</td>';
                        $strHtml .= '<td>'.$arrStrDados[$intI]["USU_Email"].'</td>';
                        $strHtml .= '<td align="center">'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["USU_DataHoraCadastro"]).'</td>';
                        $strHtml .= '<td align="center" >'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["USU_DataHoraUltimoAcesso"]).'</td>';
                        $strHtml .= '<td align="center" >'.$arrStrDados[$intI]["TOTAL_ACESSO"].'</td>';             
                        
                        $strStyle = "";
                        
                        if($arrStrDados[$intI]["USU_Status"] == "A"){
                            $txtStatus = "SIM" ;
                        }
                        else{
                            $txtStatus =  "NÃO";
                            $strStyle = 'style="background-color: red; color: #FFF;"';
                        }
                        $strHtml .= '<td align="center" '.$strStyle.'>'.$txtStatus.'</td>';                        
                    $strHtml .= '</tr>';
                    }
                }
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='9'><strong>Total de Registros:</strong> ".(count($arrStrDados)-1)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum usuário encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "RelatorioGruposUsuario"){
            //lista todas as categorias, pega cada uma e conta quantos membro cada uma tem            
            //BUSCA AS CATEGORIAS            
            $strSQLCategoria  = "SELECT * FROM CAD_GRU_GRUPOS_USUARIOS WHERE GRU_Status = 'A' ";
            
            // o grupo Administrador n�o � pra ser exibido para os outros usu�rios
            if(isset($_SESSION["USUARIO_ID"])){
                if($_SESSION["USUARIO_ID"] <> -1){
                    if($_SESSION["USUARIO_ID"] <> -2){ // corresponde ao usuário SUPORTE.MS
                        $strSQL .= "AND GRU_ID <> -1 AND GRU_ID <> -2 ";
                    }else{
                        $strSQL .= "AND GRU_ID <> -1 ";
                    }
                }
            }
            
            $arrStrDadosCategoria = Db::getInstance()->select($strSQLCategoria);            
            
            $strHtml = '<h1 class="titulo_relatorio" style="font-size: 20px; margin-bottom: 20px;">Grupos de Usuários</h1>';
            $strHtml.= '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                $strHtml .= '<tr class="cabecalhoTabela">';
                    $strHtml .= '<td width="90%">Grupo</td>';
                    $strHtml .= '<td width="10%" align="center" >Qtd. Usuários</td>';                    
                $strHtml .= '</tr>';
            $classDif='';     
            if(count($arrStrDadosCategoria) > 0){
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
                    $strHtml .= '</tr>';
                }
                
                $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='2'><strong>Total de Registros:</strong> ".count($arrStrDadosCategoria)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';            
                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["relatorio"]     = $strHtml;
            }else{
                $arrStrJson["relatorio"] = "Não existem grupos de usuários cadastrados.";
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