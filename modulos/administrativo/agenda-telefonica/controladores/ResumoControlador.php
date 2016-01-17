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
            $strTipo = $_POST["PESQ_Tipo"];
            
            $arrStrFiltros = array();
            
            switch ($strTipo) {
                case "MEMBRO":
                    $arrStrFiltros["PES_Nome"] = $_POST["PESQ_Nome"];
                    $arrObjs = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
                    $arrStrDados = $arrObjs["rows"];                    
                    break;                    
                case "FUNCIONARIO":
                    $arrStrFiltros["PES_Nome"] = $_POST["PESQ_Nome"];
                    $arrObjs = FachadaCadastro::getInstance()->consultarFuncionario($arrStrFiltros);
                    $arrStrDados = $arrObjs["rows"];                    
                    break;                    
                case "FORNECEDOR":
                    $arrStrFiltros["FOR_NomeFantasia"] = $_POST["PESQ_Nome"];
                    $arrObjs = FachadaFinanceiro::getInstance()->consultarFornecedor($arrStrFiltros);
                    $arrStrDados = $arrObjs["rows"];                    
                    break;  
            }
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $strHtml = "<table border='1' class='dadosTabela' cellpadding='5' cellspacing='5' width='100%'>";
                    
                    $strHtml.= "<tr class='cabecalhoTabela'>";
                        if($strTipo == "FORNECEDOR"){
                            $strHtml.= "<td style='width:25%'>Razão Social</td>";
                        }else{
                            $strHtml.= "<td style='width:25%'>Nome</td>";
                        }
                        $strHtml.= "<td style='width:30%'>Endereço</td>";
                        $strHtml.= "<td style='width:20%'>Telefone(s)</td>";
                        $strHtml.= "<td style='width:25%'>E-mail(s)</td>";
                    $strHtml .= "</tr>";
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $strClass = 'linhaNormal';
                    
                        if($intI%2 == 0){
                            $strClass = 'linhaCor';
                        }

                        $strHtml .= '<tr class="'.$strClass.'">';
                            if($strTipo == "FORNECEDOR"){
                                $strHtml.= "<td>".$arrStrDados[$intI]["FOR_NomeFantasia"]."</td>";
                            }else{
                                $strHtml.= "<td>".$arrStrDados[$intI]["PES_Nome"]."</td>";
                            }
                            
                            $strComplemento = "";
                            
                            if($strTipo == "FORNECEDOR"){
                                if(trim($arrStrDados[$intI]["FOR_EnderecoLogradouro"]) != ""){
                                    $strComplemento = ", ".$arrStrDados[$intI]["FOR_EnderecoLogradouro"];
                                }
                                
                                $strHtml.= "<td>".$arrStrDados[$intI]["FOR_EnderecoLogradouro"].", ".$arrStrDados[$intI]["FOR_EnderecoNumero"].$strComplemento.", ".$arrStrDados[$intI]["FOR_EnderecoBairro"]." - ".$arrStrDados[$intI]["FOR_EnderecoCidade"]." - ".$arrStrDados[$intI]["FOR_EnderecoUf"]."</td>";
                            }else{
                                if(trim($arrStrDados[$intI]["PES_EnderecoLogradouro"]) != ""){
                                    $strComplemento = ", ".$arrStrDados[$intI]["PES_EnderecoLogradouro"];
                                }
                                
                                $strHtml.= "<td>".$arrStrDados[$intI]["PES_EnderecoLogradouro"].", ".$arrStrDados[$intI]["PES_EnderecoNumero"].$strComplemento.", ".$arrStrDados[$intI]["PES_EnderecoBairro"]." - ".$arrStrDados[$intI]["PES_EnderecoCidade"]." - ".$arrStrDados[$intI]["PES_EnderecoUf"]."</td>";
                            }
                            
                            if($strTipo == "FORNECEDOR"){
                                $strHtml .= "<td>";
                                    $strSqlFone  = "SELECT * FROM FIN_TEL_TELEFONE_FORNECEDORES ";
                                    $strSqlFone .= "WHERE FOR_ID = ".$arrStrDados[$intI]["FOR_ID"]." ";
                                    $arrStrDadosFone =  Db::getInstance()->select($strSqlFone);
                                    
                                    for($intZZ=0; $intZZ<count($arrStrDadosFone); $intZZ++){
                                        $strHtml .= $arrStrDadosFone[$intZZ]["TEL_Numero"]." (".$arrStrDadosFone[$intZZ]["TEL_Operadora"].")<br/>";
                                    }
                                $strHtml .= "</td>";
                            }else{
                                $strHtml .= "<td>";
                                    $strSqlFone  = "SELECT * FROM CAD_TEL_TELEFONES ";
                                    $strSqlFone .= "WHERE PES_ID = ".$arrStrDados[$intI]["PES_ID"]." ";
                                    $arrStrDadosFone =  Db::getInstance()->select($strSqlFone);
                                    
                                    for($intZZ=0; $intZZ<count($arrStrDadosFone); $intZZ++){
                                        $strHtml .= $arrStrDadosFone[$intZZ]["TEL_Numero"]." (".$arrStrDadosFone[$intZZ]["TEL_Operadora"].")<br/>";
                                    }
                                $strHtml .= "</td>";
                            }
                            
                            if($strTipo == "FORNECEDOR"){
                                $strHtml .= "<td>";
                                    $strSqlFone  = "SELECT * FROM FIN_EMA_EMAIL_FORNECEDORES ";
                                    $strSqlFone .= "WHERE FOR_ID = ".$arrStrDados[$intI]["FOR_ID"]." ";
                                    $arrStrDadosFone =  Db::getInstance()->select($strSqlFone);
                                    
                                    for($intZZ=0; $intZZ<count($arrStrDadosFone); $intZZ++){
                                        $strHtml .= $arrStrDadosFone[$intZZ]["EMA_Email"]."<br/>";
                                    }
                                $strHtml .= "</td>";
                            }else{
                                $strHtml .= "<td>";
                                    $strSqlFone  = "SELECT * FROM CAD_EMA_EMAILS ";
                                    $strSqlFone .= "WHERE PES_ID = ".$arrStrDados[$intI]["PES_ID"]." ";
                                    $arrStrDadosFone =  Db::getInstance()->select($strSqlFone);
                                    
                                    for($intZZ=0; $intZZ<count($arrStrDadosFone); $intZZ++){
                                        $strHtml .= $arrStrDadosFone[$intZZ]["EMA_Email"]."<br/>";
                                    }
                                $strHtml .= "</td>";
                            }
                        $strHtml .= "</tr>";                           
                    }
                    
                    $strHtml .= "<tr class='rodapeRelatorio'>";
                        $strHtml .= "<td colspan='4'>Total de Registros: ".count($arrStrDados)."</td>";
                    $strHtml .= "</tr>";
                    
                    $strHtml .= "</table>"; 
                }else{
                    $strHtml = '<table>';
                        $strHtml .= '<tr>';
                            $strHtml .= '<td>Nenhum registro encontrado.</td>';
                        $strHtml .= '</tr>';
                    $strHtml .= '</table>';
                }
            }else{
                $strHtml = '<table>';
                    $strHtml .= '<tr>';
                        $strHtml .= '<td>Nenhum registro encontrado.</td>';
                    $strHtml .= '</tr>';
                $strHtml .= '</table>';
            }              
                
            $arrStrJson["dados"] = $strHtml;
            $arrStrJson["sucesso"] = "true";
        }
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
    
    
    function ordenaArrayOrdemAlfabetica($a, $b) {
        return $a['nome'] > $b['nome'];
    }
    
    function buscaMembros($letra, $status){
        $arrRetorno = null;
        $arrDadosMembro = array();
        //consulta os membros                
        $strSqlMembro = "SELECT Pessoa.PES_Nome as Nome, Pessoa.PES_ID ";
        $strSqlMembro .= "FROM ADM_MEM_MEMBROS AS MEMBRO ";
        $strSqlMembro .= "INNER JOIN CAD_PES_PESSOAS AS Pessoa ON (Pessoa.PES_ID = MEMBRO.PES_ID) ";
        if($status != 0){
            $strSqlMembro .= "INNER JOIN ADM_MES_MEMBROS_STATUS AS Status ON (Status.MES_ID = MEMBRO.MES_ID) ";
        }
        if($letra != "TODAS"){
            $strSqlMembro .= "where Pessoa.PES_Nome LIKE '".$letra."%' ";
        }
        if($status != 0){
            $strSqlMembro .= "AND MEMBRO.MES_ID = ".$status." ";
        }
        $strSqlMembro .= "ORDER BY Pessoa.PES_Nome ASC ";
        $arrDadosSQLMembro =  Db::getInstance()->select($strSqlMembro);
        if($arrDadosSQLMembro != null){                    
            for($intI=0; $intI<count($arrDadosSQLMembro); $intI++){                        
                $arrRetornoMembro["nome"] = $arrDadosSQLMembro[$intI]["Nome"];
                $arrRetornoMembro["telefone"] = buscaFone($arrDadosSQLMembro[$intI]["PES_ID"]);
                $arrRetornoMembro["email"] = buscaEmail($arrDadosSQLMembro[$intI]["PES_ID"]);                                                
                $arrDadosMembro[] = $arrRetornoMembro;
            }
            $arrRetorno = $arrDadosMembro;
        }
        return $arrRetorno;
    }
    
    function buscaFuncionarios($letra){
        $arrRetorno = null;
        $arrDadosFuncionarios = array();
        //consulta os funcionarios
        $strSqlFuncionarios = "SELECT Pessoa.PES_Nome as Nome, Pessoa.PES_ID ";        
        $strSqlFuncionarios .= "FROM RH_FUN_FUNCIONARIOS AS FUNCIONARIOS ";
        $strSqlFuncionarios .= "INNER JOIN CAD_PES_PESSOAS AS Pessoa ON (Pessoa.PES_ID = FUNCIONARIOS.PES_ID) ";        
        if($letra != "TODAS"){
            $strSqlFuncionarios .= "where Pessoa.PES_Nome LIKE '".$letra."%' ";
        }
        $strSqlFuncionarios .= "ORDER BY PES_Nome ASC ";
        $arrDadosSQLFuncionarios =  Db::getInstance()->select($strSqlFuncionarios);
        if($arrDadosSQLFuncionarios != null){                    
            for($intI=0; $intI<count($arrDadosSQLFuncionarios); $intI++){                        
                $arrRetornoFuncionario["nome"] = $arrDadosSQLFuncionarios[$intI]["Nome"];
                $arrRetornoFuncionario["telefone"] = buscaFone($arrDadosSQLFuncionarios[$intI]["PES_ID"]);
                $arrRetornoFuncionario["email"] = buscaEmail($arrDadosSQLFuncionarios[$intI]["PES_ID"]);                                                
                $arrDadosFuncionarios[] = $arrRetornoFuncionario;
            }
            $arrRetorno = $arrDadosFuncionarios;
        }
        return $arrRetorno;
    }
    
    function buscaFornecedores($letra){
        $arrRetorno = null;
        $arrDadosFornecedores = array();        
        //consulta os fornecedores
        $strSqlFornecedores = "SELECT FOR_NomeFantasia, FOR_CNPJ, FOR_Telefone, FOR_Email  ";        
        $strSqlFornecedores .= "FROM FIN_FOR_FORNECEDORES ";
        if($letra != "TODAS"){
            $strSqlFornecedores .= "where FOR_NomeFantasia LIKE '".$letra."%' ";
        }
        $strSqlFornecedores .= "ORDER BY FOR_NomeFantasia ASC ";
        $arrDadosSQLFornecedores =  Db::getInstance()->select($strSqlFornecedores);                
        if($arrDadosSQLFornecedores != null){                    
            for($intI=0; $intI<count($arrDadosSQLFornecedores); $intI++){                        
                $arrRetornoFornecedor["nome"] = $arrDadosSQLFornecedores[$intI]["FOR_NomeFantasia"];
                $arrRetornoFornecedor["FOR_CNPJ"] = $arrDadosSQLFornecedores[$intI]["FOR_CNPJ"];                        
                $fone = array();
                $fone[0]["TEL_Numero"] = $arrDadosSQLFornecedores[$intI]["FOR_Telefone"];
                $fone[0]["TEL_Operadora"] = "";
                $fone[0]["TEL_NomeContato"] = "";
                $arrRetornoFornecedor["telefone"] = $fone;
                $email = array();
                $email[0]["EMA_Email"] = $arrDadosSQLFornecedores[$intI]["FOR_Email"];
                $arrRetornoFornecedor["email"] = $email;

                $arrDadosFornecedores[] = $arrRetornoFornecedor;
            }
            $arrRetorno = $arrDadosFornecedores;
        }
        return $arrRetorno;
    }
    
    function buscaFone($pesID){
        $strSqlFone = "SELECT * ";
        $strSqlFone .= "FROM CAD_TEL_TELEFONES ";
        $strSqlFone .= " WHERE PES_ID = '".$pesID."' ";                
        $strSqlFone .= "ORDER BY TEL_ID ASC ";
        $arrDadosFone =  Db::getInstance()->select($strSqlFone);
        if($arrDadosFone != null){
            return $arrDadosFone;
        }else{
            return null;
        }
    }
                
    function buscaEmail($pesID){
        $strSqlEmail = "SELECT * ";
        $strSqlEmail .= "FROM CAD_EMA_EMAILS ";
        $strSqlEmail .= " WHERE PES_ID = '".$pesID."' ";                
        $strSqlEmail .= "ORDER BY EMA_ID ASC ";
        $arrDadosEmail =  Db::getInstance()->select($strSqlEmail);
        if($arrDadosEmail != null){
            return $arrDadosEmail;
        }else{
            return null;
        }
    }
    
?>