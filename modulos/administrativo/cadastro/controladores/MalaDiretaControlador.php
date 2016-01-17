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
            $arrObjs = FachadaCadastro::getInstance()->consultarMalaDireta($_POST);            
            if($arrObjs != null){
                $arrStrJson["rows"]     = $arrObjs["rows"];
                $arrStrJson["num_rows"] = $arrObjs["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }
        }elseif($strAcao == "Salvar"){             
            if(FachadaCadastro::getInstance()->salvarMalaDireta($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }        
        }elseif($strAcao == "Excluir"){             
            if(FachadaCadastro::getInstance()->excluirMalaDireta($_POST)){                
                $arrStrJson["sucesso"]  = "true";
                $arrStrJson["mensagem"] = MensagemHelper::getInstance()->getOperacaoRealizadaComSucesso();
            }        
        }elseif($strAcao == "ConsultarPessoas"){  
            $arrObjsPessoa = FachadaCadastro::getInstance()->consultarPessoasMalaDireta($_POST);              
            if($arrObjsPessoa != null){
                $arrStrJson["rows"]     = $arrObjsPessoa["rows"];
                //$arrStrJson["num_rows"] = $arrObjsPessoa["num_rows"];
                $arrStrJson["sucesso"]  = "true";
            }                    
        }elseif($strAcao == "EnviarEmails"){
            if(FachadaCadastro::getInstance()->enviarEmailMalaDireta($_POST)){                 
                $arrStrJson["sucesso"]  = "true";
            }else{
                $arrStrJson["sucesso"]  = "false";
            }                    
            
        }elseif($strAcao == "ConsultarRelatorio"){               
            $arrConsTotais["MAD_ID"] = $_POST["MAD_ID"];
            $arrObjs = FachadaCadastro::getInstance()->consultarMalaDireta($arrConsTotais);                        
            if($arrObjs != null){
                    $arrObjs = $arrObjs["objects"];                    
                    
                    $arrDados = array();
                    $arrDados["chart"]["title"] = "Relatório Mala Direta";
                    $arrDados["chart"]["text"] = "Texto";
                    
                    $strHtml = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                        $strHtml .= '<tr class="cabecalhoTabela">';
                            $strHtml .= '<td width="60%">ASSUNTO</td>';
                            $strHtml .= '<td width="15%" align="center">ENVIADOS</td>';                                
                            $strHtml .= '<td width="15%" align="center">VISUALIZADOS</td>';                                
                            $strHtml .= '<td width="10%" align="center">EXPLORAR</td>'; 
                        $strHtml .= '</tr>';
                    
                        if(count($arrObjs) > 0){
                            for($intI=0; $intI<count($arrObjs); $intI++){
                                
                                $classDif = 'class="linhaNormal"';
                                if($intI%2 == 0){
                                    $classDif = 'class="linhaCor"';
                                }        
                                
                                
                                $malaDireta = new MalaDireta();
                                $malaDireta = $arrObjs[$intI];
                                // com a mala direta, busca os totais de enviados e visualizados
                                $arrConsTotais["MAD_ID"] = $malaDireta->getId();
                                $arrTotais = NegMalaDiretaPessoa::getInstance()->retornaTotalVisualizadoEnviado($arrConsTotais);
                                

                                $strHtml .= '<tr '.$classDif.'>';                                
                                    $strHtml .= '<td>'.$malaDireta->getAssunto().'</td>';                                    
                                    $strHtml .= '<td align="center">'.$arrTotais["totEnviado"][0]["Total"].'</td>';                                    
                                    $strHtml .= '<td align="center">'.$arrTotais["totVisualizado"][0]["Total"].'</td>';
                                    $strHtml .= '<td align="center">';                                    
                                        $strHtml .= "<a href='javascript:void(0);' title='Explorar: " . $malaDireta->getAssunto() . "'><img onclick='openExplorarEnvio(" . $malaDireta->getId() . " );' class='btnExplorarMala' alt='Explorar' src='../../../modulos/sistema/home/img/botao-pesquisar.png' border='0'/></a>";
                                    $strHtml .= '</td>';
                                    
                                $strHtml .= '</tr>';
                            }                        
                            $strHtml .= '</table>';
                        }else{
                            $strHtml = '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
                                $strHtml .= '<tr>';
                                    $strHtml .= '<td>Nenhuma Mala Direta encontrada.</td>';
                                $strHtml .= '</tr>';
                            $strHtml .= '<table>';
                        }
                        
                        
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
                    
                
            }else{
                $arrStrJson["mensagem"] = "Nenhuma Mala Direta encontrada.";
                $arrStrJson["sucesso"]  = "false";
            }             
        
        }
        
        
        elseif($strAcao == "ExplorarEnvio"){                         
            
            $arrConsTotais["MAD_ID"] = $_POST["MAD_ID"];
            $arrObjs = NegMalaDiretaPessoa::getInstance()->consultar($arrConsTotais);
            
            if($arrObjs != null){
                    $arrObjs = $arrObjs["objects"];                    
                    $arrRetornoDados = array();
                    for ($intI=0; $intI<count($arrObjs); $intI++) {                        
                        
                        $envio = new MalaDiretaPessoa();
                        $envio = $arrObjs[$intI];
                        $pessoa = new Pessoa();
                        $pessoa = $envio->getPessoa();
                        
                        $arrRetornoDados[$intI]["PES_Nome"] = $pessoa->getNome();
                        $arrRetornoDados[$intI]["PES_Foto"] = $pessoa->getFoto();                        
                        $arrRetornoDados[$intI]["MDP_DataHoraEnvio"] = $envio->getDataEnvio();
                        $arrRetornoDados[$intI]["MDP_DataHoraLeitura"] = $envio->getDataVisualizacao();
                        
                    }
                    $arrStrJson["rows"] = $arrRetornoDados;                    
                    $arrStrJson["sucesso"]  = "true";
                
            }else{
                $arrStrJson["sucesso"]  = "false";
            }             
        }
        
        
        
    }catch(Exception $objException){
        $arrStrJson["excecao"]  = "true";
        $arrStrJson["sucesso"]  = "false";
        $arrStrJson["mensagem"] = $objException->getMessage();        
    }

    echo json_encode($arrStrJson);
?>