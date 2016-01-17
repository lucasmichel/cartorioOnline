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
        if($strAcao == "AniversariantesPorMes"){
            $strSQL  = "SELECT * FROM CAD_PES_PESSOAS AS P ";             
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS M ON (P.PES_ID = M.PES_ID) ";   
            $strSQL .= "AND MONTH(P.PES_DataNascimento) = '".$_POST["PES_MesAniversario"]."' ";
            
            if(isset($_POST["UNI_ID"])){
                if($_POST["UNI_ID"] == "SEDE"){
                    $strSQL .= "AND M.UNI_ID IS NULL ";
                }else{
                    if(trim($_POST["UNI_ID"]) != ""){
                        $strSQL .= "AND M.UNI_ID=".$_POST["UNI_ID"]." ";
                    }
                }
            }
            
            if(isset($_POST["MES_ID"])){
                if(trim($_POST["MES_ID"]) != ""){
                    $strSQL .= "AND M.MES_ID = ".$_POST["MES_ID"]." ";
                }
            }
            
            if(isset($_POST["MEM_Tipo"])){
                if(trim($_POST["MEM_Tipo"]) != ""){
                    $strSQL .= "AND M.MEM_Tipo = '".$_POST["MEM_Tipo"]."' ";
                }
            }
            
            $strSQL .= "ORDER BY P.PES_Nome";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            $strStatusMembro = "TODOS";
            $strUnidade = "TODAS";

            if(isset($_POST["UNI_Descricao"])){
                if(trim($_POST["UNI_Descricao"]) != ''){
                    if($_POST["UNI_Descricao"] == "SEDE"){
                        $strUnidade = "SEDE";
                    }else{
                        $strUnidade = $_POST["UNI_Descricao"];
                    }
                }
            }

            if(isset($_POST["MES_Descricao"])){
                if(trim($_POST["MES_Descricao"]) != ''){
                    $strStatusMembro = $_POST["MES_Descricao"];
                }
            }
            
            if($arrStrDados != null){
                
                
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Aniversariantes de '.DataHelper::getInstance()->mesPorExtenso($_POST["PES_MesAniversario"]).'</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Unidade: '.$strUnidade.' Status: '.$strStatusMembro.'</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 300px; text-align: left;">Nome</td>';
                        $strHtml .= '<td style="width: 60px; text-align: center;">Data</td>';
                        $strHtml .= '<td style="width: 200px; text-align: left;">Telefone</td>';
                        $strHtml .= '<td style="width: 200px; text-align: left;">E-mail</td>';
                        $strHtml .= '<td style="width: 200px; text-align: right;">Unidade</td>';
                    $strHtml .= '</tr>';

                for($intI=0; $intI<count($arrStrDados); $intI++){
                    $strClass = 'linhaNormal';
                    
                    if($intI%2 == 0){
                        $strClass = 'linhaCor';
                    }
                    
                    $strHtml .= '<tr class="'.$strClass.'">';
                        $strHtml .= '<td valign="top">'.$arrStrDados[$intI]["PES_Nome"].'</td>';
                        $strHtml .= '<td align="center" valign="top">'.substr(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataNascimento"]), 0, 5).'</td>';
                                                
                        // identifica os telefones do membro                     
                        $strSQL  = "SELECT * FROM CAD_TEL_TELEFONES WHERE PES_ID = ".$arrStrDados[$intI]["PES_ID"]." ";                        
                        $arrStrDadosTel = Db::getInstance()->select($strSQL);
                                    
                        if(count($arrStrDadosTel) > 0){
                            $strHtml .= '<td valign="top">';
                                for($intX=0; $intX<count($arrStrDadosTel); $intX++){
                                    $strHtml .= $arrStrDadosTel[$intX]["TEL_Numero"]." | ".$arrStrDadosTel[$intX]["TEL_Operadora"]."<br/>";
                                }
                            $strHtml .= '</td>';
                        }else{
                            $strHtml .= '<td align="center"></td>';
                        }
                        
                        // identifica os e-mails do membro                     
                        $strSQL  = "SELECT * FROM CAD_EMA_EMAILS WHERE PES_ID = ".$arrStrDados[$intI]["PES_ID"]." ";                        
                        $arrStrDadosTel = Db::getInstance()->select($strSQL);
                                    
                        if(count($arrStrDadosTel) > 0){
                            $strHtml .= '<td valign="top">';
                                for($intX=0; $intX<count($arrStrDadosTel); $intX++){
                                    $strHtml .= $arrStrDadosTel[$intX]["EMA_Email"]."<br/>";
                                }
                            $strHtml .= '</td>';
                        }else{
                            $strHtml .= '<td align="center"></td>';
                        }
                        
                        if(trim($arrStrDados[$intI]["UNI_ID"]) == ""){
                            $strHtml .= '<td align="right">SEDE</td>';
                        }else{
                            $strSQL = "SELECT * FROM ADM_UNI_UNIDADES WHERE UNI_ID = ".$arrStrDados[$intI]["UNI_ID"];
                            $arrStrDadosUni = Db::getInstance()->select($strSQL);
                            $strHtml .= '<td align="right">'.$arrStrDadosUni[0]["UNI_Descricao"].'</td>';
                        }
                        
                    $strHtml .= '</tr>';
                }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='5'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Aniversariantes de '.DataHelper::getInstance()->mesPorExtenso($_POST["PES_MesAniversario"]).'</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Unidade: '.$strUnidade.' Status: '.$strStatusMembro.'</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum aniversariante em <strong>'.DataHelper::getInstance()->mesPorExtenso($_POST["PES_MesAniversario"]).'</strong>.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "EstadoCivil"){
            
            $strSQL  = "SELECT E.ECV_ID, E.ECV_Descricao, COUNT(M.PES_ID) AS Total FROM CAD_ECV_ESTADOS_CIVIS AS E ";
            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS P ON (P.ECV_ID=E.ECV_ID) "; 
            $strSQL .= "LEFT JOIN ADM_MEM_MEMBROS AS M ON (M.PES_ID=P.PES_ID) ";
            $strSQL .= "WHERE E.ECV_ID IS NOT NULL ";
            
            if(isset($_POST["UNI_ID"])){
                if(trim($_POST["UNI_ID"]) != ""){
                    $strSQL .= "AND M.UNI_ID = ".$_POST["UNI_ID"]." ";
                }
            }
            
            if(isset($_POST["MES_ID"])){
                if(trim($_POST["MES_ID"]) != ""){
                    $strSQL .= "AND M.MES_ID = ".$_POST["MES_ID"]." ";
                }
            }
            
            if(isset($_POST["MEM_Tipo"])){
                if(trim($_POST["MEM_Tipo"]) != ""){
                    $strSQL .= "AND M.MEM_Tipo = '".$_POST["MEM_Tipo"]."' ";
                }
            }
            
            $strSQL .= "GROUP BY E.ECV_ID ";
            $strSQL .= "ORDER BY E.ECV_Descricao ";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            $strStatusMembro = "TODOS";
            $strUnidade = "TODAS";

            if(isset($_POST["UNI_Descricao"])){
                if(trim($_POST["UNI_Descricao"]) != ''){
                    if($_POST["UNI_Descricao"] == "SEDE"){
                        $strUnidade = "SEDE";
                    }else{
                        $strUnidade = $_POST["UNI_Descricao"];
                    }
                }
            }

            if(isset($_POST["MES_Descricao"])){
                if(trim($_POST["MES_Descricao"]) != ''){
                    $strStatusMembro = $_POST["MES_Descricao"];
                }
            }
            
            if($arrStrDados != ""){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Quantidade de Membros por Estado Civil</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Unidade: '.$strUnidade.' Status: '.$strStatusMembro.'</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 60px; text-align: left;">C&oacute;d.</td>';
                        $strHtml .= '<td style="width: 400px; text-align: left;">Estado Civil</td>';
                        $strHtml .= '<td style="text-align: right;width: 60px;">Qtd.</td>';
                    $strHtml .= '</tr>';
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';

                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }

                        $strHtml .= '<tr class="'.$strClass.'">';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["ECV_ID"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["ECV_Descricao"].'</td>';                            
                            $strHtml .= '<td style="text-align: right;">'.$arrStrDados[$intI]["Total"].'</td>';
                        $strHtml .= '</tr>';    
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='3'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Quantidade de Membros por Estado Civil</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Unidade: '.$strUnidade.' Status: '.$strStatusMembro.'</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum estado civil encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
                $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "MembroGeral"){            
            $arrConsulta = array();
            if(isset($_POST["MES_ID"])){
                if($_POST["MES_ID"]>0){
                    $arrConsulta["MES_ID"] = $_POST["MES_ID"];
                }
            }
            if(isset($_POST["PES_Sexo"])){
                if($_POST["PES_Sexo"]!=""){
                    $arrConsulta["PES_Sexo"] = $_POST["PES_Sexo"];
                }
            }
            if(isset($_POST["NES_ID"])){
                if($_POST["NES_ID"]>0){
                    $arrConsulta["NES_ID"] = $_POST["NES_ID"];
                }
            }
            if(isset($_POST["ECV_ID"])){
                if($_POST["ECV_ID"]>0){
                    $arrConsulta["ECV_ID"] = $_POST["ECV_ID"];
                }
            }
            if(isset($_POST["MEM_Tipo"])){
                if($_POST["MEM_Tipo"]!=""){
                    $arrConsulta["MEM_Tipo"] = $_POST["MEM_Tipo"];
                }
            }
            
            $arrStrDados = NegMembro::getInstance()->consultar($arrConsulta);
            if($arrStrDados != ""){                
                $arrStrDados = $arrStrDados["objects"];                
                $arrObjsMembro = ordenaArrayMembrosIdade($arrStrDados, $_POST["MaiorMenor"], $_POST["PES_Idade"]);                
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Membros</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 80px; text-align: left;">Matrícula</td>';
                        $strHtml .= '<td style="width: 320px; text-align: left;">Nome</td>';
                        $strHtml .= '<td style="width: 40px; text-align: center;">Sexo</td>';
                        $strHtml .= '<td style="width: 40px; text-align: center;">Dt. Nasc.</td>';
                        $strHtml .= '<td style="width: 60px; text-align: center;">Idade</td>';
                        $strHtml .= '<td style="width: 100px; text-align: center;">N&ordm; Ficha/Livro</td>';
                        $strHtml .= '<td style="text-align: left; width: 100px;">Status</td>';
                        $strHtml .= '<td style="text-align: left;">Unidade(Matriz/Congregação)</td>';
                    $strHtml .= '</tr>';
                    
                    for($intI=0; $intI<count($arrObjsMembro); $intI++){
                        $strClass = 'linhaNormal';

                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }
                        
                        $membro = new Membro();
                        $membro = $arrObjsMembro[$intI];
                        

                        $strHtml .= '<tr class="'.$strClass.'">';
                            $strHtml .= '<td>'.$membro->getMatricula().'</td>';
                            $strHtml .= '<td>'.$membro->getNome().'</td>';
                            
                            $strSexo = "MASCULINO";
                            
                            if($membro->getSexo() == "F"){
                                $strSexo = "FEMININO";
                            }
                            
                            $strHtml .= '<td style="text-align: center;">'.$strSexo.'</td>';                            
                            //$strHtml .= '<td style="text-align: center;">'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataNascimento"]).'</td>';
                            $strHtml .= '<td style="text-align: center;">'.$membro->getDataNascimento().'</td>';
                            $strHtml .= '<td style="text-align: center;">'.$membro->getIdade().'</td>';
                            $strHtml .= '<td style="text-align: center;">'.$membro->getNumeroFicha().'</td>';
                            $strHtml .= '<td>'. $membro->getStatusMembro()->getDescricao().'</td>';
                            
                            $strHtml .= '<td>'.$membro->getCongregacao()->getDescricao().'</td>';
                        $strHtml .= '</tr>';    
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='7'>Total de Registros: ".count($arrObjsMembro)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
                
                $arrStrJson["relatorio"] = $strHtml;
                $arrStrJson["sucesso"] = "true";
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Membros</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum membro encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "Sexo"){ 
            
            $strSQL  = "SELECT P.PES_Sexo, COUNT(M.PES_ID) AS Total FROM CAD_PES_PESSOAS AS P ";
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS M ON (M.PES_ID=P.PES_ID) ";
            $strSQL .= "WHERE P.PES_ID IS NOT NULL ";
            
            if(isset($_POST["UNI_ID"])){
                if(trim($_POST["UNI_ID"]) != ""){
                    $strSQL .= "AND M.UNI_ID = ".$_POST["UNI_ID"]." ";
                }
            }
            
            if(isset($_POST["MES_ID"])){
                if(trim($_POST["MES_ID"]) != ""){
                    $strSQL .= "AND M.MES_ID = ".$_POST["MES_ID"]." ";
                }
            }
            
            if(isset($_POST["MEM_Tipo"])){
                if(trim($_POST["MEM_Tipo"]) != ""){
                    $strSQL .= "AND M.MEM_Tipo = '".$_POST["MEM_Tipo"]."' ";
                }
            }
            
            $strSQL .= "GROUP BY P.PES_Sexo ";
            $strSQL .= "ORDER BY P.PES_Sexo ";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            $strStatusMembro = "TODOS";
            $strUnidade = "TODAS";

            if(isset($_POST["UNI_Descricao"])){
                if(trim($_POST["UNI_Descricao"]) != ''){
                    if($_POST["UNI_Descricao"] == "SEDE"){
                        $strUnidade = "SEDE";
                    }else{
                        $strUnidade = $_POST["UNI_Descricao"];
                    }
                }
            }

            if(isset($_POST["MES_Descricao"])){
                if(trim($_POST["MES_Descricao"]) != ''){
                    $strStatusMembro = $_POST["MES_Descricao"];
                }
            }
            
            if($arrStrDados != ""){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Quantidade de Membros por Sexo</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Unidade: '.$strUnidade.' Status: '.$strStatusMembro.'</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 300px; text-align: left;">Sexo</td>';
                        $strHtml .= '<td style="text-align: right;width: 60px;">Qtd.</td>';
                    $strHtml .= '</tr>';
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';

                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }

                        $strHtml .= '<tr class="'.$strClass.'">';
                            
                            $strSexo = "MASCULINO";
                        
                            if($arrStrDados[$intI]["PES_Sexo"] == "F"){
                                $strSexo = "FEMININO";
                            }
                        
                            $strHtml .= '<td>'.$strSexo.'</td>';                                                    
                            $strHtml .= '<td style="text-align: right;">'.$arrStrDados[$intI]["Total"].'</td>';
                        $strHtml .= '</tr>';    
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='2'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Quantidade de Membros por Sexo</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Unidade: '.$strUnidade.' Status: '.$strStatusMembro.'</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum membro encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "FuncionarioGeral"){
            $strSQL  = "SELECT * FROM CAD_PES_PESSOAS AS P ";
            $strSQL .= "INNER JOIN RH_FUN_FUNCIONARIOS AS F ON (F.PES_ID=P.PES_ID) ";            
            $strSQL .= "WHERE P.PES_ID IS NOT NULL ";
                        
            if(trim($_POST["PES_Sexo"]) != ""){
                $strSQL .= "AND P.PES_Sexo = '".$_POST["PES_Sexo"]."' ";
            }
            
            if(trim($_POST["NES_ID"]) != ""){
                $strSQL .= "AND P.NES_ID = ".$_POST["NES_ID"]." ";
            }
            
            if(trim($_POST["ECV_ID"]) != ""){
                $strSQL .= "AND P.ECV_ID = ".$_POST["ECV_ID"]." ";
            }
            
            if(trim($_POST["PES_Status"]) != ""){
                $strSQL .= "AND P.PES_Status = '".$_POST["PES_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY P.PES_Nome ";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != ""){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Funcionários</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 80px; text-align: left;">Matrícula</td>';
                        $strHtml .= '<td style="width: 520px; text-align: left;">Nome</td>';
                        $strHtml .= '<td style="width: 40px; text-align: center;">Sexo</td>';
                        $strHtml .= '<td style="width: 40px; text-align: center;">Dt. Nasc.</td>';
                        $strHtml .= '<td style="text-align: left; width: 100px;">Função</td>';
                        $strHtml .= '<td style="text-align: center; width: 100px;">Ativo</td>';
                    $strHtml .= '</tr>';
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';

                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }

                        $strHtml .= '<tr class="'.$strClass.'">';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["PES_Matricula"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["PES_Nome"].'</td>';
                            
                            $strSexo = "MASCULINO";
                            
                            if($arrStrDados[$intI]["PES_Sexo"] == "F"){
                                $strSexo = "FEMININO";
                            }
                            
                            $strHtml .= '<td style="text-align: center;">'.$strSexo.'</td>';                            
                            $strHtml .= '<td style="text-align: center;">'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PES_DataNascimento"]).'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["FUN_Funcao"].'</td>';
                            
                            $strStatus = "SIM";
                            
                            if($arrStrDados[$intI]["PES_Status"] == "I"){
                                $strStatus = "NÃO";
                            }
                            
                            $strHtml .= '<td style="text-align: center;">'.$strStatus.'</td>';
                            
                        $strHtml .= '</tr>';    
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='6'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
                
                $arrStrJson["relatorio"] = $strHtml;
                $arrStrJson["sucesso"] = "true";
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Funcionários</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum funcionário encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "Congregacoes"){
            $strSQL  = "SELECT * FROM ADM_UNI_UNIDADES AS U ";          
            $strSQL .= "WHERE U.UNI_ID IS NOT NULL ";
            
            if(isset($_POST["UNI_Status"])){
                if(trim($_POST["UNI_Status"]) != ""){
                    $strSQL .= "AND U.UNI_Status = '".$_POST["UNI_Status"]."' ";
                }
            }
            
            $strSQL .= "ORDER BY U.UNI_Descricao ";
            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != ""){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Congregações</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 60px; text-align: left;">Cód.</td>';
                        $strHtml .= '<td style="width: 520px; text-align: left;">Nome da Congregação</td>';
                        $strHtml .= '<td style="width: 80px; text-align: center;">Telefone</td>';
                        $strHtml .= '<td style="width: 80px; text-align: center;">Fax</td>';
                        $strHtml .= '<td style="text-align: left; width: 100px;">Responsável</td>';
                        $strHtml .= '<td style="text-align: center; width: 100px;">Ativo</td>';
                    $strHtml .= '</tr>';
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';

                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }

                        $strHtml .= '<tr class="'.$strClass.'">';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["UNI_ID"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["UNI_Descricao"].'</td>';
                            $strHtml .= '<td style="text-align: center;">'.$arrStrDados[$intI]["UNI_Telefone"].'</td>';                            
                            $strHtml .= '<td style="text-align: center;">'.$arrStrDados[$intI]["UNI_Fax"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["UNI_Responsavel"].'</td>';
                            
                            $strStatus = "SIM";
                            
                            if($arrStrDados[$intI]["UNI_Responsavel"] == "I"){
                                $strStatus = "NÃO";
                            }
                            
                            $strHtml .= '<td style="text-align: center;">'.$strStatus.'</td>';
                        $strHtml .= '</tr>';    
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='6'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
                
                $arrStrJson["relatorio"] = $strHtml;
                $arrStrJson["sucesso"] = "true";
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Congregações</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhuma congregação encontrada.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "Ministerios"){
            $strSQL  = "SELECT * FROM ADM_MIN_MINISTERIOS AS MINISTERIOS ";          
            $strSQL .= "LEFT JOIN ADM_AMI_AREAS_MINISTERIAIS AS AREA_MIINISTERIAIS ON (AREA_MIINISTERIAIS.AMI_ID = MINISTERIOS.AMI_ID) ";            
            $strSQL .= "WHERE MINISTERIOS.MIN_ID IS NOT NULL ";            
            
            if(isset($_POST["AMI_ID"])){
                if(trim($_POST["AMI_ID"]) != ""){
                    $strSQL .= "AND MINISTERIOS.AMI_ID = ".$_POST["AMI_ID"]." ";
                }
            }
            
            if(isset($_POST["MIN_ID"])){
                if(trim($_POST["MIN_ID"]) != ""){
                    $strSQL .= "AND MINISTERIOS.MIN_ID = ".$_POST["MIN_ID"]." ";
                }
            }
            
            $strSQL .= "ORDER BY MINISTERIOS.MIN_Descricao ASC";            
            $arrStrDados = Db::getInstance()->select($strSQL);
            
            if($arrStrDados != ""){
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Ministérios</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';
                    $strHtml .= '<tr class="cabecalhoTabela">';
                        $strHtml .= '<td style="width: 60px; text-align: left;">Cód.</td>';
                        $strHtml .= '<td style="width: 400px; text-align: left;">Nome do Ministerio</td>';
                        $strHtml .= '<td style="width: 400px; text-align: left;">Área Ministerial</td>';
                        $strHtml .= '<td style="width: 150px; text-align: left;">Total de Membros</td>';                        
                    $strHtml .= '</tr>';                                                           
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';
                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }
                        $strHtml .= '<tr class="'.$strClass.'">';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["MIN_ID"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["MIN_Descricao"].'</td>';
                            $strHtml .= '<td>'.$arrStrDados[$intI]["AMI_Descricao"].'</td>';
                            $strSQLTot  = "SELECT COUNT(MIN_ID) AS TOTAL FROM ADM_MMI_MEMBROS_X_MINISTERIOS AS MIN_X_MEM ";          
                            $strSQLTot .= "WHERE MIN_X_MEM.MIN_ID = ".$arrStrDados[$intI]["MIN_ID"]." ";                            
                            $arrStrTot = Db::getInstance()->select($strSQLTot);                            
                            $strHtml .= '<td>'.$arrStrTot[0]["TOTAL"].'</td>';                            
                        $strHtml .= '</tr>';    
                    }
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='6'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                $strHtml .= '</table>';
                
                $arrStrJson["relatorio"] = $strHtml;
                $arrStrJson["sucesso"] = "true";
            }else{
                $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Congregações</h1>';
                $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">&nbsp;</h2>';
                $strHtml .= '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum ministério encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "MembrosMinisterios"){
            if($_POST["MIN_ID"] == ""){
                //todos os ministerios
                if($_POST["AMI_ID"] == ""){
                    //todas as areas ministeriais
                    $strSQL  = " SELECT * FROM ADM_MIN_MINISTERIOS AS MINISTERIOS WHERE MINISTERIOS.MIN_Status = 'A' ORDER BY MINISTERIOS.MIN_Descricao ASC ";
                }else{
                    $strSQL  = " SELECT * FROM ADM_MIN_MINISTERIOS AS MINISTERIOS WHERE MINISTERIOS.MIN_Status = 'A' AND MINISTERIOS.AMI_ID = ".$_POST["AMI_ID"]." ORDER BY MINISTERIOS.MIN_Descricao ASC ";
                }                
            }else{                
                if($_POST["AMI_ID"] == ""){
                    //todas as areas ministeriais
                    $strSQL  = " SELECT * FROM ADM_MIN_MINISTERIOS AS MINISTERIOS WHERE MINISTERIOS.MIN_Status = 'A' AND MINISTERIOS.MIN_ID = ".$_POST["MIN_ID"]." ORDER BY MINISTERIOS.MIN_Descricao ASC ";
                }else{
                    $strSQL  = " SELECT * FROM ADM_MIN_MINISTERIOS AS MINISTERIOS WHERE MINISTERIOS.MIN_Status = 'A' AND MINISTERIOS.MIN_ID = ".$_POST["MIN_ID"]." AND MINISTERIOS.AMI_ID = ".$_POST["AMI_ID"]." ORDER BY MINISTERIOS.MIN_Descricao ASC ";
                }
            }
                $arrStrDadosMini = Db::getInstance()->select($strSQL);
                if($arrStrDadosMini != null){                    
                    $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Membros por Ministério</h1>';
                    $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Período de '.$_POST["MMI_Desde"].' a '.$_POST["MMI_Ate"].'</h2>';
                    
                    $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';

                    for($intI = 0; $intI<count($arrStrDadosMini); $intI++){                        
                        $strHtml .= '<tr class=" cabecalhoTabela ">';
                            $strHtml .= '<td>'.$arrStrDadosMini[$intI]["MIN_Descricao"].'</td>';
                        $strHtml .= '</tr>';
                        //consulta os membros desse ministerio
                        $strSQLRela  = " SELECT * FROM ADM_MMI_MEMBROS_X_MINISTERIOS AS MINISTERIO_X_MEMBRO ";
                        $strSQLRela .= " INNER JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID = MINISTERIO_X_MEMBRO.PES_ID) ";  
                        $strSQLRela .= " INNER JOIN CAD_PES_PESSOAS AS PESSOA  ON (PESSOA.PES_ID = MEMBRO.PES_ID)";                            
                            
                        if($_POST["PES_ID"] == "" ){
                            $strSQLRela .= " WHERE MINISTERIO_X_MEMBRO.MIN_ID = ".$arrStrDadosMini[$intI]["MIN_ID"]." ";
                        }else{
                            $strSQLRela .= " WHERE MINISTERIO_X_MEMBRO.MIN_ID = ".$arrStrDadosMini[$intI]["MIN_ID"]." AND PESSOA.PES_ID = ".$_POST["PES_ID"]." ";
                        }   
                        if(isset($_POST["MMI_Desde"]) && isset($_POST["MMI_Ate"])){                            
                            $strSQLRela .= "AND (((MINISTERIO_X_MEMBRO.MMI_Desde >=  '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["MMI_Desde"])."') ";                            
                            $strSQLRela .= "AND (MINISTERIO_X_MEMBRO.MMI_Ate <=  '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["MMI_Ate"])."') )";                            
                                                        
                            $strSQLRela .= " OR ((MINISTERIO_X_MEMBRO.MMI_Desde <=  '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["MMI_Ate"])."') ";
                            $strSQLRela .= " AND (MINISTERIO_X_MEMBRO.MMI_Ate IS NULL)))";
                        }
                        
                        
                        $arrStrDadosRela = Db::getInstance()->select($strSQLRela);                        
                        $strHtml .='<tr>';
                            $strHtml .='<td>';                                
                            if($arrStrDadosRela != null){                            
                                $strHtml .= '<table style="width: 100%;">';
                                $strHtml .= '<tr >';                                
                                    $strHtml .= '<td style="width: 400px; text-align: left;">Nome</td>';
                                    $strHtml .= '<td style="width: 120px; text-align: left;">Início no ministério</td>';
                                    $strHtml .= '<td style="width: 120px; text-align: left;">Término no ministério</td>';
                                $strHtml .= '</tr>';                                
                                for($intZ = 0; $intZ<count($arrStrDadosRela); $intZ++){
                                    $strClass = 'linhaNormal';
                                    if($intZ%2 == 0){
                                        $strClass = 'linhaCor';
                                    }
                                    $strHtml .= '<tr class="'.$strClass.'">';
                                    $strHtml .= '<td>'.$arrStrDadosRela[$intZ]["PES_Nome"].'</td>';
                                    $strHtml .= '<td>'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosRela[$intZ]["MMI_Desde"]).'</td>';                                    
                                    if($arrStrDadosRela[$intZ]["MMI_Ate"] != null){
                                        $strHtml .= '<td>'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosRela[$intZ]["MMI_Ate"]).'</td>';
                                    }else{
                                        $strHtml .= '<td> </td>';
                                    }                                    
                                    $strHtml .= '</tr>';
                                }
                                
                                $strHtml .= '<tr>';
                                    $strHtml .= '<td></td>';
                                    $strHtml .= '<td></td>';
                                    $strHtml .= '<td style="text-align: right;" >';
                                        $strHtml .= 'Total de Registro(s): '.count($arrStrDadosRela);                                    
                                    $strHtml .= '</td>';
                                $strHtml .= '</tr>';
                                
                                $strHtml .= '</table>';
                            }else{                                
                                $strHtml .= '<table>';
                                    $strHtml .= '<tr>';
                                        $strHtml .= '<td>Nenhum membro relacionado a este ministério.</td>';
                                    $strHtml .= '</tr>';
                                $strHtml .= '</table>';
                            }
                            $strHtml .= '</td>';
                        $strHtml .= '</tr>';
                    }                    
                    $strHtml .= '</table>';                    
                }else{                    
                    $strHtml .= '<table>';
                        $strHtml .= '<tr>';
                            $strHtml .= '<td>Nenhum ministério encontrado.</td>';
                        $strHtml .= '</tr>';
                    $strHtml .= '</table>';
                }
            $arrStrJson["relatorio"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
        
        elseif($strAcao == "MembrosAtividades"){
            if($_POST["ATV_ID"] == ""){
                //todos
                $strSQL  = " SELECT * FROM ADM_ATV_ATIVIDADES AS ATIVIDADE WHERE ATIVIDADE.ATV_Status = 'A' ORDER BY ATIVIDADE.ATV_Descricao ASC";
            }else{
                $strSQL  = " SELECT * FROM ADM_ATV_ATIVIDADES AS ATIVIDADE WHERE ATIVIDADE.ATV_Status = 'A' AND ATIVIDADE.ATV_ID = ".$_POST["ATV_ID"]." ORDER BY ATIVIDADE.ATV_Descricao ASC ";
            }
                $arrStrDadosAtivi = Db::getInstance()->select($strSQL);
                if($arrStrDadosAtivi != null){                    
                    $strHtml  = '<h1 class="titulo_relatorio" style="font-size: 20px; margin: 5px;">Membros por Atividade</h1>';
                    $strHtml .= '<h2 class="subtitulo_relatorio" style="font-size: 16px; margin: 5px;">Período de '.$_POST["ATM_Desde"].' a '.$_POST["ATM_Ate"].'</h2>';
                    
                    $strHtml .= '<table id="tableRelatorio" class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%" style="width: 100%;">';

                    for($intI = 0; $intI<count($arrStrDadosAtivi); $intI++){                        
                        $strHtml .= '<tr class=" cabecalhoTabela ">';
                            $strHtml .= '<td>'.$arrStrDadosAtivi[$intI]["ATV_Descricao"].'</td>';
                        $strHtml .= '</tr>';
                        //consulta os membros desse ministerio
                        $strSQLRela  = " SELECT * FROM ADM_ATM_ATIVIDADES_MEMBROS AS ATIVIDADE_MEMBRO ";
                        $strSQLRela .= " INNER JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID = ATIVIDADE_MEMBRO.PES_ID) ";  
                        $strSQLRela .= " INNER JOIN CAD_PES_PESSOAS AS PESSOA  ON (PESSOA.PES_ID = MEMBRO.PES_ID)";                            
                            
                        if($_POST["PES_ID"] == "" ){
                            $strSQLRela .= " WHERE ATIVIDADE_MEMBRO.ATV_ID = ".$arrStrDadosAtivi[$intI]["ATV_ID"]." ";
                        }else{
                            $strSQLRela .= " WHERE ATIVIDADE_MEMBRO.ATV_ID = ".$arrStrDadosAtivi[$intI]["ATV_ID"]." AND PESSOA.PES_ID = ".$_POST["PES_ID"]." ";
                        }
                        
                        
                        if(isset($_POST["ATM_Desde"]) && isset($_POST["ATM_Ate"])){                            
                            $strSQLRela .= "AND (((ATIVIDADE_MEMBRO.ATM_Desde >=  '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["ATM_Desde"])."') ";
                            
                            $strSQLRela .= " AND (ATIVIDADE_MEMBRO.ATM_Ate <=  '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["ATM_Ate"])."') )";
                            
                            $strSQLRela .= " OR ((ATIVIDADE_MEMBRO.ATM_Desde <=  '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["ATM_Ate"])."') ";
                            $strSQLRela .= " AND (ATIVIDADE_MEMBRO.ATM_Ate IS NULL)))";
                            
                        }
                        
                        $arrStrDadosRela = Db::getInstance()->select($strSQLRela);                        
                        $strHtml .='<tr>';
                            $strHtml .='<td>';                                
                            if($arrStrDadosRela != null){                            
                                $strHtml .= '<table style="width: 100%;">';
                                $strHtml .= '<tr >';                                
                                    $strHtml .= '<td style="width: 400px; text-align: left;">Nome</td>';
                                    $strHtml .= '<td style="width: 120px; text-align: left;">Início da atividade</td>';
                                    $strHtml .= '<td style="width: 120px; text-align: left;">Término da atividade</td>';
                                $strHtml .= '</tr>';                                
                                for($intZ = 0; $intZ<count($arrStrDadosRela); $intZ++){
                                    $strClass = 'linhaNormal';
                                    if($intZ%2 == 0){
                                        $strClass = 'linhaCor';
                                    }
                                    $strHtml .= '<tr class="'.$strClass.'">';
                                    $strHtml .= '<td>'.$arrStrDadosRela[$intZ]["PES_Nome"].'</td>';
                                    $strHtml .= '<td>'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosRela[$intZ]["ATM_Desde"]).'</td>';                                    
                                    if($arrStrDadosRela[$intZ]["ATM_Ate"] != null){
                                        $strHtml .= '<td>'.DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosRela[$intZ]["ATM_Ate"]).'</td>';
                                    }else{
                                        $strHtml .= '<td> </td>';
                                    }                                    
                                    $strHtml .= '</tr>';
                                }
                                $strHtml .= '<tr>';
                                    $strHtml .= '<td></td>';
                                    $strHtml .= '<td></td>';
                                    $strHtml .= '<td style="text-align: right;" >';
                                        $strHtml .= 'Total de Registro(s): '.count($arrStrDadosRela);                                    
                                    $strHtml .= '</td>';
                                $strHtml .= '</tr>';
                                
                                $strHtml .= '</table>';
                            }else{                                
                                $strHtml .= '<table style="width: 100%; " >';
                                    $strHtml .= '<tr>';
                                        $strHtml .= '<td style="width: 100%; text-align: left;" >Nenhum membro relacionado a esta atividade.</td>';
                                    $strHtml .= '</tr>';
                                    
                                    $strHtml .= '<tr>';
                                    
                                        $strHtml .= '<td style="width: 100%;  text-align: right;" >';
                                            $strHtml .= 'Total de Registro(s): 0';
                                        $strHtml .= '</td>';
                                    
                                    $strHtml .= '</tr>';
                                    
                                    
                                $strHtml .= '</table>';
                            }
                            $strHtml .= '</td>';
                        $strHtml .= '</tr>';
                    }                    
                    $strHtml .= '</table>';                    
                }else{                    
                    $strHtml .= '<table>';
                        $strHtml .= '<tr>';
                            $strHtml .= '<td>Nenhum atividade encontrado.</td>';
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

    function ordenaArrayMembrosIdade($arrayObjetos, $maiorMenor, $idade){        
        $arrayObjRetorno = array();
        if(($maiorMenor != "") && ($idade != "")){
            for($intI=0; $intI<count($arrayObjetos); $intI++){
                $membro = new Membro();
                $membro = $arrayObjetos[$intI];
                $arrIdade = explode(" ", $membro->getIdade());
                switch ($maiorMenor) {
                    case "MAIOR":
                        ///ORDENA O ARRAY SENDO MAIOR QUE A IDADE                
                        if($arrIdade[0] > $idade){
                            $arrayObjRetorno[] = $membro;
                        }
                        break;
                    case "MENOR":
                        ///ORDENA O ARRAY SENDO MENOR QUE A IDADE                
                        if($arrIdade[0] < $idade){
                            $arrayObjRetorno[] = $membro;
                        }
                        break;
                    default:
                       ///ORDENA O ARRAY SENDO IGUAL QUE A IDADE                
                        if($arrIdade[0] == $idade){
                            $arrayObjRetorno[] = $membro;
                        }                    
                }
            }
        }else{
            $arrayObjRetorno = $arrayObjetos;
        }
        return $arrayObjRetorno;
    }
    
    echo json_encode($arrStrJson);
?>