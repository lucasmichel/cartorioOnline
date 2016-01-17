<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");      
    
    // diretório do m�dulo
    $strDir = "../../administrativo/cadastro";
    header('Content-Type: text/html; charset=utf-8', true);  
    
    if(isset($_SESSION["DADOS_MEMBRO"])){
        unset($_SESSION["DADOS_MEMBRO"]);
    }    
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>           
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmMembro.js"></script>
    <style type="text/css">
        .ui-datepicker {z-index:10100 !important;}
    </style>
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Membros Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <form id="frmPesquisa" onSubmit="return false;">                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="selPesquisarPor">Pesquisar por</label>
                        <select class="campoSelect" id="selPesquisarPor">                            
                            <option value="NOME">NOME</option>
                            <option value="FICHA">N&ordm; da Ficha/Livro</option>
                            <option value="MATRICULA">MATRÍCULA</option>                        
                        </select>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaCampo"></label>
                        <input type="text" id="txtPesquisaCampo" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 200px;">
                    </fieldset>
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPesquisaUnidade">Unidade(Sede/Congrega&ccedil;&atilde;o)</label>                                
                            <select data-placeholder="FILTRO POR UNIDADE." style="width:250px;" class="chosen-select-deselect" id="selPesquisaUnidade">
                                <option value="TODOS"></option>
                                <option value="">SEDE</option>
                                <?php
                                    $arrStrFiltros["UNI_Status"] = "A";
                                    $arrObjFaixa  = FachadaCadastro::getInstance()->consultarCongregacao($arrStrFiltros);

                                    if($arrObjFaixa != null){
                                        $arrObj = $arrObjFaixa["objects"];

                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaNivelEscolaridade">Nível de escolaridade</label>                                
                        <select data-placeholder="FILTRO POR N&Iacute;VEL DE ESCOLARIDADE." style="width:200px;" class="chosen-select-deselect"  id="selPesquisaNivelEscolaridade"  name="NES_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["NES_Status"] = "A";                                    
                                    $arrObjs = FachadaCadastro::getInstance()->consultarNivelEscolaridade($arrStrFiltros);                                    
                                    
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna" style="height:60px; margin-top: 5px;" >
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaStatus">Tipo</label>                                
                            <select data-placeholder="FILTRO POR TIPO." style="width:150px;" class="chosen-select-deselect" id="selPesquisaTipo" name="MEM_Tipo">
                                <option value=""></option>    
                                <option value="CONGREGADO">CONGREGADO</option>
                                <option value="INATIVO">INATIVO</option>
                                <option value="MEMBRO">MEMBRO</option>
                                <option value="VISITANTE">VISITANTE</option>
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna" style="height:60px; margin-top: 5px;" >
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaStatus">Status</label>                                
                        <select data-placeholder="FILTRO POR STATUS." style="width:150px;" class="chosen-select-deselect" id="selPesquisaStatus"  name="MES_ID">
                            <option value=""></option>    
                            <?php
                                    $arrStrFiltros["MES_Status"] = "A";
                                    $arrObjs  = FachadaCadastro::getInstance()->consultarStatusMembro($arrStrFiltros);                                                
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    
                    
                    <fieldset class="coluna">                                    
                        <label for="selPesquisaSexo">Sexo</label>                                    
                        <select style="width:100px;" class="campoSelect" id="selPesquisaSexo">    
                            <option value=""></option>
                            <option value="F">FEMININO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaEstadoCivil">Estado civil</label>                                
                            <select data-placeholder="FILTRO POR ESTADO CIVIL." style="width:200px;" class="chosen-select-deselect" id="selPesquisaEstadoCivil"  name="ECV_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros = array();
                                    $arrStrFiltros["ECV_Status"] = "A";
                                    $arrObjs  = FachadaCadastro::getInstance()->consultarEstadoCivil($arrStrFiltros);
                                    
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>                    
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Ficha em branco" onclick="printFichaEmBranco();" class="botao"/>                    
                    </fieldset>
                </fieldset>
            </form>
            <div id="grid" style="margin-top: 20px;"></div><!-- grid -->            
        </div><!-- tabs-1 -->
        <div id="tabs-2">            
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                <div id="dialog-lista-familia" title="Família do Membro">
                    <div id="div-lista-familia" style="width: 100%; height: 200px; overflow: auto;"></div>
                </div>
                <div id="dialog-contato" title="Contatos do Membro">
                    <div id="div-lista-contato" style="width: 100%; height: 250px; overflow: auto;"></div>
                </div>
                
                <div id="dialog-add-status" title="Adicionar Status">
                    <form id="frmStatus" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/StatusMembroControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="MES_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Status*</label>
                            <input type="text" id="txtADDStatus" name="MES_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-add-estadoCivil" title="Adicionar Estado Civil">
                    <form id="frmEstadoCivil" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/EstadoCivilControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="ECV_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Estado civil*</label>
                            <input type="text" id="txtADDEstadoCivil" name="ECV_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                
                <div id="dialog-add-areaAtuacao" title="Adicionar área de atuação profissional">
                    <form id="frmAreaAtuacao" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/AreaAtuacaoControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="AAT_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Área de atuação*</label>
                            <input type="text" id="txtADDAreaAtuacao" name="AAT_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-add-faixaSalarial" title="Adicionar faixa salarial">
                    <form id="frmFaixaSalarial" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/RendaSalarioControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="ARS_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Faixa salarial*</label>
                            <input type="text" id="txtADDFaixaSalarial" name="ARS_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-add-atividade" title="Adicionar atividade">
                    <form id="frmAtividade" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/AtividadeControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="ATV_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Atividade*</label>
                            <input type="text" id="txtADDAtividade" name="ATV_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-add-nivelEscolaridade" title="Adicionar nível de escolaridade">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/NivelEscolaridadeControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="NES_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Nível de escolaridade*</label>
                            <input type="text" id="txtADDNivelEscolaridade" name="NES_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-add-congregacao" title="Adicionar congregação">
                    <form id="frmUnidade" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/CongregacaoControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="UNI_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label>Congregação*</label>
                            <input type="text" id="txtADDCongregacao" name="UNI_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-add-ministerio" title="Adicionar ministério">
                    <form id="frmMinisterio" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/MinisterioControlador.php" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddID" name="MIN_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        
                        
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <div class="side-by-side clearfix">
                                    <label for="selAreaMinisterial">Área Ministerial</label>                                
                                    <select data-placeholder="SELECIONE A ÁREA MINSITERIAL" style="width:280px;" class="chosen-select-deselect" id="selAreaMinisterial" name="AMI_ID" onchange="getMinisterios();">                                
                                        <option value=""></option>
                                        <?php
                                            $arrStrFiltros["AMI_Status"] = "A";
                                            $arrObjFaixa  = FachadaCadastro::getInstance()->consultarAreaMinisterial($arrStrFiltros);
                                            if($arrObjFaixa != null){
                                                $arrObj = $arrObjFaixa["objects"];
                                                for($intI=0; $intI<count($arrObj); $intI++){
                                                   echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </fieldset>
                        
                        
                            <fieldset class="coluna">
                                <label>Ministério*</label>
                                <input type="text" id="txtADDMinisterio" name="MIN_Descricao" class="campoTextoPadrao" style="width: 260px;"/>
                            </fieldset>
                        </fieldset>
                        
                        
                    </form>
                </div>
                
                
                <div id="dialog-editar-fone" title="Editar Telefone">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarFone"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDFone" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="coluna">
                            <label for="txtFoneEdicao">Telefone</label>
                            <input type="text" id="txtFoneEdicao" name="TEL_Telefone" class="campoTextoPadrao" style="width: 95px;" placeholder="(__) ____.____" />
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="selOperadoraEdicao">Operadora</label>
                            <?php echo OperadorasTelefoniaSelectComponente::getInstance()->gerar("selOperadoraEdicao", "TEL_Operadora")?>
                        </fieldset>                                
                        <fieldset class="coluna">
                            <label for="txtResponsavelEdicao">Nome do Contato</label>
                            <input type="text" id="txtResponsavelEdicao" name="TEL_Responsavel" class="campoTextoPadrao" style="width: 160px;" placeholder="EX.: JOS&Eacute; DA SILVA" />
                        </fieldset>
                    </form>
                </div>
                
                
                <div id="dialog-editar-email" title="Editar E-mail">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarEmail"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDEmail" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label for="txtEmailEdicao">E-mail</label>
                            <input type="text" id="txtEmailEdicao" name="EMA_Email" class="campoTextoPadrao" style="width: 250px;" placeholder="EX.: JOAODASILVA@IGREJACONECTADA.COM" />
                        </fieldset>                        
                    </form>
                </div>
                
                
                
                <div id="dialog-editar-dadoEclesiastico" title="Editar dado eclesiástico">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarDadoEclesiastico"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDDadoEclesiastico" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        
                        
                        <fieldset class="linha">                        
                            <fieldset class="coluna">
                                <label for="selTipoDadoEclesiasticoEditar">O membro foi recebido através de</label>                                
                                <select style="width:343px;" id="selTipoDadoEclesiasticoEditar"  name="DAM_Tipo" class="campoSelect" onchange="exibirDadoEclesiasticoEdicao();" >                                
                                    <option value="ACLAMAÇÃO">ACLAMAÇÃO</option>
                                    <option value="BATISMO">BATISMO</option>
                                    <option value="RECONCILIAÇÃO">RECONCILIAÇÃO</option>
                                    <option value="TRANSFERÊNCIA">TRANSFERÊNCIA</option>                                
                                </select>                            
                            </fieldset>
                        </fieldset>


                        <fieldset class="linha fildDadoEcleEdicao" id="fildAclamacaoEdicao">                        
                            <label for="txtDataAclamacaoEdicao">Data Aclamação</label>
                            <input type="text" id="txtDataAclamacaoEdicao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                        </fieldset>


                        <fieldset class="linha fildDadoEcleEdicao" id="fildBatismoEdicao">
                            <fieldset class="linha">
                                <fieldset class="coluna">
                                    <label for="txtBatismoDataEdicao">Data batismo</label>
                                    <input type="text" id="txtBatismoDataEdicao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtBatismoDataAceitoEdicao">Data aceito</label>
                                    <input type="text" id="txtBatismoDataAceitoEdicao" name="DAM_DataAceito" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                                </fieldset>

                                <fieldset class="coluna">
                                    <label for="txtBatismoAnoEdicao">Ano</label>
                                    <input type="text" id="txtBatismoAnoEdicao" name="DAM_IgrejaNome" class="campoTextoPadrao" placeholder="EX.: 1999" style="width: 50px;" maxlength=4/>                        
                                </fieldset>

                                <fieldset class="coluna">
                                    <label for="txtBatismoIgrejaNomeEdicao">Igreja</label>
                                    <input type="text" id="txtBatismoIgrejaNomeEdicao" name="DAM_IgrejaNome" class="campoTextoPadrao" placeholder="NOME DA IGREJA" style="width: 130px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtBatismoIgrejaPastorEdicao">Pastor</label>
                                    <input type="text" id="txtBatismoIgrejaPastorEdicao" name="DAM_IgrejaPastor" class="campoTextoPadrao" placeholder="NOME DO PASTOR" style="width: 130px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtBatismoIgrejaCidadeEdicao">Cidade</label>
                                    <input type="text" id="txtBatismoIgrejaCidadeEdicao" name="DAM_IgrejaCidade" class="campoTextoPadrao" placeholder="EX.: RECIFE" style="width: 130px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="selBatismoIgrejaEstadoEdicao">Estado</label>
                                    <?php
                                        echo UFSelectComponente::getInstance()->gerarSigla("selBatismoIgrejaEstadoEdicao", "DAM_IgrejaUf", true);
                                    ?>
                                </fieldset>
                            </fieldset>
                        </fieldset>

                        <fieldset class="linha fildDadoEcleEdicao" id="fildReconciliacaoEdicao">                        
                            <label for="txtDataReconciliacaoEdicao">Data Reconciliação</label>
                            <input type="text" id="txtDataReconciliacaoEdicao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>


                        <fieldset class="linha fildDadoEcleEdicao" id="fildTransferenciaEdicao">
                            <fieldset class="linha">
                                <fieldset class="coluna">
                                    <label for="txtTransferenciaDataSecaoEdicao">Data sessão</label>
                                    <input type="text" id="txtTransferenciaDataSecaoEdicao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtTransferenciaDataAceitoEdicao">Data aceito</label>
                                    <input type="text" id="txtTransferenciaDataAceitoEdicao" name="DAM_DataAceito" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtTransferenciaNumeroAtaEdicao">Nº da Ata</label>
                                    <input type="text" id="txtTransferenciaNumeroAtaEdicao" name="DAM_DataAceito" class="campoTextoPadrao" style="width: 100px;"/>
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtTransferenciaIgrejaNomeEdicao">Igreja</label>
                                    <input type="text" id="txtTransferenciaIgrejaNomeEdicao" name="DAM_IgrejaNome" class="campoTextoPadrao" placeholder="NOME DA IGREJA" style="width: 130px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtTransferenciaIgrejaPastorEdicao">Pastor</label>
                                    <input type="text" id="txtTransferenciaIgrejaPastorEdicao" name="DAM_IgrejaPastor" class="campoTextoPadrao" placeholder="NOME DO PASTOR" style="width: 130px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="txtTransferenciaIgrejaCidadeEdicao">Cidade</label>
                                    <input type="text" id="txtTransferenciaIgrejaCidadeEdicao" name="DAM_IgrejaNome" class="campoTextoPadrao" placeholder="EX.: RECIFE" style="width: 130px;"/>                        
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="selTranseferenciaIgrejaEstadoEdicao">Estado</label>
                                    <?php
                                        echo UFSelectComponente::getInstance()->gerarSigla("selTranseferenciaIgrejaEstadoEdicao", "DAM_IgrejaUf", true);
                                    ?>
                                </fieldset>
                            </fieldset>             
                        </fieldset>                        
                    </form>
                </div>
                
                
                <div id="dialog-editar-atividade" title="Editar Atividade">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarAtividade"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDAtividade" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        
                        <fieldset class="coluna" >
                            <div class="side-by-side clearfix">
                            <label for="selAtividadeEdicao">Atividades Exercidas</label>
                                <select data-placeholder="SELECIONE A ATIVIDADE." style="width:300px;" class="chosen-select-deselect" id="selAtividadeEdicao"  name="ATV_ID">
                                </select>
                            </div>
                        </fieldset>                            
                        <fieldset class="coluna" >
                            <label for="txtAtividadeDesdeEdicao">DT. Início</label>
                            <input type="text" id="txtAtividadeDesdeEdicao" name="ATM_Desde" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>
                        <fieldset class="coluna" >
                            <label for="txtAtividadeAteEdicao">DT. Término</label>
                            <input type="text" id="txtAtividadeAteEdicao" name="ATM_Ate" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>                            
                        <fieldset class="coluna" >
                            <input type="checkbox" id="ckbTarefaAualEdicao" onclick="gerenciarAtividadeAtualEdicao();"/>Atividade atual?
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-editar-ministerio" title="Editar Ministério">
                    <form id="frmMinisterio" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarMinisterio"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDMinisterio" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        
                        
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selAreaMinisterioEdicao">Área Ministerial</label>                                
                                <select data-placeholder="ÁREA MINISTERIAL" style="width:250px;" class="chosen-select-deselect" id="selAreaMinisterioEdicao" name="AMI_ID" onchange="getMinisterioEdicao()">                                
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros["AMI_Status"] = "A";
                                        $arrObjFaixa  = FachadaCadastro::getInstance()->consultarAreaMinisterial($arrStrFiltros);
                                        if($arrObjFaixa != null){
                                            $arrObj = $arrObjFaixa["objects"];
                                            for($intI=0; $intI<count($arrObj); $intI++){
                                               echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </fieldset>                        
                        <fieldset class="coluna" >
                            <div class="side-by-side clearfix">
                            <label for="selMinisterioEdicao">Ministério</label>
                                <select data-placeholder="SELECIONE O MINISTÉRIO." style="width:300px;" class="chosen-select-deselect" id="selMinisterioEdicao"  name="MIN_ID">
                                </select>
                            </div>
                        </fieldset>
                        
                        
                        <fieldset class="coluna" >
                            <label for="txtMinisterioDesdeEdicao">DT. Início</label>
                            <input type="text" id="txtMinisterioDesdeEdicao" name="MMI_Desde" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>
                        <fieldset class="coluna" >
                            <label for="txtMinisterioAteEdicao">DT. Término</label>
                            <input type="text" id="txtMinisterioAteEdicao" name="MMI_Ate" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>                            
                        <fieldset class="coluna" >
                            <input type="checkbox" id="ckbMinisterioAtualEdicao" onclick="gerenciarMinisterioAtualEdicao();"/>Ministério atual?
                        </fieldset>
                    </form>
                </div>
                
            </div><!-- dialogs -->             
            
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/MembroControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="PES_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                <input type="hidden" id="hddStatus" name="PES_Status" value="A"/> <!-- o que indica se o membro está ativo ou inativo é o Status do Membro -->
                <input type="hidden" id="hddFotoMembro" name="PES_ArquivoFoto"/><!-- responsável por guardar o campos que receberá a foto -->
                <input type="hidden" id="hddMatricula" name="PES_Matricula"/><!-- responsável por guardar o campos que receberá a foto -->
            
                <div id="tabs-dados">
                    <ul>
                        <li><a href="#tabs-dados-membro">Dados Pessoais</a></li>     
                        <li><a href="#tabs-familia-membro">Fam&iacute;lia</a></li>
                        <li><a href="#tabs-endereco-membro">Endereço</a></li>
                        <li><a href="#tabs-dados-empresa-membro">Dados Profissionais</a></li> 
                        <li><a href="#tabs-dados-eclesiastico-membro">Dados Eclesi&aacute;sticos</a></li> 
                        <li><a href="#tabs-dados-atividades-membro">Atividades Exercidas</a></li>
                        <li><a href="#tabs-dados-ministerios-membro">Ministérios</a></li>
                        <li><a href="#tabs-dados-processo-desligamento-membro">Proc. Desligamento</a></li>
                        <li><a href="#tabs-dados-outros">Outros</a></li>
                    </ul>            
                    <div id="tabs-dados-membro">  
                        <!-- Foto -->
                        <fieldset class="coluna" style="float: right; width: 338px; height: 300px; margin-top: 40px; margin-right: 8px;">
                            <div id="div-foto" style="width: 330px; height: 300px; margin: auto;">
                                <img src='../../../modulos/sistema/home/img/sem-foto.png' id="imgFotoSalvar" width='330px' height='300px'/>
                            </div>
                            <div style="width: 170px; height: 163px; margin: auto;">
                                <input type="button" value="Adicionar Foto" onclick="tirarFoto();" class="botao" style="width: 170px;"/>
                            </div>
                        </fieldset> 
                        <fieldset class="coluna">
                            <fieldset style="width: 630px; border: 0px;" >
                                <fieldset class="linha">                    
                                    <fieldset class="coluna">
                                        <label for="txtNome">Nome*</label>
                                        <input type="text" id="txtNome" name="PES_Nome" class="campoTextoPadrao" placeholder="EX.: JOÃO DA SILVA" style="width: 301px;"/>
                                    </fieldset>
                                    <fieldset class="coluna" style="height:60px; margin-top: 5px;" >
                                        <div class="side-by-side clearfix">
                                            <label for="selTipo">Tipo*</label>                                
                                            <select data-placeholder="SELECIONE O TIPO." style="width:200px;" class="chosen-select-deselect" id="selTipo"  name="MEM_Tipo" onchange="gerenciarTipo();">
                                                <option value="CONGREGADO">CONGREGADO</option>
                                                <option value="INATIVO">INATIVO</option>
                                                <option value="MEMBRO" selected>MEMBRO</option>
                                                <option value="VISITANTE">VISITANTE</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </fieldset> 
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtCPF">CPF</label>
                                        <input type="text" id="txtCPF" name="PES_CPF" class="campoTextoPadrao" placeholder="___.___.___-__" style="width: 110px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtRG">RG</label>
                                        <input type="text" id="txtRG" name="PES_RG" class="campoTextoPadrao" placeholder="" style="width: 70px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtRGOrgaoEmissor">Órgão Emissor</label>
                                        <input type="text" id="txtRGOrgaoEmissor" name="PES_RGOrgaoEmissao" class="campoTextoPadrao" placeholder="" style="width: 75px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtDataNascimento">Data Nasc.*</label>
                                        <input type="text" id="txtDataNascimento" name="PES_DataNascimento" class="campoData" placeholder="__/__/____" style="width: 75px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">                                    
                                        <label for="selSexo">Sexo*</label>                                    
                                        <select style="width:100px;" class="campoSelect" id="selSexo"  name="PES_Sexo">    
                                            <option value=""></option>
                                            <option value="F">FEMININO</option>
                                            <option value="M">MASCULINO</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtNumeroFicha">N&ordm; Ficha/Livro</label>
                                        <input type="text" id="txtNumeroFicha" name="MEM_NumeroFicha" class="campoTextoPadrao" placeholder="" style="width: 65px;"/>
                                    </fieldset>
                                </fieldset>
                                <fieldset class="linha" style="height:60px;">
                                    <fieldset class="coluna" style="height:60px; margin-top: 5px;" >
                                        <div class="side-by-side clearfix">
                                            <label for="selEstadoCivil">Estado civil <a href="javascript: void(0);" onclick="openADDEstadoCivil();" title="Adicionar estado civil." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                                            <select data-placeholder="SELECIONE O ESTADO CIVIL." style="width:223px;" onchange="gerenciarEstadoCivil();" class="chosen-select-deselect" id="selEstadoCivil"  name="ECV_ID">                                                
                                            </select>
                                        </div>
                                    </fieldset>
                                    <fieldset class="coluna" id="fieldsetDataCasamento">
                                        <label>Data Casamento</label>
                                        <input type="text" name="PES_DataCasamento" class="campoData" style="width: 75px;" id="txtDataCasamento" placeholder="__/__/____"/>
                                    </fieldset>
                                    <fieldset class="coluna">                                    
                                        <label for="selTipoSanguineo">Grupo Sangu&iacute;neo</label>
                                        <select style="width:97px;" class="campoSelect" id="selTipoSanguineo"  name="PES_GrupoSanguineo">    
                                            <option value=""></option>
                                            <option value="O-">O-</option>
                                            <option value="O+">O+</option>
                                            <option value="A-">A-</option>
                                            <option value="A+">A+</option>
                                            <option value="B-">B-</option>
                                            <option value="B+">B+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="AB+">AB+</option>
                                        </select>
                                    </fieldset>                                
                                    <fieldset class="coluna" >
                                        <input type="checkbox" id="ckbDoador" value="S" name="PES_Doador" />Doador de sangue?
                                    </fieldset>                                
                                </fieldset>
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtNaturalidade">Naturalidade</label>
                                        <input type="text" id="txtNaturalidade" name="PES_Naturalidade" class="campoTextoPadrao" placeholder="EX.: RECIFE" style="width: 303px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label>Estado Nasc.</label>
                                        <?php
                                            echo UFSelectComponente::getInstance()->gerarSigla("selUfNascimento", "PES_UfNascimento", true, "width: 80px;");
                                        ?>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtNascionalidade">Nacionalidade</label>
                                        <input type="text" id="txtNascionalidade" name="PES_Nacionalidade" class="campoTextoPadrao" placeholder="EX.: BRASILEIRA" value="BRASILEIRA" style="width: 185px;"/>
                                    </fieldset>
                                </fieldset>
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <div class="side-by-side clearfix">
                                        <label for="selNivelEscolaridade">Nível de escolaridade <a href="javascript: void(0);" onclick="openADDEscolaridade();" title="Adicionar escolaridade." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                        <select data-placeholder="SELECIONE O N&Iacute;VEL DE ESCOLARIDADE." style="width:323px;" class="chosen-select-deselect" id="selNivelEscolaridade"  name="NES_ID">                                                
                                        </select>
                                        </div>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtFormacao">Formação Acadêmica</label>
                                        <input type="text" id="txtFormacao" name="PES_Formacao" class="campoTextoPadrao" placeholder="EX.: AN&Aacute;LISE DE SISTEMAS" style="width: 268px;" />                                    
                                    </fieldset>                                
                                </fieldset>
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtPai">Nome do pai</label>
                                        <input type="text" id="txtPai" name="PES_PaiNome" class="campoTextoPadrao" placeholder="EX.: JO&Atilde;O DA SILVA" style="width: 303px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtMae">Nome da m&atilde;e</label>
                                        <input type="text" id="txtMae" name="PES_MaeNome" class="campoTextoPadrao" placeholder="EX.: MARIA DA SILVA" style="width: 268px;"/>
                                    </fieldset>
                                </fieldset>                            
                            </fieldset>
                        </fieldset>
                    <fieldset class="linha" >
                        <fieldset>
                        <legend>Contatos</legend>
                            <fieldset class="coluna" style="float: left; width: 49%; height: 100%">
                                <fieldset class="coluna">
                                    <label for="txtFone">Telefone</label>
                                    <input type="text" id="txtFone" name="TEL_Telefone" class="campoTextoPadrao" style="width: 95px;" placeholder="(__) ____.____" />
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="selOperadora">Operadora</label>
                                    <?php echo OperadorasTelefoniaSelectComponente::getInstance()->gerar("selOperadora", "TEL_Operadora")?>
                                </fieldset>                                
                                <fieldset class="coluna">
                                    <label for="txtResponsavel">Nome do Contato</label>
                                    <input type="text" id="txtResponsavel" name="TEL_Responsavel" class="campoTextoPadrao" style="width: 160px;" placeholder="EX.: JOS&Eacute; DA SILVA" />
                                </fieldset>
                                <fieldset class="coluna">
                                    <input type="button" value="Adicionar" onclick="adicionarFone();" class="botao" id="btnAddFone" title="Adicionar telefone"/>
                                </fieldset>
                                <fieldset class="linha" style="margin-top: 10px;">                                                            
                                    <fieldset class="linha" style="height: 150px;">
                                        <div id="div-fones" style="width: 100%; height: 100%; overflow: auto;">Nenhum telefone adicionado.</div>
                                    </fieldset>
                                </fieldset>
                            </fieldset>
                            <fieldset class="coluna" style="float: left; width: 2%; height: 100% ">
                                <hr size="238" width="1" align="left" style="color: #f4f4f4; background-color: #f4f4f4; ">                            
                            </fieldset>
                            <fieldset class="coluna" style="float: left; width: 49%; height: 100%">
                                <fieldset class="coluna">
                                    <label for="txtEmail">E-mail</label>
                                    <input type="text" id="txtEmail" name="EMA_Email" class="campoTextoPadrao" style="width: 393px;" placeholder="EX.: JOAODASILVA@IGREJACONECTADA.COM" />
                                </fieldset>
                                <fieldset class="coluna">
                                    <input type="button" value="Adicionar" onclick="adicionarEmail();" class="botao" id="btnAddFone" title="Adicionar email"/>
                                </fieldset>
                                <fieldset class="linha" style="margin-top: 10px;">                                                            
                                    <fieldset class="linha" style="height: 150px;">
                                        <div id="div-emails" style="width: 100%; height: 100%; overflow: auto;">Nenhum e-mail adicionado.</div>
                                    </fieldset>
                                </fieldset>
                            </fieldset>
                        </fieldset>
                    </fieldset>
                </div><!--fim tabs-dados-membro -->
                
                <div id="tabs-familia-membro">
                    <fieldset class="linha">
                        <fieldset class="coluna">
                            <label>Qtd. de Filhos</label>
                            <input type="text" class="campoTextoPadrao" style="width: 60px;" value="0" id="txtQuantidadeFilhos" name="PES_QuantidadeFilhos"/>
                        </fieldset>
                    </fieldset>
                    <fieldset style="margin-top: 20px;">
                        <legend>Informe a fam&iacute;lia</legend>
                                                
                        <fieldset class="linha">                                    
                            <fieldset class="coluna">                                    
                                <label>Relacionamento</label>
                                <select class="campoSelect" id="selGrauParentesco"  name="FAM_GrauParentesco"> 
                                    <option value=""></option>
                                    <option value="CÔNJUGE">CÔNJUGE</option>
                                    <option value="FILHO(A)">FILHO(A)</option>                                    
                                    <option value="IRMÃO(Ã)">IRMÃO(Ã)</option>                                    
                                    <option value="MÃE">MÃE</option>                                    
                                    <option value="PAI">PAI</option>                                    
                                </select>
                            </fieldset>
                            
                            <fieldset class="coluna">                                    
                                <label style="margin-bottom: 9px!important;">Tipo do Familiar</label>
                                <div style=" height: 30px; width: 200px;">
                                <input type="radio" name="tipoFamiliar" value="membro" id="radioMembro">Membro&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="tipoFamiliar" value="naoMembro" >Não Membro
                                </div>
                            </fieldset>
                            
                            <fieldset class="coluna" id="fildColunaFamiliarNaoMembro" style=" height: 50px;">
                                <label for="txtNomeFamiliar">Familiar</label>
                                <input type="text" id="txtNomeFamiliar" name="FAM_Nome" class="campoTextoPadrao" style="width: 350px;" placeholder="EX.: JOÃO DA SILVA" />
                            </fieldset>

                            <fieldset class="coluna" id="fildColunaFamiliarMembro" style=" height: 50px;">
                                <div class="side-by-side clearfix">
                                    <label for="selMembroSecundario">Familiar</label>                                
                                    <select data-placeholder="SELECIONE O MEMBRO QUE PERTENCE A FAM&Iacute;LIA." style="width:370px;" class="chosen-select-deselect" id="selMembroSecundario"  name="PES_Secundario_ID" >
                                            <option value=""></option>
                                            <?php
                                                $arrStrFiltros["PES_Status"] = "A";
                                                $arrStrFiltros["MEM_Tipo"] = "MEMBRO";
                                                $arrStrFiltros["GRID"] = true;
                                                //$arrStrFiltros["MembroNaoFuncionario"] = true; //pra trazer mebros que não estão relacionados com funcionários ainda                                                
                                                $arrObjMembro  = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
                                                if($arrObjMembro != null){
                                                    $arrObj = $arrObjMembro["objects"];
                                                    for($intI=0; $intI<count($arrObj); $intI++){
                                                        echo '<option value="'. $arrObj[$intI]->getId().'">   '.$arrObj[$intI]->getNome().$strCPF.'</option>';
                                                    }
                                                }
                                            ?> 
                                    </select>
                                </div>
                            </fieldset>


                            <fieldset class="coluna">
                                <input type="button" value="Adicionar" onclick="addFamiliar();" class="botao" id="btnAddFamiliar"/>
                            </fieldset>
                            

                        </fieldset>
                        
                        <fieldset class="linha">
                            
                        </fieldset>
                        
                        <fieldset class="linha">
                            <div style="overflow: auto; ">
                                <div id="div-grid-familia" style="width: 100%; height: 300px; margin-top: 10px; "><p>Nenhum familiar adicionado.</p></div>
                            </div>
                        </fieldset> 
                    </fieldset>                                            
                </div><!--tabs-familia-membro-->
                
                <div id="tabs-endereco-membro">
                    <fieldset class="linha">
                        <fieldset style="border: 0px;">                            
                            <fieldset class="linha">
                                <label for="txtEnderecoCEP">CEP</label>
                                <input type="text" id="txtEnderecoCEP" name="PES_EnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="_____-___"/>
                                <a href="javascript: void();" onclick="consultarEndereco();">
                                    <img src="../../../modulos/sistema/home/img/botao-pesquisar.png" border="0" align="absmiddle"/>
                                </a>
                                <span id="spnCarregandoCEP"></span>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEnderecoLogradouro">Logradouro</label>
                                <input type="text" id="txtEnderecoLogradouro" name="PES_EnderecoLogradouro" class="campoTextoPadrao"  style="width: 300px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEnderecoNumero">N&uacute;mero</label>
                                <input type="text" id="txtEnderecoNumero" name="PES_EnderecoNumero" class="campoTextoPadrao" style="width: 100px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEnderecoComplemento">Complemento</label>
                                <input type="text" id="txtEnderecoComplemento" name="PES_EnderecoComplemento" class="campoTextoPadrao" style="width: 300px;"/>
                            </fieldset>               
                            <fieldset class="coluna">
                                <label for="txtEnderecoBairro">Bairro</label>
                                <input type="text" id="txtEnderecoBairro" name="PES_EnderecoBairro" class="campoTextoPadrao" style="width: 300px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEnderecoCidade">Cidade</label>
                                <input type="text" id="txtEnderecoCidade" name="PES_EnderecoCidade" class="campoTextoPadrao" style="width: 300px;"/>
                            </fieldset>
                            <fieldset class="linha">
                                <fieldset class="coluna">
                                    <label for="txtEnderecoPontoReferencia">Ponto de refer&ecirc;ncia</label>
                                    <input type="text" id="txtEnderecoPontoReferencia" name="PES_EnderecoPontoReferencia" class="campoTextoPadrao" style="width: 300px;"/>
                                </fieldset>  
                                <fieldset class="coluna" >
                                    <label for="selEnderecoUF">Estado</label>
                                    <?php
                                        echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUF", "PES_EnderecoUf", true);
                                    ?>
                                </fieldset>
                            </fieldset>
                        </fieldset>  
                    </fieldset>
                </div> <!-- tabs-endereco-membro -->
                
                <div id="tabs-dados-empresa-membro"> 
                    <fieldset class="linha">
                        <fieldset class="coluna">
                            <input type="checkbox" id="ckbTemEmprego" value="S" name="MEM_TemEmprego" value="S" />Tem Emprego?
                        </fieldset>
                    </fieldset>
                    <fieldset class="linha">
                        <fieldset style="border:0px;">                                                            
                            <fieldset class="coluna">
                                <label for="txtNomeEmpresa">Nome da empresa</label>
                                <input type="text" id="txtNomeEmpresa" name="MEM_EmpresaNome" placeholder="" class="campoTextoPadrao"  style="width: 330px;"/>
                            </fieldset>    
                            <fieldset class="coluna">
                                <label for="txtEmpresaTelefone">Telefone</label>
                                <input type="text" id="txtEmpresaTelefone" name="MEM_EmpresaTelefoneComercial" placeholder="(__) ____.____" class="campoTextoPadrao"  style="width: 120px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEmpresaFax">Fax</label>
                                <input type="text" id="txtEmpresaFax" name="MEM_EmpresaTelefoneFax" placeholder="(__) ____.____" class="campoTextoPadrao"  style="width: 120px;"/>
                            </fieldset> 
                        </fieldset>
                    </fieldset>
                    <fieldset class="linha">
                        <fieldset class="coluna" style="width: 55%">
                            <fieldset>                    
                                <legend>Profissão do Membro</legend>
                                <fieldset class="coluna">
                                    <div class="side-by-side clearfix">
                                    <label for="selAreaAtuacao">Área de atuação profissional <a href="javascript: void(0);" onclick="openADDAreaAtuacao();" title="Adicionar área de atuação." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                    <select data-placeholder="SELECIONE A &Aacute;REA DE ATUA&Ccedil;&Atilde;O." style="width:250px;" class="chosen-select-deselect" id="selAreaAtuacao"  name="AAT_ID" >                                            
                                    </select>
                                    </div>
                                </fieldset>
                                <fieldset class="coluna">                                
                                    <label for="txtProfissao">Função</label>                                    
                                    <input type="text" id="txtProfissao" name="MEM_Profissao" placeholder="EX.: CARPINTEIRO" class="campoTextoPadrao"  style="width: 300px;"/>                                
                                </fieldset>
                            </fieldset>
                        </fieldset>
                        <fieldset class="coluna" style="width: 44.5%;" >
                            <fieldset>                    
                                <legend>Renda Salarial</legend>
                                <fieldset class="coluna">
                                    <div class="side-by-side clearfix">
                                        <label for="selFaixaSalarial">Faixa de renda salarial <a href="javascript: void(0);" onclick="openADDFaixaSalarial();" title="Adicionar faixa salarial." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                        <select data-placeholder="SELECIONE A FAIXA DE RENDA SALARIAL." style="width:300px;" class="chosen-select-deselect" id="selFaixaSalarial"  name="ARS_ID"  >                                            
                                        </select>
                                    </div>
                                </fieldset>
                            </fieldset>
                        </fieldset>                        
                    </fieldset>
                    <fieldset class="linha">
                        <fieldset>
                        <legend>Endere&ccedil;o da empresa</legend>
                            <fieldset class="linha">
                                <label for="txtEnderecoCEPEmpresa">CEP</label>
                                <input type="text" id="txtEnderecoCEPEmpresa" name="MEM_EmpresaEnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="_____-___"/>
                                <a href="javascript: void();" onclick="consultarEnderecoEmpresa();">
                                    <img src="../../../modulos/sistema/home/img/botao-pesquisar.png" border="0" align="absmiddle"/>
                                </a>
                                <span id="spnCarregandoCEPEmpresa"></span>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEnderecoLogradouroEmpresa">Logradouro</label>
                                <input type="text" id="txtEnderecoLogradouroEmpresa" name="MEM_EmpresaEnderecoLogradouro" class="campoTextoPadrao"  style="width: 335px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtEnderecoNumeroEmpresa">N&uacute;mero</label>
                                <input type="text" id="txtEnderecoNumeroEmpresa" name="MEM_EmpresaEnderecoNumero" class="campoTextoPadrao" style="width: 100px;"/>
                            </fieldset>

                            <fieldset class="coluna">
                                <label for="txtEnderecoComplementoEmpresa">Complemento</label>
                                <input type="text" id="txtEnderecoComplementoEmpresa" name="MEM_EmpresaEnderecoComplemento" class="campoTextoPadrao" style="width: 300px;"/>
                            </fieldset>                            

                            <fieldset class="coluna">
                                <label for="txtEnderecoPontoReferenciaEmpresa">Ponto de referência</label>
                                <input type="text" id="txtEnderecoPontoReferenciaEmpresa" name="MEM_EmpresaEnderecoPontoReferencia" class="campoTextoPadrao" style="width: 335px;"/>
                            </fieldset>                            

                            <fieldset class="coluna">
                                <label for="txtEnderecoBairroEmpresa">Bairro</label>
                                <input type="text" id="txtEnderecoBairroEmpresa" name="MEM_EmpresaEnderecoBairro" class="campoTextoPadrao" style="width: 300px;"/>
                            </fieldset>

                            <fieldset class="linha">
                                <fieldset class="coluna">
                                    <label for="txtEnderecoCidadeEmpresa">Cidade</label>
                                    <input type="text" id="txtEnderecoCidadeEmpresa" name="MEM_EmpresaEnderecoCidade" class="campoTextoPadrao" style="width: 335px;"/>
                                </fieldset>

                                <fieldset class="coluna" >
                                    <label for="selEnderecoUFEmpresa">Estado</label>
                                    <?php
                                        echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUFEmpresa", "MEM_EmpresaEnderecoUf", true);
                                    ?>
                                </fieldset>
                            </fieldset>
                        </fieldset>
                    </fieldset>                        
                </div><!--tabs-dados-empresa-membro -->
                <div id="tabs-dados-eclesiastico-membro">                        
                        
                    <fieldset class="linha">                        
                        <fieldset class="coluna">
                            <label for="selTipoDadoEclesiastico">O membro foi recebido através de</label>                                
                            <select style="width:343px;" id="selTipoDadoEclesiastico"  name="DAM_Tipo" class="campoSelect" onchange="exibirDadoEclesiastico();" >                                
                                <option value="ACLAMAÇÃO">ACLAMAÇÃO</option>
                                <option value="BATISMO" selected="true" >BATISMO</option>
                                <option value="RECONCILIAÇÃO">RECONCILIAÇÃO</option>
                                <option value="TRANSFERÊNCIA">TRANSFERÊNCIA</option>                                
                            </select>                            
                        </fieldset>
                    </fieldset>
                    
                    
                    <fieldset class="linha fildDadoEcle" id="fildAclamacao">                        
                        <label for="txtDataAclamacao">Data Aclamação</label>
                        <input type="text" id="txtDataAclamacao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                    </fieldset>
                    
                    
                    <fieldset class="linha fildDadoEcle" id="fildBatismo">
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label for="txtBatismoData">Data batismo</label>
                                <input type="text" id="txtBatismoData" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtBatismoDataAceito">Data aceito</label>
                                <input type="text" id="txtBatismoDataAceito" name="DAM_DataAceito" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label for="txtBatismoAno">Ano</label>
                                <input type="text" id="txtBatismoAno" name="DAM_Ano" class="campoTextoPadrao" placeholder="EX.: 1999" style="width: 50px;" maxlength=4/>                        
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label for="txtBatismoIgrejaNome">Igreja</label>
                                <input type="text" id="txtBatismoIgrejaNome" name="DAM_IgrejaNome" class="campoTextoPadrao" placeholder="NOME DA IGREJA" style="width: 130px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtBatismoIgrejaPastor">Pastor</label>
                                <input type="text" id="txtBatismoIgrejaPastor" name="DAM_IgrejaPastor" class="campoTextoPadrao" placeholder="NOME DO PASTOR" style="width: 130px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtBatismoIgrejaCidade">Cidade</label>
                                <input type="text" id="txtBatismoIgrejaCidade" name="DAM_IgrejaCidade" class="campoTextoPadrao" placeholder="EX.: RECIFE" style="width: 130px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="selBatismoIgrejaEstado">Estado</label>
                                <?php
                                    echo UFSelectComponente::getInstance()->gerarSigla("selBatismoIgrejaEstado", "DAM_IgrejaUf", true);
                                ?>
                            </fieldset>
                        </fieldset>
                    </fieldset>
                    
                    <fieldset class="linha fildDadoEcle" id="fildReconciliacao">                        
                        <label for="txtDataReconciliacao">Data Reconciliação</label>
                        <input type="text" id="txtDataReconciliacao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                    </fieldset>
                    
                    
                    <fieldset class="linha fildDadoEcle" id="fildTransferencia">
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label for="txtTransferenciaDataSecao">Data sessão</label>
                                <input type="text" id="txtTransferenciaDataSecao" name="DAM_Data" class="campoData" placeholder="__/__/____" style="width: 70px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtTransferenciaDataAceito">Data aceito</label>
                                <input type="text" id="txtTransferenciaDataAceito" name="DAM_DataAceito" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtTransferenciaNumeroAta">Nº da Ata</label>
                                <input type="text" id="txtTransferenciaNumeroAta" name="DAM_DataAceito" class="campoTextoPadrao" style="width: 100px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtTransferenciaIgrejaNome">Igreja</label>
                                <input type="text" id="txtTransferenciaIgrejaNome" name="DAM_IgrejaNome" class="campoTextoPadrao" placeholder="NOME DA IGREJA" style="width: 130px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtTransferenciaIgrejaPastor">Pastor</label>
                                <input type="text" id="txtTransferenciaIgrejaPastor" name="DAM_IgrejaPastor" class="campoTextoPadrao" placeholder="NOME DO PASTOR" style="width: 130px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtTransferenciaIgrejaCidade">Cidade</label>
                                <input type="text" id="txtTransferenciaIgrejaCidade" name="DAM_IgrejaCidade" class="campoTextoPadrao" placeholder="EX.: RECIFE" style="width: 130px;"/>                        
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="selTranseferenciaIgrejaEstado">Estado</label>
                                <?php
                                    echo UFSelectComponente::getInstance()->gerarSigla("selTranseferenciaIgrejaEstado", "DAM_IgrejaUf", true);
                                ?>
                            </fieldset>
                        </fieldset>             
                    </fieldset>
                    
                    
                    <fieldset class="linha">
                        <input type="button" value="Adicionar" onclick="addDadosEclesiasticos();" class="botao" id="btnSalvar"/>
                    </fieldset>
                        
                    <fieldset style=" margin-top: 10px;">
                        <fieldset class="linha">
                            <div style="overflow: auto; ">
                                <div id="div-grid-dados-eclesiasticos" style="width: 100%; height: 200px; margin-top: 10px;" ><p>Nenhum dado eclesiástico adicionado.</p></div>
                            </div>
                        </fieldset>                        
                    </fieldset>
                    
                    <fieldset class="linha" style=" margin-top: 10px;">
                        <div class="side-by-side clearfix">
                            <label for="selUnidade">Sede/Congrega&ccedil;&atilde;o* <a href="javascript: void(0);" onclick="openADDCongregacao();" title="Adicionar congregação." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                            <select data-placeholder="SELECIONE A UNIDADE (SEDE/CONGREGA&Ccedil;&Atilde;O)." style="width:343px;" class="chosen-select-deselect" id="selUnidade"  name="UNI_ID"  >
                                <option value="">SEDE</option>
                                <?php
                                    /*$arrStrFiltros["UNI_Status"] = "A";
                                    $arrObjFaixa  = FachadaCadastro::getInstance()->consultarCongregacao($arrStrFiltros);

                                    if($arrObjFaixa != null){
                                        $arrObj = $arrObjFaixa["objects"];

                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }*/
                                ?>
                            </select>
                        </div>
                    </fieldset>
                   
                    <fieldset class="linha">
                        <fieldset class="coluna" style="height:60px; margin-top: 5px;" >
                            <div class="side-by-side clearfix">
                                <label for="selStatus">Status* <a href="javascript: void(0);" onclick="openADDStatus();" title="Adicionar status." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                <select data-placeholder="SELECIONE O STATUS." style="width:343px;" class="chosen-select-deselect" id="selStatus"  name="MES_ID">
                                </select>
                            </div>
                        </fieldset>
                    </fieldset>
                </div><!--tabs-dados-eclesiastico-membro-->
                                        
                <div id="tabs-dados-atividades-membro" >                        
                    <fieldset class="linha">
                        <fieldset class="coluna" >
                            <div class="side-by-side clearfix">
                            <label for="selAtividade">Atividades Exercidas <a href="javascript: void(0);" onclick="openADDAtividade();" title="Adicionar atividade." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                <select data-placeholder="SELECIONE A ATIVIDADE." style="width:300px;" class="chosen-select-deselect" id="selAtividade"  name="ATV_ID">
                                </select>
                            </div>
                        </fieldset>                            
                        <fieldset class="coluna" >
                            <label for="txtAtividadeDesde">DT. Início</label>
                            <input type="text" id="txtAtividadeDesde" name="ATM_Desde" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>
                        <fieldset class="coluna" >
                            <label for="txtAtividadeAte">DT. Término</label>
                            <input type="text" id="txtAtividadeAte" name="ATM_Ate" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>                            
                        <fieldset class="coluna" >
                            <input type="checkbox" id="ckbTarefaAual" onclick="gerenciarAtividadeAtual();"/>Atividade atual?
                        </fieldset>
                        <fieldset class="coluna">
                            <input type="button" value="Adicionar" onclick="addAtividade();" class="botao" id="btnSalvar"/>
                        </fieldset>
                    </fieldset>
                    <fieldset class="linha">
                        <div style="overflow: auto; ">
                            <div id="div-grid-tarefa" style="width: 100%; height: 300px; margin-top: 10px;" ><p>Nenhuma atividade adicionada.</p></div>
                        </div>
                    </fieldset>                        
                </div><!-- tabs-dados-atividades-membro -->
                
                
                
                
                <div id="tabs-dados-ministerios-membro" >                        
                    <fieldset class="linha">                        
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selAreaMinisterial">Área Ministerial</label>                                
                                <select data-placeholder="ÁREA MINISTERIAL" style="width:250px;" class="chosen-select-deselect" id="selAreaMinisterial" name="AMI_ID" onchange="getMinisterios()">                                
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros["AMI_Status"] = "A";
                                        $arrObjFaixa  = FachadaCadastro::getInstance()->consultarAreaMinisterial($arrStrFiltros);
                                        if($arrObjFaixa != null){
                                            $arrObj = $arrObjFaixa["objects"];
                                            for($intI=0; $intI<count($arrObj); $intI++){
                                               echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="coluna" >
                            <div class="side-by-side clearfix">
                            <label for="selMinisterio">Ministérios <a href="javascript: void(0);" onclick="openAddMinisterio();" title="Adicionar atividade." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                <select data-placeholder="SELECIONE O MINISTÉRIO." style="width:300px;" class="chosen-select-deselect" id="selMinisterio"  name="MIN_ID">
                                </select>
                            </div>
                        </fieldset>                            
                        
                        
                        
                        <fieldset class="coluna" >
                            <label for="txtMinisterioDesde">DT. Início</label>
                            <input type="text" id="txtMinisterioDesde" name="MMI_Desde" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>
                        <fieldset class="coluna" >
                            <label for="txtMinisterioAte">DT. Término</label>
                            <input type="text" id="txtMinisterioAte" name="MMI_Ate" class="campoData" placeholder="__/__/____" style="width: 70px;"/>
                        </fieldset>                            
                        <fieldset class="coluna" >
                            <input type="checkbox" id="ckbMinisterioAual" onclick="gerenciarMinisterioAtual();"/>Ministério atual?
                        </fieldset>
                        <fieldset class="coluna">
                            <input type="button" value="Adicionar" onclick="addMinisterio();" class="botao" id="btnSalvar"/>
                        </fieldset>
                    </fieldset>
                    <fieldset class="linha">
                        <div style="overflow: auto; ">
                            <div id="div-grid-ministerio" style="width: 100%; height: 300px; margin-top: 10px;" ><p>Nenhuma ministério adicionado.</p></div>
                        </div>
                    </fieldset>                        
                </div><!-- tabs-dados-ministerios-membro -->

                <div id="tabs-dados-processo-desligamento-membro">
                    <fieldset class="linha">
                        <fieldset class="coluna">
                            <label for="txtDataDesligamento">Data</label>
                            <input type="text" id="txtDataDesligamento" name="PCD_Data" class="campoData" placeholder="__/__/____" style="width: 60px;"/>
                        </fieldset>
                        
                        <fieldset class="coluna">
                            <label for="txtDescricaoProcedimento">Descrição do procedimento</label>
                            <input type="text" id="txtDescricaoProcedimento" name="PCD_Descricao" class="campoTextoPadrao" placeholder="EX.: MORANDO EM OUTRO ESTADO OU 02 ANOS SEM CONTATO - ENVIAMOS UMA CARTA HOJE" style="width: 640px;" />
                        </fieldset>
                        <fieldset class="coluna">
                            <input type="button" value="Adicionar" onclick="addProcessoDesligamento();" class="botao" id="btnSalvar"/>
                        </fieldset>
                    </fieldset>
                    
                    <fieldset class="linha">
                        <div style="overflow: auto; ">
                            <div id="div-grid-processo-desligamento" style="width: 100%; height: 200px; margin-top: 10px;" ><p>Nenhum procedimento adicionado.</p></div>
                        </div>
                    </fieldset>
                                        
                    <fieldset class="linha">
                        <fieldset class="coluna" style="height: 50px; ">
                            <fieldset class="coluna" style="margin-top: 28px; ">
                                <input type="checkbox" id="ckbFalecimento" value="S" name="PES_Falecimento" onclick="gerenciarDataFalecimento();"/>Inativar?
                            </fieldset>
                            <fieldset class="linha" id="divDataFalecimento" style="padding: 5px; margin-top: 10px; border: 1px solid #F4F4F4;" > 
                                <legend>Sobre a Inativação</legend>
                                <!--DT. Falecimento <input type="text" id="txtDataFalecimento" name="PES_DataFalecimento" class="campoData" placeholder="__/__/____" style="width: 70px;"/>-->
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label>Data de Inativação*</label>
                                        <input type="text" class="campoData" value="" placeholder="__/__/____" name="MEM_DataInativacao" id="txtDataInativacao"/>
                                    </fieldset>
                                    <fieldset class="coluna">                                        
                                        <div class="side-by-side clearfix">
                                            <label>Motivo de Inativação*</label>
                                            <select data-placeholder="SELECIONE O MOTIVO." style="width:200px;" class="chosen-select-deselect" id="selMotivoInativacao" name="MEM_MotivoInativacao" onchange="gereciarMotivoInativacao();">
                                                <option value="TRANSFERENCIA">TRANSFERÊNCIA</option>
                                                <option value="ABANDONO">ABANDONO</option>
                                                <option value="FALECIMENTO">FALECIMENTO</option>
                                                <option value="DESAPARECIMENTO">DESAPARECIMENTO</option>
                                                <option value="OUTRO">OUTRO</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </fieldset>
                                <fieldset class="linha">
                                    <fieldset class="coluna" id="fieldsetDescricaoInativacao">
                                        <label id="labDescricaoInativacao">Nome da Igreja</label>
                                        <input type="text" class="campoTextoPadrao" style="width: 323px;" name="MEM_DescricaoInativacao" id="txtDescricaoInativacao"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label>Data</label>
                                        <input type="text" class="campoData" name="MEM_DataDescricaoInativacao" id="txtDataDescricaoInativacao" placeholder="__/__/____"/>
                                    </fieldset>
                                </fieldset>
                            </fieldset>
                            <br/>
                        </fieldset>
                    </fieldset>                    
                </div><!-- fim proc. desligamento -->
                
                <div id="tabs-dados-outros">                        
                    <fieldset class="linha">              
                        <fieldset style="border: 0px; height: 300px;">
                            <label>Anotações</label>                        
                            <textarea id="txtObservacao" name="PES_Observacao" rows="4" class="campoTextoPadrao" style="width: 98%; height:85%"></textarea>                                
                        </fieldset>
                    </fieldset>
                </div><!-- fim tabs-dados-outros -->
                
                </div><!--fim tabs-dados -->
                
                <fieldset class="linha">
                    <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/>
                    <input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                </fieldset>
            </form> 
            
            <div id="dialog-gerencia-foto" title="Gerenciar foto">
                <form id="frmFoto" method="POST" onSubmit="return false;">                                
                    <div id="tabs-foto"  >
                        <ul>
                            <li><a href="#tabs-tirar-foto">Tirar foto</a></li>
                            <li><a href="#tabs-importar-foto">Importar foto</a></li>
                        </ul>                        
                        <div id="tabs-tirar-foto">
                            <div style=" height:440px; width: 100%;">                            
                                <table border="0" cellpadding="5" cellspacing="0" width="100%" height="100%" align="center">
                                    <tr height="50px">
                                        <td width="50%" valign="middle" height="5%" align="left">
                                            <legend>Nova foto</legend>                                        
                                        </td>
                                        <td width="50%" valign="middle" height="5%" align="left">
                                            <legend>Tirar foto</legend>                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="330px" valign="middle" height="95%" align="center">                                        
                                            <div id="fotoTirada">
                                                <img  src="../../../modulos/sistema/home/img/sem-foto.png"  width='330' height='300' />
                                            </div>
                                        </td>
                                        <td width="330px" valign="middle" height="95%" align="center">                                        
                                            <div id="div-camera" style=" margin-left: 15px; height:300px;	width: 330px; float: left;"></div>                                
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>

                        <div id="tabs-importar-foto">                        

                            <table border="0" cellpadding="5" cellspacing="0" width="100%" height="440px" align="center">

                                <tr height="50px">
                                    <td colspan="2">
                                        <legend>Foto com 330px X 300px, com no máximo 1MB</legend>
                                        <input type="file" name="FUN_Imagem" id="fileImagem" class="file" accept="image/*" />
                                    </td>
                                </tr>


                                <tr>
                                    <td width="50%" valign="middle" height="5%" align="left">
                                        <legend>Nova foto</legend>
                                    </td>
                                    <td width="50%" valign="middle" height="5%" align="left">
                                        <legend>Foto existente</legend>                                     
                                    </td>
                                </tr>

                                <tr>
                                    <td width="50%" valign="middle" height="95%" align="center">                                        
                                        <div id="div-foto-nova">
                                            <center>
                                                <img  src="../../../modulos/sistema/home/img/semFoto.png"  width='330' height='300' />
                                            </center>
                                        </div>
                                    </td>
                                    <td width="50%" valign="middle" height="95%" align="center">

                                        <div id="div-foto-existente">
                                            <center>
                                                <img src="../../../modulos/sistema/home/img/semFoto.png" class="fotoTirada" width='330' height='300' />
                                            </center>
                                        </div>                               
                                    </td>
                                </tr>
                            </table>                                           
                        </div>
                    </div> 
                </form>
            </div>           
        </div>      
    </div>    
    <script type="text/javascript">
        init();        
    </script>
</body>
</html>