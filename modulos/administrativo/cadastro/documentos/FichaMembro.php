<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
?>
<html>
    <head>
        <title>Ficha do Membro</title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/ficha.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>
    </head>
    <body>     
        <div id="containerFicha">
            <?php
                include("../../../sistema/gerencial/inc/executar-impressao.inc.php");
            ?>
            <div id="impressaoConteudo">
                <div id="cabecalho">
                    <div id="logo">
                        <?php
                            include("../../../sistema/gerencial/inc/cabecalho-impressao.inc.php");
                        ?>
                    </div>
                    <div id="titulo">
                        <h1>Ficha do Membro</h1>
                    </div>
                </div>
                <hr/>
                <div id="ficha">
                    <?php
                    if(isset($_GET["PES_ID"])){
                        $intPessoaID = SegurancaHelper::getInstance()->removerSQLInjection($_GET["PES_ID"]);
                        $arrStrFiltros = array();
                        $arrStrFiltros["PES_ID"] = $intPessoaID;
                        $arrObjs = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
                        $membro = new Membro();
                        $membro = $arrObjs["objects"][0];
                    ?>                
                    <h1>Dados Pessoais</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td rowspan="4" valign="top">
                                <?php 
                                    $strImg = $membro->getFoto();

                                    if(isset($strImg)){
                                       if($strImg != null){                                       
                                           echo '<img src="'.$strImg.'" width=180px" height="150px"  />';
                                       }else{
                                           echo '<img src="../../../sistema/home/img/sem-foto.png" width="180px" height="150px"  />';
                                       }
                                    }else{
                                        echo '<img src="../../../sistema/home/img/sem-foto.png" width="180px" height="150px"  />';
                                    }
                                ?>
                            </td>
                            <td style="width: 100px;">Cód.</td>
                            <td style="width: 100px;">Matrícula</td>
                            <td style="width: 400px;" colspan="4">Nome</td>
                            <td style="width: 100px;">CPF</td>
                            <td style="width: 100px;">RG</td>
                            <td style="width: 100px;">Órgão Exp.</td>
                        </tr>
                        <tr>
                            <td><?php echo $membro->getId();?></td>
                            <td><?php echo $membro->getMatricula();?></td>
                            <td colspan="4"><?php echo $membro->getNome();?></td>
                            <td><?php echo $membro->getCpf();?></td>
                            <td><?php echo $membro->getRg();?></td>
                            <td><?php echo $membro->getRgOrgaoEmissor();?></td>
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td>N&ordm; Ficha/Livro</td>
                            <td>Sexo</td>
                            <td>Dt. Nascimento / Idade</td>
                            <td colspan="2">Est. Civil</td>
                            <td>Dt. Casamento</td>
                            <td>Naturalidade</td>
                            <td>Estado Nasc.</td>
                            <td>Nacionalidade</td>
                        </tr>
                        <tr>
                            <td><?php echo $membro->getNumeroFicha();?></td>
                            <td>
                                <?php 
                                    $strSexo = "MASCULINO";

                                    if($membro->getSexo() == "F"){
                                        $strSexo = "FEMININO";
                                    }

                                    echo $strSexo;
                                ?>
                            </td>
                            <td><?php echo $membro->getDataNascimento()." - ".$membro->getIdade();?></td>
                            <td colspan="2">
                                <?php 
                                    if($membro->getEstadoCivil() != null){
                                        if($membro->getEstadoCivil()->getId() != ""){
                                            $arrStrFiltrosEstadoCivil = array();
                                            $arrStrFiltrosEstadoCivil["ECV_ID"] = $membro->getEstadoCivil()->getId();
                                            $arrObjsECV = FachadaCadastro::getInstance()->consultarEstadoCivil($arrStrFiltrosEstadoCivil);
                                            $arrObjsECV = $arrObjsECV["objects"];
                                            echo $arrObjsECV[0]->getDescricao();                                        
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($membro->getDataCasamento() != ""){
                                        echo $membro->getDataCasamento();
                                    }
                                ?>
                            </td>
                            <td><?php echo $membro->getNaturalidade();?></td>
                            <td><?php echo $membro->getUfNascimento();?></td>
                            <td><?php echo $membro->getNascionalidade();?></td>                        
                        </tr>

                        <tr class="cabecalhoFicha">
                            <td>Grupo Sanguíneo</td>
                            <td>É Doador?</td>
                            <td colspan="4">Escolaridade</td>
                            <td colspan="4">Formação</td>
                        </tr>
                        <tr>
                            <td><?php echo $membro->getGrupoSanguineo();?></td>
                            <td>
                                <?php
                                    $strDoador = "NÃO";

                                    if($membro->getDoador() != "S"){
                                        $strDoador = "SIM";
                                    }

                                    echo $strDoador;
                                ?>
                            </td>
                            <td colspan="4">
                                <?php                                 
                                    if($membro->getNivelEscolaridade() != null){
                                        if($membro->getNivelEscolaridade()->getId() != ""){                                            
                                            $arrStrFiltrosNivelEscolaridade = array();
                                            $arrStrFiltrosNivelEscolaridade["NES_ID"] = $membro->getNivelEscolaridade()->getId();                                            
                                            $arrObjsNIE = FachadaCadastro::getInstance()->consultarNivelEscolaridade($arrStrFiltrosNivelEscolaridade);
                                            
                                            $strNivelEscolariadeDescricao = "";
                                            
                                            if($arrObjsNIE != null){
                                                if(count($arrObjsNIE) > 0){
                                                    $arrObjsNIE = $arrObjsNIE["objects"];
                                                    
                                                    $strNivelEscolariadeDescricao = $arrObjsNIE[0]->getDescricao();
                                                }
                                            }                                       
                                        }
                                    }
                                ?>
                            </td>
                            <td colspan="4"><?php echo $membro->getFormacao();?></td>
                        </tr>

                        <tr class="cabecalhoFicha">
                            <td colspan="5">Nome do Pai</td>
                            <td colspan="5">Nome da Mãe</td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo $membro->getPaiNome();?></td>
                            <td colspan="5"><?php echo $membro->getMaeNome();?></td>                            
                        </tr>
                    </table>

                    <h1>Endereço</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td colspan="5">Endereço</td>                        
                            <td colspan="2">Complemento</td>
                            <td colspan="2">Bairro</td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo $membro->getEndereco()->getLogradouro().", ".$membro->getEndereco()->getNumero();?></td>                        
                            <td colspan="2"><?php echo $membro->getEndereco()->getComplemento();?></td>
                            <td colspan="2"><?php echo $membro->getEndereco()->getBairro();?></td>
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td colspan="5">Cidade</td>
                            <td>Estado</td>
                            <td colspan="2">Ponto de Referência</td>
                            <td>Cep</td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo $membro->getEndereco()->getCidade();?></td>                        
                            <td>
                                <?php 
                                    echo $membro->getEndereco()->getUf();
                                ?>
                            </td>
                            <td colspan="2"><?php echo $membro->getEndereco()->getPontoReferencia();?></td>                        
                            <td><?php echo $membro->getEndereco()->getCep();?></td>                        
                        </tr>
                    </table>
                    
                    <h1>Contato</h1>                    
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Telefone(s)</td>
                            <td>E-mail(s)</td>
                        </tr>

                        <tr>
                            <td>
                                <?php
                                    // telefones com operadoras
                                    $arrStrFiltrosTel = array();
                                    $arrStrFiltrosTel["PES_ID"] = $intPessoaID;
                                    $arrObjsTel = NegPessoaTelefone::getInstance()->consultar($arrStrFiltrosTel);

                                    if($arrObjsTel != null){
                                        if(count($arrObjsTel) > 0){                                    
                                            $arrObjsTel = $arrObjsTel["objects"];                                            
                                            for($intI=0; $intI<count($arrObjsTel); $intI++){ 
                                                echo $arrObjsTel[$intI]->getNumero()." (".$arrObjsTel[$intI]->getOperadora().")";
                                                
                                                if(trim($arrObjsTel[$intI]->getContato()) != ""){
                                                    echo " Contato: ".$arrObjsTel[$intI]->getContato();
                                                }
                                                
                                                echo "<br/>";
                                            }
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    // telefones com operadoras
                                    $arrStrFiltrosEma = array();
                                    $arrStrFiltrosEma["PES_ID"] = $intPessoaID;
                                    $arrObjsEma = NegPessoaEmail::getInstance()->consultar($arrStrFiltrosEma);

                                    if($arrObjsTel != null){
                                        if(count($arrObjsEma) > 0){                                    
                                            $arrObjsEma = $arrObjsEma["objects"];                                            
                                            for($intI=0; $intI<count($arrObjsEma); $intI++){ 
                                                echo $arrObjsEma[$intI]->getEmail()."<br/>";
                                            }
                                        }
                                    }
                                ?>
                            </td>
                        </tr>                        
                    </table>

                    <h1>Família</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Nome</td>
                            <td style="width: 200px;">Relacionamento</td>
                        </tr>

                        <?php
                            $arrStrFiltrosFam = array();
                            $arrStrFiltrosFam["PES_Primario_ID"] = $intPessoaID;
                            $arrObjsFam = FachadaCadastro::getInstance()->consultarFamiliaMembro($arrStrFiltrosFam);                            
                            if($arrObjsFam != null){
                                if(count($arrObjsFam) > 0){                                    
                                    $arrObjsFam = $arrObjsFam["objects"];

                                    for($intI=0; $intI<count($arrObjsFam); $intI++){ 
                        ?>
                        <tr>
                            <td><?php echo $arrObjsFam[$intI]->getPessoaSecundarioNome();?></td>
                            <td><?php echo $arrObjsFam[$intI]->getGrauParentesco();?></td>
                        </tr>
                        <?php
                                    }
                                }
                            }
                        ?>

                    </table>

                    <h1>Dados Profissionais</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td colspan="3">Nome da Empresa</td> 
                            <td>Telefone</td>
                            <td>Fax</td>
                            <td colspan="3">Área de Atuação</td>
                            <td>Profissão</td>
                        </tr>
                        <tr>
                            <td colspan="3"><?php echo $membro->getEmpresaNome();?></td>                        
                            <td><?php echo $membro->getEmpresaTelefoneComercial();?></td>
                            <td><?php echo $membro->getEmpresaTelefoneFax();?></td>
                            <td colspan="3">
                                <?php
                                    if($membro->getAreaDeAtuacao() != null){
                                        if($membro->getAreaDeAtuacao()->getId() != ""){
                                            $arrStrFiltrosAreaAtu = array();
                                            $arrStrFiltrosAreaAtu["AAT_ID"] = $membro->getAreaDeAtuacao()->getId();
                                            $arrObjsAAT = FachadaCadastro::getInstance()->consultarAreaAtuacao($arrStrFiltrosEstadoCivil);
                                            $arrObjsAAT = $arrObjsAAT["objects"];
                                            echo $arrObjsAAT[0]->getDescricao();                                        
                                        }
                                    }
                                ?>
                            </td>
                            <td><?php echo $membro->getProfissao();?></td>
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td colspan="4">Endereço</td>                        
                            <td>Complemento</td>
                            <td colspan="3">Bairro</td>                        
                            <td>Estado</td>
                        </tr>
                        <tr>
                            <td colspan="4"><?php echo $membro->getEnderecoEmpresa()->getLogradouro().", ".$membro->getEnderecoEmpresa()->getNumero();?></td>                        
                            <td>
                                <?php 
                                    echo $membro->getEnderecoEmpresa()->getComplemento();
                                ?>
                            </td>

                            <td colspan="3">
                                <?php 
                                    echo $membro->getEnderecoEmpresa()->getBairro();
                                ?>
                            </td>                                        
                            <td><?php echo $membro->getEnderecoEmpresa()->getUf();?></td>                        
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td colspan="3">Cep</td>                        
                            <td colspan="5">Ponto de Referência</td>
                            <td>Possui Emprego?</td>
                        </tr>
                        <tr>
                            <td colspan="3"><?php echo $membro->getEnderecoEmpresa()->getCep();?></td>                        
                            <td colspan="5">
                                <?php 
                                    echo $membro->getEnderecoEmpresa()->getPontoReferencia();
                                ?>
                            </td>  
                            <td>
                                <?php 
                                    $strPossuiEmprego = "NÃO";

                                    if($membro->getTemEmprego() == "S"){
                                        $strPossuiEmprego = "SIM";
                                    }

                                    echo $strPossuiEmprego;
                                ?>                            
                            </td>
                        </tr>
                    </table>

                    <h1>Dados Eclesiásticos</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Dado Eclesiástico</td>
                            <td>Data</td>
                            <td>Ano</td>
                            <td>Data Aceito</td>
                            <td>Igreja</td>
                            <td>Cidade</td>
                            <td>Uf</td>
                            <td>Pastor</td>
                            <td>Nº Ata</td>
                        </tr>
                        <?php
                            $arrStrFiltrosDEcle = array();
                            $arrStrFiltrosDEcle["PES_ID"] = $intPessoaID;
                            $arrObjsEcle = FachadaCadastro::getInstance()->consultarDadosEclesiasticos($arrStrFiltrosDEcle);

                            if($arrObjsEcle != null){
                                if(count($arrObjsEcle) > 0){                        
                                    
                                $arrObjsEcle = $arrObjsEcle["objects"];
                                    for($intI=0; $intI<count($arrObjsEcle); $intI++){
                                    $dadoEcleMembro = new DadosEclesiasticos();
                                    $dadoEcleMembro = $arrObjsEcle[$intI];    
                                
                        ?>
                        <tr>
                            <td><?php echo $dadoEcleMembro->getTipo()?></td>
                            <td><?php echo $dadoEcleMembro->getData();?></td>
                            <td>
                                <?php 
                                    if($dadoEcleMembro->getAno() > 0){
                                        echo $dadoEcleMembro->getAno();
                                    }else{
                                        echo " ";
                                    }
                                ?>
                            </td>
                            <td><?php echo $dadoEcleMembro->getDataAceito();?></td>
                            <td><?php echo $dadoEcleMembro->getIgrejaNome();?></td>
                            <td><?php echo $dadoEcleMembro->getIgrejaCidade();?></td>
                            <td><?php echo $dadoEcleMembro->getIgrejaUf();?></td>
                            <td><?php echo $dadoEcleMembro->getIgrejaPastor();?></td>
                            <td><?php echo $dadoEcleMembro->getNumeroAta();?></td>
                        </tr>
                        <?php
                                    }
                                }
                            }
                            
                        ?>                         
                        
                    </table>
                    <br>
                    <table class="dadosFicha">                        
                        <tr class="cabecalhoFicha">
                            <td >SEDE/CONGREGA&Ccedil;&Atilde;O</td>
                        </tr>
                        
                        <tr >
                            <td colspan="9">
                                <?php 
                                
                                if($membro->getCongregacao()->getId() != null){
                                    $arrConsultaCongre["UNI_ID"] = $membro->getCongregacao()->getId();                                    
                                    $arrObjCongre = NegCongregacao::getInstance()->consultar($arrConsultaCongre);
                                    $arrObjCongre = $arrObjCongre["objects"];
                                    $objCongregacao = new Congregacao();
                                    $objCongregacao = $arrObjCongre[0];
                                    echo $objCongregacao->getDescricao(); 
                                }else{
                                    echo 'SEDE';
                                }
                                
                                    
                                ?>
                            </td>
                        </tr>
                    </table>
                    
                    <h1>Histórico de Atividades</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Atividade</td>
                            <td>Desde</td>
                            <td>Até</td>
                        </tr>
                        <?php
                            $arrStrFiltrosAtiv = array();
                            $arrStrFiltrosAtiv["PES_ID"] = $intPessoaID;
                            $arrObjsAtivi = FachadaCadastro::getInstance()->consultarAtividadeMembro($arrStrFiltrosAtiv);

                            if($arrObjsAtivi != null){
                                if(count($arrObjsAtivi) > 0){                                    
                                    $arrObjsAtivi = $arrObjsAtivi["objects"];

                                    for($intI=0; $intI<count($arrObjsAtivi); $intI++){ 
                        ?>
                        <tr>
                            <td><?php echo $arrObjsAtivi[$intI]->getAtividade()->getDescricao();?></td>
                            <td><?php echo $arrObjsAtivi[$intI]->getDataDesde();?></td>
                            <td><?php echo $arrObjsAtivi[$intI]->getDataAte();?></td>
                        </tr>
                        <?php
                                    }
                                }
                            }
                        ?>

                    </table>
                    
                    <h1>Histórico de Ministérios</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Ministério</td>
                            <td>Desde</td>
                            <td>Até</td>
                        </tr>
                        <?php
                            $arrStrFiltrosMinisterio = array();
                            $arrStrFiltrosMinisterio["PES_ID"] = $intPessoaID;
                            $arrObjsMini = FachadaCadastro::getInstance()->consultarMembroMinisterio($arrStrFiltrosMinisterio);

                            if($arrObjsMini != null){
                                if(count($arrObjsMini) > 0){                                    
                                    $arrObjsMini = $arrObjsMini["objects"];

                                    for($intI=0; $intI<count($arrObjsMini); $intI++){ 
                                        $objMinisterio = new MembroMinisterio();
                                        $objMinisterio = $arrObjsMini[$intI];
                        ?>
                        <tr>
                            <td><?php echo $objMinisterio->getMinisterio()->getDescricao();?></td>
                            <td><?php echo $objMinisterio->getDataDesde();?></td>
                            <td><?php echo $objMinisterio->getDataAte();?></td>
                        </tr>
                        <?php
                                    }
                                }
                            }
                        ?>

                    </table>

                    <h1>Processo de Desligamento</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Data</td>
                            <td>Descrição</td>
                        </tr>
                        <?php
                            $arrStrFiltrosDesli = array();
                            $arrStrFiltrosDesli["PES_ID"] = $intPessoaID;
                            $arrObjsDesli = FachadaCadastro::getInstance()->consultarMotivoDesligamentoMembro($arrStrFiltrosAtiv);

                            if($arrObjsDesli != null){
                                if(count($arrObjsDesli) > 0){                                    
                                    $arrObjsDesli = $arrObjsDesli["objects"];

                                    for($intI=0; $intI<count($arrObjsDesli); $intI++){ 
                        ?>
                        <tr>
                            <td><?php echo $arrObjsDesli[$intI]->getData();?></td>
                            <td><?php echo $arrObjsDesli[$intI]->getDescricao();?></td>
                        </tr>
                        <?php
                                    }
                                }
                            }                            
                        ?>
                    </table>
                    
                    <?php                    
                    if($membro->getDataFalecimento() != null){
                            ?>
                              <br>
                              <table class="dadosFicha">
                                    <tr class="cabecalhoFicha">
                                        <td>Membro Falecido em</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $membro->getDataFalecimento();?>
                                        </td>
                                    </tr>
                                </table>
                            <?php                                
                            }
                    
                    ?>
                    

                    <h1>Anotações</h1>
                    <table class="dadosFicha">
                        <tr>
                            <td><?php echo $membro->getObservacao();?></td>                        
                        </tr>
                    </table>

                    <?php
                    }
                    ?>

                    <?php
                        include("../../../sistema/gerencial/inc/rodape-impressao.inc.php");
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
