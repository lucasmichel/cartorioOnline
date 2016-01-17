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
        <title>Ficha do Funcionário</title>
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
                        <h1>Ficha do Funcionário</h1>
                    </div>
                </div>
                <hr/>
                <div id="ficha">
                    <?php
                    if(isset($_GET["PES_ID"])){
                        $intPessoaID = SegurancaHelper::getInstance()->removerSQLInjection($_GET["PES_ID"]);
                        $arrStrFiltros = array();
                        $arrStrFiltros["PES_ID"] = $intPessoaID;
                        $arrObjs = FachadaCadastro::getInstance()->consultarFuncionario($arrStrFiltros);
                        
                        $arrObjs = $arrObjs["objects"];
                    ?>                
                    <h1>Dados Pessoais</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td rowspan="4" valign="top">
                                <?php 
                                    $strImg = $arrObjs[0]->getFoto();

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
                            <td><?php echo $arrObjs[0]->getId();?></td>
                            <td><?php echo $arrObjs[0]->getMatricula();?></td>
                            <td colspan="4"><?php echo $arrObjs[0]->getNome();?></td>
                            <td><?php echo $arrObjs[0]->getCpf();?></td>
                            <td><?php echo $arrObjs[0]->getRg();?></td>
                            <td><?php echo $arrObjs[0]->getRgOrgaoEmissor();?></td>
                        </tr>
                        <tr class="cabecalhoFicha">                            
                            <td>Sexo</td>
                            <td colspan="2">Dt. Nascimento</td>
                            <td colspan="3">Est. Civil</td>                            
                            <td colspan="2">Naturalidade</td>
                            <td>Nacionalidade</td>
                        </tr>
                        <tr>                            
                            <td>
                                <?php 
                                    $strSexo = "MASCULINO";

                                    if($arrObjs[0]->getSexo() == "F"){
                                        $strSexo = "FEMININO";
                                    }

                                    echo $strSexo;
                                ?>
                            </td>
                            <td colspan="2"><?php echo $arrObjs[0]->getDataNascimento();?></td>
                            <td colspan="3">
                                <?php 
                                    if($arrObjs[0]->getEstadoCivil() != null){
                                        if($arrObjs[0]->getEstadoCivil()->getId() != ""){
                                            $arrStrFiltrosEstadoCivil = array();
                                            $arrStrFiltrosEstadoCivil["ECV_ID"] = $arrObjs[0]->getEstadoCivil()->getId();
                                            $arrObjsECV = FachadaCadastro::getInstance()->consultarEstadoCivil($arrStrFiltrosEstadoCivil);
                                            $arrObjsECV = $arrObjsECV["objects"];
                                            echo $arrObjsECV[0]->getDescricao();                                        
                                        }
                                    }
                                ?>
                            </td>                            
                            <td colspan="2"><?php echo $arrObjs[0]->getNaturalidade();?></td>                        
                            <td><?php echo $arrObjs[0]->getNascionalidade();?></td>                        
                        </tr>

                        <tr class="cabecalhoFicha">
                            <td>Grupo Sanguíneo</td>
                            <td>É Doador?</td>
                            <td colspan="4">Escolaridade</td>
                            <td colspan="4">Formação</td>
                        </tr>
                        <tr>
                            <td><?php echo $arrObjs[0]->getGrupoSanguineo();?></td>
                            <td>
                                <?php
                                    $strDoador = "NÃO";

                                    if($arrObjs[0]->getDoador() != "S"){
                                        $strDoador = "SIM";
                                    }

                                    echo $strDoador;
                                ?>
                            </td>
                            <td colspan="4">
                                <?php 
                                    if($arrObjs[0]->getNivelEscolaridade() != null){
                                        if($arrObjs[0]->getNivelEscolaridade()->getId() != ""){
                                            $arrStrFiltrosNivelEscolaridade = array();
                                            $arrStrFiltrosNivelEscolaridade["NES_ID"] = $arrObjs[0]->getNivelEscolaridade()->getId();
                                            $arrObjsNIE = FachadaCadastro::getInstance()->consultarNivelEscolaridade($arrStrFiltrosNivelEscolaridade);
                                            $arrObjsNIE = $arrObjsNIE["objects"];
                                            echo $arrObjsNIE[0]->getDescricao();                                        
                                        }
                                    }
                                ?>
                            </td>
                            <td colspan="4"><?php echo $arrObjs[0]->getFormacao();?></td>
                        </tr>

                        <tr class="cabecalhoFicha">
                            <td colspan="5">Nome da Mãe</td>
                            <td colspan="5">Nome do Pai</td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo $arrObjs[0]->getMaeNome();?></td>
                            <td colspan="5"><?php echo $arrObjs[0]->getPaiNome();?></td>
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
                            <td colspan="5"><?php echo $arrObjs[0]->getEndereco()->getLogradouro().", ".$arrObjs[0]->getEndereco()->getNumero();?></td>                        
                            <td colspan="2"><?php echo $arrObjs[0]->getEndereco()->getComplemento();?></td>
                            <td colspan="2"><?php echo $arrObjs[0]->getEndereco()->getBairro();?></td>
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td colspan="5">Cidade</td>
                            <td>Estado</td>
                            <td colspan="2">Ponto de Referência</td>
                            <td>Cep</td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo $arrObjs[0]->getEndereco()->getCidade();?></td>                        
                            <td>
                                <?php 
                                    echo $arrObjs[0]->getEndereco()->getUf();
                                ?>
                            </td>
                            <td colspan="2"><?php echo $arrObjs[0]->getEndereco()->getPontoReferencia();?></td>                        
                            <td><?php echo $arrObjs[0]->getEndereco()->getCep();?></td>                        
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
                                                echo $arrObjsTel[$intI]->getNumero();
                                                
                                                if(trim($arrObjsTel[$intI]->getContato()) != ""){
                                                    echo $arrObjsTel[$intI]->getContato();
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
                    
                    <h1>Dados Profissionais</h1>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Função</td> 
                            <td>Cart. de Trabalho</td>
                            <td>Cart. de Habilitação</td>
                            <td>Dt. Admissão</td>
                            <td>Dt. Saída</td>
                            <td>Salário</td>
                            <td>C. Horária</td>
                            <td>Hor. de Entrada</td>
                            <td>Hor. de Saída</td>
                        </tr>
                        <tr>
                            <td><?php echo $arrObjs[0]->getFuncao();?></td>                        
                            <td><?php echo $arrObjs[0]->getCarteiraTrabalhoNumero();?></td>
                            <td><?php echo $arrObjs[0]->getCnhNumero();?></td>
                            <td><?php echo $arrObjs[0]->getDataAdmissao();?></td>
                            <td><?php echo $arrObjs[0]->getDataSaida();?></td>
                            <td><?php echo $arrObjs[0]->getSalario();?></td>
                            <td><?php echo $arrObjs[0]->getCargaHoraria();?></td>
                            <td><?php echo $arrObjs[0]->getHorarioEntrada();?></td>
                            <td><?php echo $arrObjs[0]->getHorarioSaida();?></td>
                        </tr>
                        
                    </table>

                    <h1>Anotações</h1>
                    <table class="dadosFicha">
                        <tr>
                            <td><?php echo $arrObjs[0]->getObservacao();?></td>                        
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